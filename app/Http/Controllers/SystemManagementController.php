<?php

namespace App\Http\Controllers;

use App\Models\SystemManagement;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SystemManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('System/Index');
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
    public function show(SystemManagement $systemManagement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SystemManagement $systemManagement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SystemManagement $systemManagement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SystemManagement $systemManagement)
    {
        //
    }
}
