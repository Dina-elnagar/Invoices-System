<?php

namespace App\Http\Controllers;

use App\Models\Invoice_attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\invoice;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = invoice::onlyTrashed()->get();
        return view('invoices.Archive_Invoices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->invoice_id;
        $invoices = invoice::withTrashed()->where('id', $id)->restore();
        session()->flash('restore_invoice');
        return redirect('/Archive_Invoices');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoices = invoice::withTrashed()->where('id', $request->invoice_id)->first();
        $attachment = Invoice_attachment::where('invoice_id', $invoices->id)->first();
        if (!empty($attachment->invoice_number)) {
            $invoices_path = public_path("Attachment/{$attachment->invoice_number}");
            // Check if the directory exists before attempting to delete
            if (File::isDirectory($invoices_path)) {
                // Delete the entire directory and its contents
                File::deleteDirectory($invoices_path);
            }
            $invoices->forceDelete();
            session()->flash('delete_invoice');
            return redirect('/Archive_Invoices');
        }
    }


}
