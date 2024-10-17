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
        ]);


        return to_route('utilities.index')->with('success', 'Utilities created successfully');
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
        $data = $request->validated();

        $status = $request->has('status') ? 1 : 0;

        $utility->update([
            'name' => $request->name,
            'price' => $request->price,
            'fee_type' => $request->fee_type,
            'status' => $status,
        ]);

        // Fetch all utilities after update
        $utilities = Utilities::all();

        return Inertia::render('Utilities/Index', [
            'utilities' => UtilityResource::collection($utilities),
        ])->with('success', 'Utility updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Utilities $utilities)
    {
        //
    }
}
