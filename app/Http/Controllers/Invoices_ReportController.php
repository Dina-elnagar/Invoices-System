<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use Illuminate\Http\Request;

class Invoices_ReportController extends Controller
{
    public function index()
    {
        return view('reports.invoices_report');
    }


    public function Search_invoices(Request $request)
    {
        $rdio = $request->input('rdio'); // Use input() to get request input

        // In case of searching by invoice type
        if ($rdio == 1) {
            // In case of no date selection
            if ($request->input('type') && $request->input('start_at') == '' && $request->input('end_at') == '') {
                $invoices = invoice::where('status', $request->input('type'))->get();
                $type = $request->input('type');
                return view('reports.invoices_report', compact('type'))->with('details', $invoices);
            } else {
                $start_at = $request->input('start_at');
                $end_at = $request->input('end_at');
                $type = $request->input('type');
                $invoices = invoice::whereBetween('invoice_date', [$start_at, $end_at])
                    ->where('status', $request->input('type'))
                    ->get();
                return view('reports.invoices_report', compact('type', 'start_at', 'end_at'))->with('details', $invoices);
            }
        }

        // In case of searching by invoice number
        else {
            $invoiceNumber = $request->input('invoice_number');
            $invoices = invoice::where('invoice_number', $invoiceNumber)->get();
            return view('reports.invoices_report', compact('invoiceNumber'))->with('details', $invoices);
        }
    }


}
