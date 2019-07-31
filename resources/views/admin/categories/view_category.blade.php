@extends('layouts.adminlayout')
@section('content')
<div class="page-content">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="#">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Category</span>
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
              <span class="caption-subject bold uppercase"> Manage Categories</span>
          </div>
          <div class="actions">
              <a href="{{ route('admin.category.new') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i>  New Categoty
              </a>
          </div>
        </div>
        <div class="portlet-body">
          <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
            <table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer" id="category-table" style="width:100%;">
                <thead>
                  <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Created</th>
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
  //var template = Handlebars.compile($("#details-template").html());
  $(function() {
    
  });
  var token = '{{ csrf_token() }}';
  var dt = $('#category-table').DataTable({
              processing: true,
              serverSide: true,
              responsive: true,
                //ajax: '{!! route('category.data') !!}',
                ajax: {
                    url:'{!! route('category.data') !!}',
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
                  { data: 'name', name: 'name' },
                  { data: 'image_path', name: 'image_path' },
                  { data: 'status', name: 'status' },
                  { data: 'created_at', name: 'created_at' },
                  { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
  var detailRows = [];
 
  $('#category-table tbody').on( 'click', 'tr td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = dt.row( tr );
    var idx = $.inArray( tr.attr('id'), detailRows );

    if ( row.child.isShown() ) {
        tr.removeClass( 'details' );
        row.child.hide();
        detailRows.splice( idx, 1 );
    }
    else {
        tr.addClass( 'details' );
        row.child( format( row.data() ) ).show();
        if ( idx === -1 ) {
            detailRows.push( tr.attr('id') );
        }
    }
  });

  dt.on('draw', function () {
    $.each( detailRows, function ( i, id ) {
        $('#'+id+' td.details-control').trigger( 'click' );
    });
  });

  function format ( d ) {
    return '<strong>Description:</strong> '+d.description+'';
  }
</script>
@stop