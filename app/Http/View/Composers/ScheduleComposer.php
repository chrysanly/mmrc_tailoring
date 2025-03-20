<?php

namespace App\Http\View\Composers;

use App\Http\Traits\StoreScheduleTrait;
use Carbon\Carbon;
use App\Models\Schedule;
use Illuminate\View\View;
use App\Models\Appointment;
use Illuminate\Support\Facades\Cache;

class ScheduleComposer
{
    use StoreScheduleTrait;
    public function compose(View $view)
    {
        $dateToday = now()->toDateString();
        $date = Carbon::parse($dateToday); // Ensure correct date format
        $startOfWeek = $date->copy()->startOfWeek(Carbon::MONDAY); // Monday of the given week
        $endOfWeek = $startOfWeek->copy()->addDays(6);
        $formattedWeek = $startOfWeek->format('F j') . ' - ' . $endOfWeek->format('j');

        $cacheKey = 'store_schedule_' . $startOfWeek->format('Y_W'); // e.g., "store_schedule_2025_10"

        $storeSchedule = Cache::remember($cacheKey, now()->endOfWeek(), function () use($dateToday) {
            return $this->getStoreSchedule($dateToday);
        });
        
        $view->with([
            'scheduleTitle' => $formattedWeek,
            'storeSchedule' => $storeSchedule,
        ]);
    }
}
