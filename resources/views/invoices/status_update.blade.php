@extends('layouts.master')
@section('css')
@endsection
@section('title')
    Partially Paid Invoices
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Invoices</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                   Partially Paid Invoices</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('Status_Update', ['id' => $invoices->id]) }}" method="post" autocomplete="off">
                        {{ csrf_field() }}
                        {{-- 1 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">Invoice Number</label>
                                <input type="hidden" name="invoice_id" value="{{ $invoices->id }}">
                                <input type="text" class="form-control" id="inputName" name="invoice_number"
                                       value="{{ $invoices->invoice_number }}" required
                                       readonly>
                            </div>

                            <div class="col">
                                <label>Invoice Date</label>
                                <input class="form-control fc-datepicker" name="invoice_date" placeholder="YYYY-MM-DD"
                                       type="text" value="{{ $invoices->invoice_date }}" required readonly>
                            </div>

                            <div class="col">
                                <label>Due Date</label>
                                <input class="form-control fc-datepicker" name="due_date" placeholder="YYYY-MM-DD"
                                       type="text" value="{{ $invoices->due_date }}" required readonly>
                            </div>

                        </div>

                        {{-- 2 --}}
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">Section</label>
                                <select name="section" class="form-control SlectBox" onclick="console.log($(this).val())"
                                        onchange="console.log('change is firing')" readonly>
                                    <!--placeholder-->
                                    <option value=" {{ $invoices->sections->id }}">
                                        {{ $invoices->sections->section_name }}
                                    </option>

                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">Product</label>
                                <select id="product" name="product" class="form-control" readonly>
                                    <option value="{{ $invoices->product }}"> {{ $invoices->product }}</option>
                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">Amount Collection</label>
                                <input type="text" class="form-control" id="inputName" name="amount_collection"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       value="{{ $invoices->amount_collection }}" readonly>
                            </div>
                        </div>


                        {{-- 3 --}}

                        <div class="row">

                            <div class="col">
                                <label for="inputName" class="control-label">Amount Commission</label>
                                <input type="text" class="form-control form-control-lg" id="amount_commission"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       value="{{ $invoices->amount_commission }}" required readonly>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">Discount</label>
                                <input type="text" class="form-control form-control-lg" id="discount" name="discount"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       value="{{ $invoices->discount }}" required readonly>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">Rate VAT</label>
                                <select name="rate_vat" id="rate_vat" class="form-control" onchange="myFunction()" readonly>
                                    <!--placeholder-->
                                    <option value=" {{ $invoices->rate_vat }}">
                                    {{ $invoices->rate_vat }}
                                </select>
                            </div>

                        </div>

                        {{-- 4 --}}

                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">Value VAT</label>
                                <input type="text" class="form-control" id="value_vat" name="value_vat"
                                       value="{{ $invoices->value_vat }}" readonly>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">Total</label>
                                <input type="text" class="form-control" id="total" name="total" readonly
                                       value="{{ $invoices->total }}">
                            </div>
                        </div>

                        {{-- 5 --}}
                        <div class="row">
                            <div class="col">
                                <label for="exampleTextarea">Note</label>
                                <textarea class="form-control" id="exampleTextarea" name="note" rows="3" readonly>
                                {{ $invoices->note }}</textarea>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col">
                                <label for="exampleTextarea">Paid Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option selected="true" disabled="disabled">-- Choose Paid Status --</option>
                                    <option value="Paid">Paid</option>
                                    <option value="Partially Paid">Partially Paid</option>
                                </select>
                            </div>

                            <div class="col">
                                <label>Payment Date</label>
                                <input class="form-control fc-datepicker" name="Payment_Date" placeholder="YYYY-MM-DD"
                                       type="text" required>
                            </div>


                        </div><br>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Update Partial Status</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();

    </script>
@endsection