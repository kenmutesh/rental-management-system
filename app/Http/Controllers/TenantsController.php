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
            // Calculate discounted rent if applicable
            $rentAmount = $request->rentAmount;
            $discountedRent = $rentAmount;

            if ($request->applyDiscount) {
                if ($request->discountType === 'percentage') {
                    $discountedRent = $rentAmount * (1 - ($request->discountValue / 100));
                } else {
                    $discountedRent = max(0, $rentAmount - $request->discountValue);
                }
            }

            // Tenant creation logic
            $tenant = Tenants::create([
                'first_name' => $request->firstName,
                'last_name' => $request->lastName,
                'email' => $request->email,
                'phone' => $request->phone,
                'id_number' => $request->id_number,
                'kra_pin' => $request->kraPin,
                'employer_name' => $request->employerName,
                'job_title' => $request->jobTitle,
                'monthly_income' => $request->monthlyIncome,
                'property_id' => $request->property_id,
                'unit_id' => $request->unit_id,
                'lease_start_date' => $request->lease_start_date,
                'rent_amount' => $discountedRent,
                'security_deposit' => $request->securityDeposit,
                'advance_rent' => $request->rentAmount, // Advance rent is same as original rent amount
                'payment_method' => $request->paymentMethod,
                'apply_discount' => $request->applyDiscount,
                'discount_type' => $request->applyDiscount ? $request->discountType : null,
                'discount_value' => $request->applyDiscount ? $request->discountValue : null,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
                'notes' => $request->notes,
                'account_number' => $request->accountNumber ?? $request->phone,
                'address' => $request->address,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'marital_status' => $request->marital_status,
                'city' => $request->city,
                'county' => $request->county,
                'postal_code' => $request->postal_code,
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

            // Handle tenant account
            $tenant_account = TenantAccounts::where('account_number', $request->accountNumber ?? $request->phone)->first();

            if ($tenant_account) {
                $tenant_account->balance = 0;
                $tenant_account->save();
            } else {
                TenantAccounts::create([
                    'account_number' => $request->accountNumber ?? $request->phone,
                    'balance' => 0,
                ]);
            }

            // Handle file uploads
            if ($request->hasFile('idCopy')) {
                $tenant->addMedia($request->file('idCopy'))
                    ->toMediaCollection('id_copy');
            }

            if ($request->hasFile('kraPinCopy')) {
                $tenant->addMedia($request->file('kraPinCopy'))
                    ->toMediaCollection('kra_pin_copy');
            }

            if ($request->hasFile('employmentLetter')) {
                $tenant->addMedia($request->file('employmentLetter'))
                    ->toMediaCollection('employment_letter');
            }

            if ($request->hasFile('payslips')) {
                foreach ($request->file('payslips') as $file) {
                    $tenant->addMedia($file)
                        ->toMediaCollection('payslips');
                }
            }

            if ($request->hasFile('bankStatements')) {
                foreach ($request->file('bankStatements') as $file) {
                    $tenant->addMedia($file)
                        ->toMediaCollection('bank_statements');
                }
            }

            if ($request->hasFile('references')) {
                foreach ($request->file('references') as $file) {
                    $tenant->addMedia($file)
                        ->toMediaCollection('references');
                }
            }

            DB::commit();

            return redirect()->route('tenants.index')->with([
                'message' => 'Tenant created successfully',
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('tenants.create')->with([
                'message' => 'Error creating tenant: ' . $e->getMessage(),
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
