<?php

namespace App\Http\Controllers;

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
            'utilities' => $utilities
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, Utilities $utilities)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Utilities $utilities)
    {
        //
    }
}
