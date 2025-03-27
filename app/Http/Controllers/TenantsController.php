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
        DB::beginTransaction();

        try {
            // Tenant creation logic
            $tenant = Tenant::create([
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'account_number' => $request->account_number,
                'lease_start_date' => $request->lease_start_date,
                'lease_end_date' => $request->lease_end_date,
                'id_number' => $request->id_number,
                'kra_pin' => $request->kra_pin,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'marital_status' => $request->marital_status,
                'city' => $request->city,
                'county' => $request->county,
                'postal_code' => $request->postal_code,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
                'emergency_contact_relationship' => $request->emergency_contact_relationship,
            ]);


            $unit = Units::find($request->unit_id);

            if (!$unit) {
                DB::rollBack();
                return redirect()->route('tenants.create')->with([
                    'message' => 'Unit not found',
                    'type' => 'error',
                ]);
            }



            $unit->occupied_by = $tenant->id;
            $unit->save();

            $tenant_account = TenantAccounts::where('account_number', $request->accountNumber ?? $request->phone)->first();

            if ($tenant_account) {
                $tenant_account->balance = 0;
                $tenant_account->save();
            } else {
                $tenant_account = TenantAccounts::create([
                    'account_number' => $request->accountNumber ?? $request->phone,
                    'balance' => 0,
                ]);
            }

            DB::commit();

            return redirect()->route('tenants.index')->with([
                'message' => 'Tenant created successfully',
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('tenants.create')->with([
                'message' => 'Error creating tenant',
                'type' => 'error',
            ]);
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
