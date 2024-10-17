<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Tenants;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TenantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Tenants::query();
        $this->applySearch($query, $request->search);

        $tenants = $query->paginate(10);

        return Inertia::render('Tenants/Index', [
            'tenants' => $tenants,
            'search' => $request->search,
            'page' => $request->page,
        ]);
    }



    private function applySearch($query, $search)
    {
        $query->when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $properties = Property::with('units')
                    ->get();

        return Inertia::render('Tenants/Create', [
            'properties' => $properties
        ]);
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
    public function show(Tenants $tenants)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenants $tenants)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenants $tenants)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenants $tenants)
    {
        //
    }
}
