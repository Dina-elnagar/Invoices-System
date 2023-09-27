<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use Illuminate\Http\Request;
use App\Models\Section;

class Customers_ReportController extends Controller
{
    public function index()
    {
        $sections = Section::all();
        return view('reports.customers_report',compact('sections'));
    }

    public function Search_customers(Request $request)
    {
        if($request->section && $request->product && $request->start_at == '' && $request->end_at == '')
        {
            $invoices = invoice::select('*')->where('section','=',$request->section)->where('product','=',$request->product)->get();
            $sections = Section::all();
            return view('reports.customers_report',compact('sections'))->with('details',$invoices);
        }
        else{
            $start_at = $request->start_at;
            $end_at = $request->end_at;
            $invoices = invoice::select('*')->where('section','=',$request->section)->where('product','=',$request->product)->whereBetween('invoice_date',[$start_at,$end_at])->get();
            $sections = Section::all();
            return view('reports.customers_report',compact('sections','start_at','end_at'))->with('details',$invoices);
        }

    }

}
