<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvoiceResource;
use App\Models\Invoices;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        $invoices = Invoices::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        return Inertia::render('Invoices/Index', [
            'invoices' => InvoiceResource::collection($invoices),
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
    public function edit(Invoices $invoice)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show($invoice)
    {

        $data['invoices'] = Invoices::where('id', $invoice)->get();

        // Load the view and pass the invoice data
        $pdf = Pdf::loadView('pdf.invoices', $data);

        // Optional: Set paper size and orientation
        $pdf->setPaper('A4', 'landscape');

        // Stream the generated PDF to the browser (no attachment means open in browser)
        return $pdf->stream('invoice.pdf', ['Attachment' => false]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoices $invoices)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoices $invoices)
    {
        //
    }
}
