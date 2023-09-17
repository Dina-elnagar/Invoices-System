@extends('layouts.master')
@section('title')
    Invoice Details
@stop
@section('css')
    <!---Internal  Prism css-->
    <link href="{{URL::asset('assets/plugins/prism/prism.css')}}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{URL::asset('assets/plugins/inputtags/inputtags.css')}}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css')}}" rel="stylesheet">

@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Pages</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Empty</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <!-- row -->
    <div class="row">

        <!-- /div -->

        <div class="col-xl-12">
            <!-- div -->
            <div class="card mg-b-20" id="tabs-style3">
                <div class="card-body">

                    <div class="text-wrap">
                        <div class="example">
                            <div class="panel panel-primary tabs-style-3">
                                <div class="tab-menu-heading">
                                    <div class="tabs-menu ">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs">
                                            <li class=""><a href="#invoice_details" class="active" data-toggle="tab"><i class="fa fa-laptop"></i>  Invoice Details </a></li>
                                            <li><a href="#invoice_status" data-toggle="tab"><i class="fa fa-cube"></i>  Invoice Status </a></li>
                                            <li><a href="#invoice_attachment" data-toggle="tab"><i class="fa fa-tasks"></i>  Invoice Attachment </a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="invoice_details">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped" id="example1" style="text-align: center">
                                                       <tbody>
                                                        <tr>
                                                            <th scope="row">Invoice Number</th>
                                                            <td>{{$invoices->invoice_number}}</td>
                                                            <th scope="row">Invoice Date</th>
                                                            <td>{{$invoices->invoice_date}}</td>
                                                            <th scope="row">Due Date</th>
                                                            <td>{{$invoices->due_date}}</td>
                                                            <th scope="row">Section</th>
                                                            <td>{{$invoices->sections->section_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Product</th>
                                                            <td>{{$invoices->product}}</td>
                                                            <th scope="row">Amount Collection</th>
                                                            <td>{{$invoices->amount_collection}}</td>
                                                            <th scope="row">Amount Commission</th>
                                                            <td>{{$invoices->amount_commission}}</td>
                                                            <th scope="row">Discount</th>
                                                            <td>{{$invoices->discount}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Rate Vat</th>
                                                            <td>{{$invoices->rate_vat}}</td>
                                                            <th scope="row">Value Vat</th>
                                                            <td>{{$invoices->value_vat}}</td>
                                                            <th scope="row">Total</th>
                                                            <td>{{$invoices->total}}</td>
                                                            <th scope="row">Status</th>
                                                            @if($invoices->value_status == 1)
                                                            <td><span class="badge badge-pill badge-success">
                                                               {{$invoices->status}}
                                                                </span>
                                                            </td>
                                                            @elseif($invoices->value_status == 2)
                                                                <td><span class="badge badge-pill badge-danger">
                                                               {{$invoices->status}}
                                                                </span>
                                                                </td>
                                                            @else
                                                                <td><span class="badge badge-pill badge-warning">
                                                               {{$invoices->status}}
                                                                </span>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Note</th>
                                                            <td>{{$invoices->note}}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane" id="invoice_status">
                                            <div class="table-responsive">
                                                <table class="table center-aligned-table mb-0 table-hover" id="example1" style="text-align: center">
                                                    <thead>
                                                    <tr>
                                                        <th class="wd-15p border-bottom-0">#</th>
                                                        <th class="wd-15p border-bottom-0">Invoice Number</th>
                                                        <th class="wd-15p border-bottom-0">Product </th>
                                                        <th class="wd-20p border-bottom-0">Section</th>
                                                        <th class="wd-15p border-bottom-0">Payment Status</th>
                                                        <th class="wd-10p border-bottom-0">Payment Date</th>
                                                        <th class="wd-10p border-bottom-0">Note</th>
                                                        <th class="wd-25p border-bottom-0">Addition Date</th>
                                                        <th class="wd-25p border-bottom-0">User</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $i = 0; ?>
                                                    @foreach($invoice_details as $invoice_detail)
                                                            <?php $i++; ?>
                                                        <tr>
                                                            <td>{{$i}}</td>
                                                            <td>{{$invoice_detail->invoice_number}}</td>
                                                            <td>{{$invoice_detail->product}}</td>
                                                            <td>{{$invoice_detail->sections->section_name}}</td>
                                                            <td>
                                                                @if($invoice_detail->value_status == 1)
                                                                    <span class="badge badge-pill badge-success">
                                                               {{$invoice_detail->status}}
                                                                </span>
                                                                @elseif($invoice_detail->value_status == 2)
                                                                    <span class="badge badge-pill badge-danger">
                                                               {{$invoice_detail->status}}
                                                                </span>
                                                                @else
                                                                    <span class="badge badge-pill badge-warning">
                                                               {{$invoice_detail->status}}
                                                                </span>
                                                                @endif
                                                                </td>
                                                                <td>{{$invoice_detail->payment_date}}</td>
                                                                <td>{{$invoice_detail->note}}</td>
                                                                <td>{{$invoice_detail->created_at}}</td>
                                                                <td>{{$invoice_detail->user}}</td>
                                                         </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>

                                        <div class="tab-pane" id="invoice_attachment">

                                            <!--Attachment-->
                                            <div class="card card-statistics">
                                                    <div class="card-body">
                                                        <p class="text-danger">* Attachment format -->  pdf, jpeg ,.jpg , png </p>
                                                        <h5 class="card-title">Add Attachment</h5>
                                                        <form method="post" action="{{ url('/InvoiceAttachments') }}"
                                                              enctype="multipart/form-data">
                                                            {{ csrf_field() }}
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="customFile"
                                                                       name="file_name" required>
                                                                <input type="hidden" id="customFile" name="invoice_number"
                                                                       value="{{ $invoices->invoice_number }}">
                                                                <input type="hidden" id="invoice_id" name="invoice_id"
                                                                       value="{{ $invoices->id }}">
                                                                <label class="custom-file-label" for="customFile">Choose attachment</label>
                                                            </div><br><br>
                                                            <button type="submit" class="btn btn-primary btn-sm "
                                                                    name="uploadedFile">Submit</button>
                                                        </form>
                                                    </div>
                                                <br>

                                            <div class="table-responsive mt-15">
                                                <table class="table center-aligned-table mb-0 table table-hover"  style="text-align: center">
                                                    <thead>
                                                    <tr class="text-dark">
                                                        <th scope="col">#</th>
                                                        <th scope="col">File Name</th>
                                                        <th scope="col">User</th>
                                                        <th scope="col">Addition Date</th>
                                                        <th scope="col">Process</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $i = 0; ?>
                                                    @foreach($invoice_attachments as $invoice_attachment)
                                                            <?php $i++; ?>
                                                        <tr>
                                                            <td>{{$i}}</td>
                                                            <td>{{$invoice_attachment->file_name}}</td>
                                                            <td>{{$invoice_attachment->created_by}}</td>
                                                            <td>{{$invoice_attachment->created_at}}</td>
                                                            <td colspan="2">
                                                                <a class="btn btn-outline-success btn-sm"
                                                                   href="{{url('view_file')}}/{{$invoice_attachment->invoice_number}}/{{$invoice_attachment->file_name}}"
                                                                   role="button"><i class="fas fa-eye"></i>&nbsp; View</a>
                                                                <a class="btn btn-outline-info btn-sm"
                                                                   href="{{url('download')}}/{{$invoice_attachment->invoice_number}}/{{$invoice_attachment->file_name}}"
                                                                   role="button"><i class="fas fa-download"></i>&nbsp; Download</a>

                                                                <button  class="btn btn-outline-danger btn-sm"
                                                                         data-toggle="modal"
                                                                         data-file_name="{{ $invoice_attachment->file_name }}"
                                                                         data-invoice_number="{{ $invoice_attachment->invoice_number }}"
                                                                         data-id_file="{{ $invoice_attachment->id }}"
                                                                         data-target="#delete_file">Delete</button>

                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!-- /div -->

        <!-- delete -->
        <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Attachment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('delete_file') }}" method="post">

                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p class="text-center">
                            <h6 style="color:red"> Are you sure you want to delete this</h6>
                            </p>

                            <input type="hidden" name="id_file" id="id_file" value="">
                            <input type="hidden" name="file_name" id="file_name" value="">
                            <input type="hidden" name="invoice_number" id="invoice_number" value="">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Sure</button>
                        </div>
                    </form>
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
    <!--Internal  Datepicker js -->
    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!-- Internal Select2 js-->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <!-- Internal Input tags js-->
    <script src="{{URL::asset('assets/plugins/inputtags/inputtags.js')}}"></script>
    <!--- Tabs JS-->
    <script src="{{URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js')}}"></script>
    <script src="{{URL::asset('assets/js/tabs.js')}}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{URL::asset('assets/plugins/clipboard/clipboard.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/clipboard/clipboard.js')}}"></script>
    <!-- Internal Prism js-->
    <script src="{{URL::asset('assets/plugins/prism/prism.js')}}"></script>
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>
    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_file = button.data('id_file')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)
            modal.find('.modal-body #id_file').val(id_file);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })

    </script>

@endsection
