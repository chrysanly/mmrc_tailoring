<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleReportResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        parent::toArray($request);
        
        if ($request->range === 'year') {
            return [
                'year' => $this->year,
                'amount' => $this->total_amount,
            ];
        }
        if ($request->range === 'week') {
            return $this->week;
        }

        return [
            'month' => $this->month,
            'amount' => $this->total_amount,
        ];
       
    }
}
