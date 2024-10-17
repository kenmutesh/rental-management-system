<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'name' => $this->tenant->name ?? " ",
            'message' => $this->message ?? " ",
            'status' => $this->response_description ?? '',
            'created_at' => $this->created_at->format('d/m/Y') ?? " ",
        ];
    }
}
