<?php

namespace App\Http\Controllers;

use App\Models\Invoice_detail;
use Illuminate\Http\Request;
use App\Models\Invoice_attachment;
use App\Models\Invoice;


class InvoiceDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $this ->validate($request,[
           'file_name'=>'mimes:pdf,jpeg,png,jpg',
       ],[
           'file_name.mimes'=>'The file must be a file of type: pdf, jpeg, png, jpg.',
       ]);
       $image=$request->file('file_name');
         $file_name=$image->getClientOriginalName();
            $attachments= new Invoice_attachment();
            $attachments->file_name=$file_name;
            $attachments->invoice_number=$request->invoice_number;
            $attachments->invoice_id=$request->invoice_id;
            $attachments->Created_by=auth()->user()->name;
            $attachments->save();

            $image_name=$request->file_name->getClientOriginalName();
            $request->file_name->move(public_path('Attachment/'. $request->invoice_number), $image_name);
            session()->flash('Add','The attachment has been added successfully');
            return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice_detail  $invoice_detail
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice_detail $invoice_detail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice_detail  $invoice_detail
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices=Invoice::where('id',$id)->first();
        $invoice_details = Invoice_detail::where('invoice_id',$id)->get();
        $invoice_attachments=Invoice_attachment::where('invoice_id',$id)->get();

        return view('invoices.invoice_details',compact('invoice_details','invoice_attachments','invoices'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice_detail  $invoice_detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice_detail $invoice_detail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice_detail  $invoice_detail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoices=Invoice_attachment::findOrFail($request->id_file);
        $invoices->delete();
        $invoices_path=public_path()."/Attachment/".$request->invoice_number."/".$request->file_name;
        unlink($invoices_path);
        session()->flash('delete','The attachment has been deleted successfully');
        return back();
    }

    public function open_file($invoice_number,$file_name)
    {
        $path=public_path()."/Attachment/".$invoice_number."/".$file_name;
        return response()->file($path);
    }

    public function get_file($invoice_number,$file_name)
    {
        $path=public_path()."/Attachment/".$invoice_number."/".$file_name;
        return response()->download($path);
    }

}
