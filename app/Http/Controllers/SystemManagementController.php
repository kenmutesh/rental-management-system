<?php

namespace App\Http\Controllers;

use App\Models\SystemManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Inertia\Inertia;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;
class SystemManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        // Define the backup directory
        $backupDirectory = str_replace('\\', '/', storage_path('app/backups'));

        // Get all files in the backup directory (returns an array of SplFileInfo)
        $backups = File::files($backupDirectory);

        // Ensure $backups is an array of SplFileInfo objects
        // Extract the necessary details from the files
        $fileDetails = array_map(function (SplFileInfo $file) {
            return [
                'name' => $file->getFilename(),  // File name
                'path' => $file->getRealPath(),  // Full path to the file
                'timestamps' => [
                    'aTime' => date('Y-m-d H:i:s', $file->getATime()),  // Last access time
                    'mTime' => date('Y-m-d H:i:s', $file->getMTime()),  // Last modified time
                    'cTime' => date('Y-m-d H:i:s', $file->getCTime()),  // File creation time
                ],
            ];
        }, $backups);

      

        // Pass the file details to the Inertia view
        return Inertia::render('System/Index', [
            'backups' => $fileDetails
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $output = shell_exec('which php');
            Artisan::call('backup:run');
            return back()->with('message', 'Backup created successfully. Output: ' . $output);
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
