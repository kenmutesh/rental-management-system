<?php

namespace App\Http\Controllers;

use App\Http\Resources\UnitsResource;
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
        $properties = Units::all();

        if (!$request->ajax()) {
            return Inertia::render('Property/Units', [
                'properties' => UnitsResource::collection($properties),
            ]);
        }
        return UnitsResource::collection($properties);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Units $units)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Units $units)
    {
        //
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
