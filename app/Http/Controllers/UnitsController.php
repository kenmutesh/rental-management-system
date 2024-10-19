<?php

namespace App\Http\Controllers;

use App\Http\Resources\PropertyResource;
use App\Http\Resources\UnitsResource;
use App\Http\Resources\UtilityResource;
use App\Models\Property;
use App\Models\Units;
use App\Models\Utilities;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $units = Units::paginate(10);
        $totalUnits = $units->count();
        $totalOccupied = $units->whereNotNull('occupied_by')->count();

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
        $utilities = Utilities::all();

        return Inertia::render('Units/Create', [
            'properties' => PropertyResource::collection($properties),
            'utilities' => UtilityResource::collection($utilities),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:units,name',
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

        if ($request->has('recurringBills')) {
            foreach ($request->recurringBills as $bill) {
                $unit->unit_utilities()->create([
                    'utility_id' => $bill['type'],
                ]);
            }
        }


        return to_route('units.index')->with('message', 'The Unit has been created successfully');
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
        $properties = Property::all();
        return Inertia::render('Units/Create', [
            'unit' => new UnitsResource ($unit),
            'properties' => PropertyResource::collection($properties),
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
