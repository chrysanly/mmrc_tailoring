<?php


namespace App\Http\Traits;

use Carbon\Carbon;
use App\Models\Settings;
use App\Models\Appointment;

trait AvailableTimeTrait
{
    public function execute($request)
    {
        $data = $request->date;
        $appointmentDate = Carbon::parse($request->date);
        $appointments = Appointment::where('date', $data)
            ->whereNull('cancelled_at')
            ->get()->pluck('time')->toArray();

        // Start time and End time for the appointment slots
        $storeSchedule = $this->getStoreSchedule($appointmentDate->toDateString());

        $currentDay = Carbon::now()->format('l'); // 'l' gives the full name of the day, like "Monday", "Tuesday", etc.

        $currentDaySchedule = collect($storeSchedule)->first(function ($schedule) use ($currentDay) {
            return strpos($schedule, $currentDay) === 0; // Check if the schedule starts with the current day
        });

        $currentDayTimeRange = trim(explode(':', $currentDaySchedule, 2)[1]);
        [$open, $close] = explode('-', str_replace(' ', '', $currentDayTimeRange));

        $interval = (int) Settings::where('module', 'appointment_time_limit')->first()->limit;;
        $timeSlots = $this->generateTimeIntervals($open, $close, $interval);

        $data = [];
        foreach ($timeSlots as $slot) {
            $status = in_array($slot, $appointments) ? 'not available' : 'available';
            $data[] = [
                'time' => $slot,
                'status' => $status,
            ];
        }
        return $data;
    }

    private function generateTimeIntervals($start, $end, $interval)
    {
        $startTime = Carbon::createFromFormat('g:iA', $start);
        $endTime = Carbon::createFromFormat('g:iA', $end); // Do not add a day here

        $timeSlots = [];

        while ($startTime->lt($endTime)) { // Ensure it only generates until the end time
            $slotStart = $startTime->format('g:iA');
            $slotEnd = $startTime->copy()->addMinutes($interval)->format('g:iA');

            if ($startTime->copy()->addMinutes($interval)->gt($endTime)) {
                break; // Stop when adding the interval exceeds the end time
            }

            $timeSlots[] = "$slotStart - $slotEnd";
            $startTime->addMinutes($interval);
        }

        return $timeSlots;
    }
}