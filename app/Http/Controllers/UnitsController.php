<?php

namespace App\Http\Controllers;

use App\Http\Resources\UnitsResource;
use App\Models\Property;
use App\Models\Units;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $units = Units::all();
        $totalUnits = $units->count();
        $totalOccupied = $units->whereNull('occupied_by')->count();

        return Inertia::render('Units/Index', [
            'units' => UnitsResource::collection($units),
            'totalUnits' => $totalUnits,
            'totalOccupied' => $totalOccupied
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $properties = Property::all();

        return Inertia::render('Units/Create', [
            'properties' => $properties,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'property_id' => 'required|exists:properties,id',
            'rentAmount' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        $property = Property::find($request->property_id);

        if ($property->units()->count() >= $property->totalUnits) {
            return response()->json([
                'message' => 'The property has reached the maximum number of units allowed.',
                'units' => $property->units,
            ], 400);
        }

        $unit = Units::create([
            'name' => $request->name,
            'property_id' => $request->property_id,
            'rentAmount' => $request->rentAmount,
            'notes' => $request->notes,
        ]);

        return response()->json(['data' => $unit], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show($property)
    {
        $units = Units::where('property_id', $property)
                ->get();
        return UnitsResource::collection($units);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Units $unit)
    {
        return Inertia::render('Units/Create', [
            'unit' => $unit,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Units $units)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Units $units)
    {
        //
    }
}
