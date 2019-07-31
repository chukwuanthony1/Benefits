@extends('layouts.adminlayout')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Merchants</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Merchants</a></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
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
           <div class="card">
           <div class="card-header">
              <h3 class="card-title">Merchant List</h3>
              <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <a href="{{ route('admin.merchant.new') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i>  New Merchant
                  </a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped" id="category-table" style="width:100%;">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
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
                //ajax: '{!! route('merchant.data') !!}',
                ajax: {
                    url:'{!! route('merchant.data') !!}',
                    type:'post',
                    data: {
                        '_token': token
                    }
                },
                columns: 
                [
                  { data: 'id', name: 'id' },
                  { data: 'name', name: 'name' },
                  { data: 'email', name: 'status' },
                  { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
  var detailRows = [];

</script>
@stop