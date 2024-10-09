<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'propertyName'      => $this->propertyName,
            'totalUnits'        => $this->totalUnits,
            'city'              => $this->city,
            'waterRate'         => $this->waterRate,
            'electricityRate'   => $this->electricityRate,
            'penaltyPercentage' => $this->penaltyPercentage,
            'streetName'        => $this->streetName,
            'paymentUnstructions'=> $this->paymentUnstructions,
        ];
    }
}
