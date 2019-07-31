@extends('layouts.merchantlayout')
@section('content')
<div class="page-content">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="#">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Products</span>
            </li>
        </ul>
        <div class="page-toolbar">
            <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range">
                <i class="icon-calendar"></i>&nbsp;
                <span class="thin uppercase hidden-xs"></span>&nbsp;
                <i class="fa fa-angle-down"></i>
            </div>
        </div>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <div class="row">
      <div class="col-md-12">
        @if(session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
        @endif
        @if(session('error'))
          <div class="alert alert-danger">
            {{ session('error') }}
          </div>
        @endif
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div class="portlet light">
        <div class="portlet-title">
          <div class="caption font-dark">
              <i class="icon-settings font-dark"></i>
              <span class="caption-subject bold uppercase"> Manage Products</span>
          </div>
          <div class="actions">
              <a href="{{ route('merchant.product.new') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i>  New Products
              </a>
          </div>
        </div>
        <div class="portlet-body">
          <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
            <table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer" id="products-table" style="width:100%;">
                <thead>
                  <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Discount (%)</th>
                    <th>Created</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
              </table>
          </div>
        </div>
      </div>
      <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

<script type="text/javascript">
  var token = '{{ csrf_token() }}';

  $('#products-table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
      //ajax: '{!! route('product.merchant.data') !!}',
      ajax: {
          url:'{!! route('product.merchant.data') !!}',
          type:'post',
          data: {
              '_token': token
          }
      },
      columns: 
      [
        {
          "className":      'details-control',
          "orderable":      false,
          "searchable":     false,
          "data":           null,
          "defaultContent": ''
        },
        { data: 'id', name: 'id' },
        { data: 'product_name', name: 'product_name' },
        { data: 'product_code', name: 'product_code' },
        { data: 'price', name: 'price' },
        { data: 'created_at', name: 'created_at' },
        { data: 'status', name: 'status' },
        { data: 'action', name: 'action', orderable: false, searchable: false }
      ]
  });

  $(document).on('click', '.btn-danger', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    swal({
      title: "Are you sure, you want to delete this product!",
      type: "error",
      buttons: {
        cancel: true,
        confirm: true,
      },
    }).then(function(isConfirm){
       if (isConfirm){
          window.location.replace("{{ url('/merchant/delete-product/') }}/"+id);
        }
     });
  });
</script>
@stop