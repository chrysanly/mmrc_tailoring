<?php

namespace App\Http\Services;

use App\Http\Resources\SaleReportResource;
use App\Models\OrderPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardSalesReport
{
    public function salesReport(Request $request)
    {
        $range =  $request->rangeType;

        $query = OrderPayment::query();

        $query->whereYear('created_at', $request->year);


        if ($range === 'weekly') {
            return $this->weeklyReport($query, $request);
        }
        if ($range === 'monthly') {
            return $this->monthlyReport($query, $request);
        }

        if ($range === 'today') {
            return $this->dailyReport($query);
        }

        return [];
    }

    private function weeklyReport($query, $request)
    {
        $startOfWeek = $request->startofWeek;
        $endOfWeek = $request->endofWeek;
        // Initialize the array with days of the week
        $weekData = [
            'sunday' => 0,
            'monday' => 0,
            'tuesday' => 0,
            'wednesday' => 0,
            'thursday' => 0,
            'friday' => 0,
            'saturday' => 0,
        ];

        // Query to calculate sums for the week
        $query->selectRaw('DATE(created_at) as date, SUM(amount) as total_amount')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek]) // Filter by this week's range
            ->groupBy('date') // Group by each day in the week
            ->orderBy('date')
            ->get()
            ->each(function ($item) use (&$weekData) {
                $dayName = strtolower(date('l', strtotime($item->date))); // Get the day name
                $weekData[$dayName] = (float) $item->total_amount; // Assign total amount to the corresponding day
            });

        $labels = array_map('ucfirst', array_keys($weekData)); // Capitalize day names for the chart
        $data = array_values($weekData); // Get the numeric values for each day

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    private function monthlyReport($query, $request)
    {
        $startOfWeek = $request->startofWeek;
        $endOfWeek = $request->endofWeek;
        // Set up the query to get data grouped by month
        $monthlyData = $query->selectRaw('MONTH(created_at) as month, SUM(amount) as total_amount')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek]) // Filter by this week's range
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                // Convert numeric month to full month name
                $item->month = date('F', mktime(0, 0, 0, $item->month, 1)); // Example: 'January', 'February'
                return $item;
            });

        // Initialize labels and data arrays
        $labels = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];
        $data = array_fill(0, 12, 0); // Pre-fill data array with zeros (12 months)

        // Populate data based on fetched results
        foreach ($monthlyData as $item) {
            $monthIndex = array_search($item->month, $labels); // Find the index of the month
            if ($monthIndex !== false) {
                $data[$monthIndex] = (float) $item->total_amount; // Update the total amount for the month
            }
        }


        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    private function dailyReport($query)
    {
        // Get the current date
        $today = Carbon::now()->toDateString(); // Format: 'YYYY-MM-DD'

        // Query to get the orders for today, grouped by the time of the order
        $todayData = $query->selectRaw('TIME(created_at) as time, SUM(amount) as total_amount') // Extract the full time
            ->whereDate('created_at', $today) // Filter by today's date
            ->groupBy('time') // Group by the time instead of just the hour
            ->orderBy('time') // Order by the time
            ->get()
            ->map(function ($item) {
                // Convert the time to UTC+8 timezone
                $item->time = Carbon::createFromFormat('H:i:s', $item->time, 'UTC') // Create Carbon instance for full time
                    ->setTimezone('Asia/Manila') // Convert to Philippines timezone
                    ->format('g:i A'); // Format the time as '12-hour time with AM/PM'

                return $item;
            });

        // Initialize labels and data arrays
        $labels = [];
        $data = [];

        // Populate labels and data arrays
        foreach ($todayData as $item) {
            $labels[] = $item->time; // Add the formatted time as a label
            $data[] = $item->total_amount; // Add the total amount as data
        }

        // Return or debug the result
        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }
}
