<?php

namespace App\Http\Controllers;

use App\Http\Requests\TenantRequest;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\PropertyResource;
use App\Http\Resources\TenantsResource;
use App\Models\Invoices;
use App\Models\Property;
use App\Models\TenantAccounts;
use App\Models\Tenants;
use App\Models\Units;
use App\SmsTenant;
use App\Traits\InvoicingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TenantsController extends Controller
{
    use SmsTenant, InvoicingTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        // Get properties assigned to the logged-in user
        $propertyIds = $user->properties->pluck('id')->toArray();

        // Query tenants in the user's properties through their unit and property relationship
        $query = Tenants::whereHas('unit.property', function ($query) use ($propertyIds) {
            $query->whereIn('id', $propertyIds);
        });

        // Apply search filter if search term is provided
        if ($request->has('search') && !empty($request->search)) {
            $query = $this->applySearch($query, $request->search);
        }

        $totalTenants = $query->count();
        $tenants = $query->paginate(10);

        return Inertia::render('Tenants/Index', [
            'tenants' => TenantsResource::collection($tenants),
            'search' => $request->search,
            'page' => $request->page,
            'totalTenants' => $totalTenants
        ]);
    }


    private function applySearch($query, $search)
    {
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('firstName', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        return $query;
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();

        $properties = $user->properties()->with('units')->get();

        return Inertia::render('Tenants/Create', [
            'properties' => PropertyResource::collection($properties)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TenantRequest $request)
    {
//        DB::beginTransaction();

//        try {
            // Create tenant
            $tenant = Tenants::create($this->prepareTenantData($request));


            $unit = Units::findOrFail($request->unit_id);
            $unit->update(['occupied_by' => $tenant->id]);
dd($unit);
            // Setup tenant account
            $this->setupTenantAccount($tenant, $request);

            // Create initial invoices
            $this->createInitialInvoices($tenant);

            // Handle documents
            $this->handleDocuments($tenant, $request);

            DB::commit();

            return redirect()->route('tenants.index')
                ->with('success', 'Tenant created with invoices generated');

//        } catch (\Exception $e) {
//            DB::rollBack();
//            return back()->with('error', 'Error: ' . $e->getMessage());
//        }
    }

    protected function prepareTenantData(TenantRequest $request): array
    {
        $data = $request->validated();
        $data['rent_amount'] = $this->calculateDiscountedRent($request);
        $data['account_number'] = $request->accountNumber ?? $request->phone;
        return $data;
    }

    protected function calculateDiscountedRent(TenantRequest $request): float
    {
        $rent = $request->rentAmount;

        if (!$request->applyDiscount) {
            return $rent;
        }

        return $request->discountType === 'percentage'
            ? $rent * (1 - ($request->discountValue / 100))
            : max(0, $rent - $request->discountValue);
    }

    protected function setupTenantAccount(Tenants $tenant, TenantRequest $request): void
    {
        TenantAccounts::updateOrCreate(
            ['account_number' => $tenant->account_number],
            ['balance' => 0]
        );
    }

    protected function handleDocuments(Tenant $tenant, TenantRequest $request): void
    {
        $collections = [
            'idCopy' => 'id_copy',
            'kraPinCopy' => 'kra_pin_copy',
            'employmentLetter' => 'employment_letter',
            'payslips' => 'payslips',
            'bankStatements' => 'bank_statements',
            'references' => 'references',
        ];

        foreach ($collections as $field => $collection) {
            if ($request->hasFile($field)) {
                $files = is_array($request->file($field))
                    ? $request->file($field)
                    : [$request->file($field)];

                foreach ($files as $file) {
                    $tenant->addMedia($file)->toMediaCollection($collection);
                }
            }
        }
    }
    /**
     * Display the specified resource.
     */
    public function invoices(Tenants $tenant)
    {

        $invoices = Invoices::where('tenant_id', $tenant->id)->paginate(10);

        return Inertia::render('Tenants/Invoices', [
            'tenant' => $tenant,
            'invoices' => InvoiceResource::collection($invoices)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenants $tenants)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenants $tenants)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenants $tenants)
    {
        //
    }
}
