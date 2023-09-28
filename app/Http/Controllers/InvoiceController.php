<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\invoice;
use App\Models\Section;
use App\Models\Invoice_detail;
use App\Models\Invoice_attachment;
use App\Notifications\AddInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File; // Import the File facade
use Illuminate\Support\Facades\Response; // Import the Response facade
use Illuminate\Support\Facades\Notification;
use \App\Notifications\AddInvoiceDB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices=invoice::all();
        $sections=Section::all();
        return view('invoices.invoices',compact('invoices','sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections=Section::all();
        return view('invoices.add_invoice',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([


        ]);

        DB::transaction(function () use($request) {
            $invoice = invoice::create([
                'invoice_number' => $request->invoice_number,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'product' => $request->product,
                'section' => $request->section,
                'amount_collection' => $request->amount_collection,
                'amount_commission' => $request->amount_commission,
                'discount' => $request->discount,
                'value_vat' => $request->value_vat,
                'rate_vat' => $request->rate_vat,
                'total' => $request->total,
                'status'=>'Not Paid',
                'value_status' => 2,
                'note' => $request->note,
                'user' => (Auth::user()->name),
            ]);
            $invoice_id=invoice::latest()->first()->id;

            $invoice_detail=Invoice_detail::create([
                'invoice_id'=> $invoice_id,
                'invoice_number'=>$request->invoice_number,
                'product'=>$request->product,
                'section'=>$request->section,
                'value_status' => 2,
                'note' => $request->note,
                'user' => (Auth::user()->name),
            ]);
            if ($request->hasFile('pic')){
                $invoice_id=invoice::latest()->first()->id;
                $image=$request->file('pic');
                $file_name=$image->getClientOriginalName();
                $invoice_number = $request->invoice_number;

                $invoice_attach=Invoice_attachment::create([
                    'invoice_id'=>$invoice_id,
                    'file_name'=> $file_name,
                    'invoice_number'=>$invoice_number,
                    'created_by' => (Auth::user()->name),
                ]);
                //move pic
                $imageName= $request->pic->getClientOriginalName();
                $request->pic->move(public_path('Attachment/'.$invoice_number),$imageName);
            }
//            $user = User::first();
//            $user->notify(new AddInvoice($invoice_id));

            DB::commit();
        });
        $user = User::get();
        $invoice = invoice::latest()->first();
        Notification::send($user, new AddInvoiceDB($invoice));

        session()->flash('Add', 'Invoice Added successfully');
        return redirect('/invoices');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoices=invoice::where('id',$id)->first();
        return view('invoices.status_update',compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices=invoice::where('id',$id)->first();
        $sections=Section::all();
        return view('invoices.edit_invoice',compact('invoices','sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $invoice=invoice::findOrFail($request->invoice_id);
        $invoice->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'section' => $request->section,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'status'=>'Not Paid',
            'value_status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);
        session()->flash('Edit', 'Invoice Edited successfully');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $id = $request->invoice_id;
        $invoice = invoice::where('id', $id)->first();
        $attachment = Invoice_attachment::where('invoice_id', $id)->first();
        $id_page = $request->id_page;
        if (!$id_page == 2) {
            if (!empty($attachment->invoice_number)) {
                $invoices_path = public_path("Attachment/{$attachment->invoice_number}");

                // Check if the directory exists before attempting to delete
                if (File::isDirectory($invoices_path)) {
                    // Delete the entire directory and its contents
                    File::deleteDirectory($invoices_path);
                }
            }
            $invoice->ForceDelete();
            session()->flash('delete_invoice');
            return redirect('/invoices');
        }
        else {
            $invoice->delete();
            session()->flash('archive_invoice');
            return redirect('/Archive_Invoices');
        }


    }


    public function getproducts($id)
    {
        $products = DB::table('products')->where('section_id',$id)->pluck('product_name','id');
        return json_encode($products);
    }

    public function Status_Update($id,Request $request)
    {
        $invoices=invoice::findOrFail($id);
        if ($request->status === 'Paid')
        {
            $invoices->update([
                'status'=>$request->status,
                'value_status'=>1,
                'payment_date'=>$request->payment_date,
            ]);
            Invoice_detail::create([
                'invoice_id'=>$id,
                'invoice_number'=>$request->invoice_number,
                'product'=>$request->product,
                'section'=>$request->section,
                'status'=>$request->status,
                'value_status'=>1,
                'payment_date'=>$request->payment_date,
                'note'=>$request->note,
                'user'=>(Auth::user()->name),
            ]);

        }
        else
        {
            $invoices->update([
                'status'=>$request->status,
                'value_status'=>3,
                'payment_date'=>$request->payment_date,
            ]);
            Invoice_detail::create([
                'invoice_id'=>$id,
                'invoice_number'=>$request->invoice_number,
                'product'=>$request->product,
                'section'=>$request->section,
                'status'=>$request->status,
                'value_status'=>3,
                'payment_date'=>$request->payment_date,
                'note'=>$request->note,
                'user'=>(Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update');
        return redirect('/invoices');
    }

    public function Invoice_Paid()
    {
        $invoices=invoice::where('value_status',1)->get();
        return view('invoices.invoices_paid',compact('invoices',));
    }

    public function Invoice_UnPaid()
    {
        $invoices=invoice::where('value_status',2)->get();
        return view('invoices.invoices_unpaid',compact('invoices',));
    }

    public function Invoice_Partial()
    {
        $invoices=invoice::where('value_status',3)->get();
        return view('invoices.invoices_partial',compact('invoices',));
    }

    public function Print_invoice($id)
    {
        $invoices=invoice::where('id',$id)->first();
        return view('invoices.Print_Invoice',compact('invoices'));
    }

    public function MarkAsRead_all(){
        $userUnreadNotification = auth()->user()->unreadNotifications;
        if ($userUnreadNotification){
            $userUnreadNotification->markAsRead();
            return back();
        }
    }


}
