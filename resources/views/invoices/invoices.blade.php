@extends('layouts.master')
@section('title')
    List Invoices
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">Invoices</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ List invoices</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')

    @if (session()->has('delete_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "Invoice Deleted successfully",
                    type: "success"
                })
            }

        </script>
    @endif
				<!-- row -->
				<div class="row">
                    <div class="col-sm-6 col-md-4 col-xl-3" >

                        <a href="invoices/create" class="modal-effect btn btn-outline-primary btn-block" ><i
                                class="fas fa-plus"></i>&nbsp; Add Invoice</a>

                        <a class="modal-effect btn btn-outline-primary btn-block" href="{{ url('export_invoices') }}"
                           ><i class="fas fa-file-download"></i>&nbsp; Excel</a>

                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table text-md-nowrap" id="example1">
                                <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">Invoice Number</th>
                                    <th class="wd-20p border-bottom-0">invoice Date</th>
                                    <th class="wd-15p border-bottom-0">Due Date</th>
                                    <th class="wd-10p border-bottom-0">Product</th>
                                    <th class="wd-25p border-bottom-0">Section</th>
                                    <th class="wd-15p border-bottom-0">Discount</th>
                                    <th class="wd-20p border-bottom-0">Rate Vat</th>
                                    <th class="wd-15p border-bottom-0">Value Vat</th>
                                    <th class="wd-10p border-bottom-0">Total</th>
                                    <th class="wd-25p border-bottom-0">Status</th>
                                    <th class="wd-25p border-bottom-0">Note</th>
                                    <th class="wd-25p border-bottom-0">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0; ?>
                                @foreach($invoices as $invoice)
                                        <?php $i++; ?>
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$invoice->invoice_number}}</td>
                                    <td>{{$invoice->invoice_date}}</td>
                                    <td>{{$invoice->due_date}}</td>
                                    <td>{{$invoice->product}}</td>
                                    <td><a
                                            href="{{ url('InvoicesDetails') }}/{{ $invoice->id }}">{{ $invoice->sections->section_name }}</a>
                                    </td>
                                    <td>{{$invoice->discount}},765</td>
                                    <td>{{$invoice->rate_vat}}</td>
                                    <td>{{$invoice->value_vat}}</td>
                                    <td>{{$invoice->total}}</td>
                                    <td>
                                        @if ($invoice->value_status == 1)
                                            <span class="text-success">{{ $invoice->status }}</span>
                                        @elseif($invoice->value_status == 2)
                                            <span class="text-danger">{{ $invoice->status }}</span>
                                        @else
                                            <span class="text-warning">{{ $invoice->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{$invoice->note}}</td>
                                    <td>

                                                <div class="dropdown ">
                                                    <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-info"
                                                            data-toggle="dropdown" id="droprightMenuButton" type="button">Action<i class="fas fa-caret-right ml-1"></i></button>
                                                    <div aria-labelledby="droprightMenuButton" class="dropdown-menu tx-13">
                                                        <a class="dropdown-item" href="{{url('edit_invoice')}}/{{$invoice->id}}">Edit Invoice</a>

                                                        <a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}"
                                                           data-toggle="modal" data-target="#delete_invoice">
                                                            <i class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;Delete Invoice</a>
                                                    </div>
                                                </div>
                                    </td>

                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <!-- حذف الفاتورة -->
                    <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Invoice Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <form action="{{ route('invoices.destroy', 'test') }}" method="post">
                                    {{ method_field('delete') }}
                                    {{ csrf_field() }}
                                </div>
                                <div class="modal-body">
                                 Are you sure you want to delete this invoice
                                    <input type="hidden" name="invoice_id" id="invoice_id" value="">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
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
    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

    <script>
        $('#delete_invoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })

    </script>

@endsection
