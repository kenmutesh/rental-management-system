<?php

namespace App\Http\Controllers;

use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $properties = Property::all();

        // Check if the request is AJAX
        if (!$request->ajax()) {
            return Inertia::render('Property/Index', [
                'properties' => PropertyResource::collection($properties),
            ]);
        }
        return PropertyResource::collection($properties);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Property/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'propertyName' => 'required|string|max:255',
            'totalUnits' => 'required|integer|min:1',
            'city' => 'required|string|max:255',
            'waterRate' => 'nullable|numeric|min:0',
            'electricityRate' => 'nullable|numeric|min:0',
            'penaltyPercentage' => 'nullable|numeric|min:0|max:100',
            'streetName' => 'nullable|string|max:255',
            'paymentInstructions' => 'nullable|string|max:500',
        ]);


        Property::create([
            'propertyName' => $request->propertyName,
            'totalUnits' => $request->totalUnits,
            'city' => $request->city,
            'waterRate' => $request->waterRate,
            'electricityRate' => $request->electricityRate,
            'penaltyPercentage' => $request->penaltyPercentage,
            'streetName' => $request->streetName,
            'paymentInstructions' => $request->paymentInstructions
        ]);

        return Inertia::render('Property/Index', [
            'properties' => Property::all(),
        ])->with('success', 'Property created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        return Inertia::render('Property/Create', [
            'property' => $property,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        $request->validate([
            'propertyName' => 'required|string|max:255',
            'totalUnits' => 'required|integer|min:1',
            'city' => 'required|string|max:255',
            'waterRate' => 'nullable|numeric|min:0',
            'electricityRate' => 'nullable|numeric|min:0',
            'penaltyPercentage' => 'nullable|numeric|min:0|max:100',
            'streetName' => 'nullable|string|max:255',
            'paymentInstructions' => 'nullable|string|max:500',
        ]);


        $property->update([
            'propertyName' => $request->propertyName,
            'totalUnits' => $request->totalUnits,
            'city' => $request->city,
            'waterRate' => $request->waterRate,
            'electricityRate' => $request->electricityRate,
            'penaltyPercentage' => $request->penaltyPercentage,
            'streetName' => $request->streetName,
            'paymentInstructions' => $request->paymentInstructions
        ]);

        return Inertia::render('Property/Index', [
            'properties' => Property::all(),
        ])->with('success', 'Property created successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        $property->delete();
        return response()->json(['message' => 'Property deleted successfully'], 200);
    }
}
