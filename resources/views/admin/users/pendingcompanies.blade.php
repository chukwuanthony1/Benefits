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
                <span>Pending</span>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Companies</span>
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
              <span class="caption-subject bold uppercase"> Pending Companies</span>
          </div>
          <!-- <div class="actions">
              <a href="{{ route('admin.category.new') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i>  New Admin
              </a>
          </div> -->
        </div>
        <div class="portlet-body">
          <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
            <table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer" id="users-table" style="width:100%;">
                <thead>
                  <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Company Name</th>
                    <th>Email</th>
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

  var dt = $('#users-table').DataTable({
              processing: true,
              serverSide: true,
              responsive: true,
                ajax: {
                    url:'{!! route('pending.companies.data') !!}',
                    type:'post',
                    data: {
                        '_token': token
                    }
                },
                columns: 
                [
                  {
                    "className": 'details-control',
                    "orderable": false,
                    "searchable": false,
                    "data": null,
                    "defaultContent": ''
                  },
                  { data: 'id', name: 'id' },
                  { data: 'company_name', name: 'name' },
                  { data: 'email', name: 'status' },
                  { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
  var detailRows = [];
 
  $('#users-table tbody').on( 'click', 'tr td.details-control', function () {
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
    return '<strong>Tel:</strong> '+d.phone_no+'';
  }

</script>
@stop