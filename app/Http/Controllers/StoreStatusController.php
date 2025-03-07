<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OpeningHour;
use Carbon\Carbon;

class StoreStatusController extends Controller
{
    /**
     * Return status of Store
     */
    public function status() {

        $now = Carbon::now();
        $day = $now->format('l');
        $time = $now->format('H:i:s');
    
        $currentStatus = OpeningHour::where('day', $day)
            ->whereTime('open_time', '<=', $time)
            ->whereTime('close_time', '>=', $time)
            ->where(function ($query) use ($time) {
                $query->whereNull('lunch_start')
                    ->orWhere(function ($q) use ($time) {
                        $q->whereTime('lunch_start', '>', $time)
                          ->orWhereTime('lunch_end', '<', $time);
                    });
            })
            ->first();
    
        if ($currentStatus) {
            return response()->json(['is_open' => true, 'next_opening_time' => null]);
        } else {
            $lunchBreak = OpeningHour::where('day', $day)
                ->whereTime('lunch_start', '<=', $time)
                ->whereTime('lunch_end', '>=', $time)
                ->first();

            if ($lunchBreak) {
                $nextOpeningTime = Carbon::parse($lunchBreak->lunch_end);
                $timeRemaining = $now->diff($nextOpeningTime)->format('%h hours and %i minutes');
        
                return response()->json([
                    'is_open' => false,
                    'next_opening_time' => $lunchBreak->lunch_end,
                    'time_remaining' => $timeRemaining,
                    'reason' => 'Lunch Break'
                ]);
            }
            // Find next opening time after current time
            $nextOpening = OpeningHour::where('day', $day)
            ->whereTime('open_time', '>', $time)
            ->orderBy('open_time')
            ->first();

            // If no more openings today, find the next available opening day
            if (!$nextOpening) {
                $nextOpening = OpeningHour::whereTime('open_time', '>', '00:00:00')
                    ->orderByRaw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
                    ->orderBy('open_time')
                    ->first();
            }

            // Calculate time remaining until next opening
            $timeRemaining = null;
            if ($nextOpening) {
                $nextOpeningTime = Carbon::parse($nextOpening->open_time);
                $timeRemaining = $now->diff($nextOpeningTime)->format('%h hours and %i minutes');
            }

            return response()->json([
                'is_open' => false,
                'next_opening_time' => $nextOpening->open_time ?? 'No upcoming openings',
                'time_remaining' => $timeRemaining,
                'reason' => 'Closed'
            ]);
        }
    }

    /**
     * Check Store Status
     */
    public function checkStoreStatus(Request $request) {
        $selectedDate = Carbon::parse($request->input('date'));
        $day = $selectedDate->format('l');
        $weekNumber = $selectedDate->weekOfYear;
        $time = $selectedDate->format('H:i:s');
    
        // Check if it's a normal opening day (Monday, Wednesday, Friday)
        $openingHour = OpeningHour::where('day', $day)->first();
    
        // Special condition for every other Saturday
        $isEveryOtherSaturday = ($day === 'Saturday' && $weekNumber % 2 !== 0); // Open on odd weeks only
    
        if ($openingHour && $isEveryOtherSaturday) {
            return response()->json([
                'message' => "We will be OPEN on " . $day,
                'is_open' => true
            ]);
        } else {
            return response()->json([
                'message' => "We will be CLOSED on " . $day,
                'is_open' => false
            ]);
        }
    }
    
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
