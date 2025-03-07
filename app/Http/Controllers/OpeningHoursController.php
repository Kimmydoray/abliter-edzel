<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OpeningHour;

class OpeningHoursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return response()->json(OpeningHour::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'day' => 'required|string',
            'open_time' => 'required',
            'close_time' => 'required',
            'lunch_start' => 'nullable',
            'lunch_end' => 'nullable',
            'is_open_every_other_week' => 'boolean'
        ]);
    
        $openingHour = OpeningHour::create($validated);
        return response()->json($openingHour, 201);
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
