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
            'id'                => $this->id,
            'propertyName'      => $this->propertyName,
            'totalUnits'        => $this->totalUnits,
            'vacancies'         => $this->getVacancies(),
            'city'              => $this->city,
            'units'             => UnitsResource::collection($this->units) ?? '',
            'waterRate'         => $this->waterRate,
            'electricityRate'   => $this->electricityRate,
            'penaltyPercentage' => $this->penaltyPercentage,
            'streetName'        => $this->streetName,
            'paymentUnstructions'=> $this->paymentUnstructions,
        ];
    }


    private function getVacancies()
    {
        return $this->units()->whereNull('occupied_by')->count();
    }
}
