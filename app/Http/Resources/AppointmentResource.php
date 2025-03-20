<?php

namespace App\Http\Resources;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'date' => $this->date,
            'count' => $this->appointments->count(),
            'schedules' => $this->appointments->map(fn($appointment) => [
                'time_from' => Carbon::parse($appointment->time_from)->format('g:i A'),
                'time_to' => Carbon::parse($appointment->time_to)->format('g:i A'),
                'status' => $appointment->status,
                'my_appointment' => $appointment->user_id === auth()->id(),
            ]),
        ];
    }
}
