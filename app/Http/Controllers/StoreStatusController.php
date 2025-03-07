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
            ->first();
    
        if ($currentStatus) {
            return response()->json(['is_open' => true, 'next_opening_time' => null]);
        } else {
            $nextOpening = OpeningHour::where('open_time', '>', $time)->orderBy('open_time')->first();
            return response()->json(['is_open' => false, 'next_opening_time' => $nextOpening->open_time ?? 'No upcoming openings']);
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
