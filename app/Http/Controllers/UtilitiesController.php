<?php

namespace App\Http\Controllers;

use App\Http\Requests\UtilitiesRequest;
use App\Http\Resources\UtilityResource;
use App\Models\Utilities;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UtilitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $utilities = Utilities::all();

        return Inertia::render('Utilities/Index', [
            'utilities' => UtilityResource::collection($utilities),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UtilitiesRequest $request)
    {
        $utility = Utilities::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'fee_type' => $request->input('fee_type'),
            'status' => $request->input('status', false),
        ]);

        return redirect()->route('utilities.index')
            ->with('message', 'Utility has been created successfully')
            ->with('utilities', Utilities::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Utilities $utilities)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Utilities $utilities)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UtilitiesRequest $request, Utilities $utility)
    {
        $utility->update([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'fee_type' => $request->input('fee_type'),
            'status' => $request->input('status', false),
        ]);

        $utilities = Utilities::all(); // Get updated utilities

        return Inertia::render('Utilities/Index', [
            'utilities' => UtilityResource::collection($utilities),
        ])->with('message', 'Utility updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete(Utilities $utility)
    {
        $utility->delete();

        return to_route('utilities.index')->with('success', 'Utility deleted successfully');
    }
}
