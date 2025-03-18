<?php

namespace App\Http\Controllers;

use App\Models\SystemManagement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use ZipArchive;

class SystemManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $backupDirectory = storage_path('app/backups/'.env('APP_NAME'));
        $backups = [];
        if (File::exists($backupDirectory)) {
            $backups = collect(File::files($backupDirectory))->map(function ($file) {
                return [
                    'name' => $file->getFilename(),
                    'size' => round($file->getSize() / 1024, 2) . ' KB',
                    'date' => date('Y-m-d H:i:s', $file->getMTime()),
                    'path' => str_replace(storage_path('app'), '', $file->getPathname()),
                ];
            })->toArray();
        }

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
            Artisan::call('backup:run --only-db');

            $backupPath = storage_path('app/backups/'.env('APP_NAME'));

            $backupFiles = glob($backupPath . '/*.zip');

            if (empty($backupFiles)) {
                return response()->json(['status' => 'error', 'message' => 'No backup files found.']);
            }

            // Get the most recent backup
            $latestBackup = collect($backupFiles)->sortByDesc(fn($file) => filemtime($file))->first();

            // Define the zip file path
            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $zipFilePath = storage_path("app/backups/backup_{$timestamp}.zip");

            // Create a zip archive
            $zip = new ZipArchive();
            if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {
                $zip->addFile($latestBackup, basename($latestBackup));
                $zip->close();
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to create ZIP archive.']);
            }

            // Store backup in Laravel storage
            Storage::disk('local')->put("backups/backup_{$timestamp}.zip", file_get_contents($zipFilePath));

            $backups = collect(Storage::disk('local')->files('backups'))
                ->map(fn($file) => [
                    'name' => basename($file),
                    'date' => Carbon::createFromTimestamp(Storage::disk('local')->lastModified($file))->toDateTimeString()
                ])
                ->sortByDesc('date')
                ->values();

            return Inertia::render('Backups', [
                'backups' => $backups,
                'success' => 'Backup created successfully!'
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Backup failed: ' . $e->getMessage());
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
