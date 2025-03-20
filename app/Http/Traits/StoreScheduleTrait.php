<?php

namespace App\Http\Traits;

use Carbon\Carbon;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\UniformPriceItem;
use Illuminate\Database\Eloquent\Model;

trait StoreScheduleTrait
{
    public function getStoreSchedule($dateToday = null): array
    {
        $date = Carbon::parse($dateToday); // Ensure correct date format
        $startOfWeek = $date->copy()->startOfWeek(Carbon::MONDAY); // Monday of the given week
        $endOfWeek = $startOfWeek->copy()->addDays(6); // Saturday of the same week

        $defaultSchedules = collect([
            0 => (object) ['day' => 'Monday', 'from' => '08:00 AM', 'to' => '05:00 PM', 'is_closed' => 0],
            1 => (object) ['day' => 'Tuesday', 'from' => '08:00 AM', 'to' => '05:00 PM', 'is_closed' => 0],
            2 => (object) ['day' => 'Wednesday', 'from' => '08:00 AM', 'to' => '05:00 PM', 'is_closed' => 0],
            3 => (object) ['day' => 'Thursday', 'from' => '08:00 AM', 'to' => '05:00 PM', 'is_closed' => 0],
            4 => (object) ['day' => 'Friday', 'from' => '08:00 AM', 'to' => '05:00 PM', 'is_closed' => 0],
            5 => (object) ['day' => 'Saturday', 'from' => '08:00 AM', 'to' => '05:00 PM', 'is_closed' => 0], // Default Saturday
            6 => (object) ['day' => 'Sunday', 'from' => null, 'to' => null, 'is_closed' => 1] // Closed
        ]);

        $customSchedules = Schedule::whereBetween('day', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])->get();

        // 2. Filter custom schedules within the current week
        $filteredCustomSchedules = $customSchedules->filter(function ($schedule) use ($startOfWeek, $endOfWeek) {
            $scheduleDate = Carbon::parse($schedule->day);
            return $scheduleDate->between($startOfWeek, $endOfWeek);
        })->keyBy(function ($schedule) {
            return Carbon::parse($schedule->day)->dayOfWeek - 1; // Convert date to week index (0 = Monday)
        });


        // 3. Merge custom schedules into default schedules
        $finalSchedules = $defaultSchedules->map(function ($default, $index) use ($filteredCustomSchedules) {
            return $filteredCustomSchedules->has($index) ? $filteredCustomSchedules->get($index) : $default;
        });


        // 4. Convert final schedules for display
        return $finalSchedules->map(function ($schedule, $index) {
            return Carbon::now()->startOfWeek()->addDays($index)->format('l') . ': ' .
                ($schedule->is_closed ? 'Closed' : Carbon::parse($schedule->from)->format('g:i A') . ' - ' . Carbon::parse($schedule->to)->format('g:i A'));
        })->toArray();
    }
}
