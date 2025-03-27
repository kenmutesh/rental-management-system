<?php

namespace App\Http\Resources;

use App\Models\TenantAccounts;
use App\Models\Tenants;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TenantsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->first_name . ' ' . $this->last_name    ,
            'email' => $this->email,
            'phone' => $this->phone,
            'balance' => $this->balance,
            'account_balance' => $this->account_balance(),
        ];
    }

    private function account_balance()
    {
        $tenant_account = TenantAccounts::where('account_number', $this->account_number ?? $this->phone)->first();

        return number_format($tenant_account->balance, 2);
    }
}
