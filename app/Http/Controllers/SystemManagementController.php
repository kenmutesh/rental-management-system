<?php

namespace App\Http\Controllers;

use App\Models\SystemManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;

class SystemManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $backupDirectory = storage_path('app/backups');

    // Check if the directory exists and get all files
    $backups = [];
    if (File::exists($backupDirectory)) {
        $backups = File::files($backupDirectory);
    }

    // Pass the backup files to the Inertia view
    return Inertia::render('System/Index', [
        'backups' => $backups
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            Artisan::call('backup:run');
            return back()->with('message', 'Backup created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create backup: ' . $e->getMessage());
        }
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
