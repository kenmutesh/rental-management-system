<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use function Ramsey\Uuid\v1;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'  => $this->id,
            'amount' => $this->amount,
            'tenant_id' => $this->tenant->id,
            'tenantName' => $this->tenant->firstName,
            'unit' => $this->unit->name,
            'date' => $this->created_at->format('Y-m-d'),
            'month' => DateTime::createFromFormat('!m', $this->invoice_month)->format('M') . ' - ' . $this->invoice_year

            // 'property_id' => $this->property->id,
            // 'propertyName' => $this->property->propertyName,
        ];
    }
}
