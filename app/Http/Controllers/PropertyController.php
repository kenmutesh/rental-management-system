<?php

namespace App\Http\Controllers;

use App\Http\Resources\PropertyResource;
use App\Models\Property;
use App\Models\Units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $properties = $user->properties()->with('units')->get();

        foreach ($properties as $property) {
            $property->totalUnits = $property->units->count();
            $property->totalOccupiedUnits = $property->units->whereNotNull('occupied_by')->count();
            $property->availableUnits = $property->totalUnits - $property->totalOccupiedUnits;
            $property->percentageOccupied = $property->totalUnits > 0
                ? ($property->totalOccupiedUnits / $property->totalUnits) * 100
                : 0;
        }

        return Inertia::render('Property/Index', [
            'properties' => PropertyResource::collection($properties),
            'totalUnits' => $properties->sum('totalUnits'),
            'totalOccupiedUnits' => $properties->sum('totalOccupiedUnits'),
            'vacancies' => $properties->sum('availableUnits'),
            'totalProperties' => $properties->count(),
        ]);
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
            'invoicingDay' => 'Required|integer|min:0',
            'smsReminderDay' => 'Required|integer|min:0',
        ]);


        $property = Property::create([
            'propertyName' => $request->propertyName,
            'totalUnits' => $request->totalUnits,
            'city' => $request->city,
            'waterRate' => $request->waterRate,
            'electricityRate' => $request->electricityRate,
            'penaltyPercentage' => $request->penaltyPercentage,
            'streetName' => $request->streetName,
            'invoicingDay' => $request->invoicingDay,
            'smsReminderDay' => $request->smsReminderDay,
            'paymentInstructions' => $request->paymentInstructions
        ]);



        $user = auth()->user();

        $user->properties()->attach($property->id);

        return to_route('properties.index', [
            'properties' => Property::all(),
        ])->with('message', 'Property created successfully');
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

        return to_route('properties.index', [
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
