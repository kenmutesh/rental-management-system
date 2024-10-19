<?php

namespace App\Http\Controllers;

use App\Http\Requests\TenantRequest;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\PropertyResource;
use App\Http\Resources\TenantsResource;
use App\Models\Invoices;
use App\Models\Property;
use App\Models\Tenants;
use App\Models\Units;
use App\SmsTenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TenantsController extends Controller
{
    use SmsTenant;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Tenants::query();

        if ($request->has('search') && !empty($request->search)) {
            $query = $this->applySearch($query, $request->search);
        }

        $totalTenants = Tenants::all()->count();

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
        $properties = Property::with('units')
                    ->get();

        return Inertia::render('Tenants/Create', [
            'properties' => PropertyResource::collection($properties)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TenantRequest $request)
    {
        DB::beginTransaction();

        try {
            $tenant = Tenants::create([
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => 'test',
                'account_number' => $request->accountNumber,
                'lease_start_date' => $request->leaseStartDate,
                'balance' => 0,
            ]);

            $unit = Units::find($request->unit_id);

            if (!$unit) {
                DB::rollBack();
                return response()->json(['error' => 'Unit not found'], 404);
            }

            $unit->occupied_by = $tenant->id;
            $unit->save();

            // $this->sendSmsToTenant($request, 'welcome');

            DB::commit();

            return to_route('tenants.index')->with('message', 'Tenant created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('tenants.create')->with('message', 'Error creating tenant');

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
