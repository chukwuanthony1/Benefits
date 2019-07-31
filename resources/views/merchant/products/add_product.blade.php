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
              <span>Product</span>
          </li>
          <li>
              <span>New</span>
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
  <h3 class="page-title"> New Product
      <small></small>
  </h3>
  <!-- END PAGE BAR -->
  <!-- BEGIN PAGE TITLE-->
  <div class="row">
      @if(session('error'))
        <div class="alert alert-danger">
          {{ session('error') }}
        </div>
      @endif
    {!! Form::open(['url'=>'/merchant/products/new', 'class'=>'form', 'enctype'=>'multipart/form-data']) !!}
    <div class="col-md-7">
      <div class="form-group has-feedback">
        {!! Form::label('Product Name') !!}
        {!! Form::text('name', null, ['class'=>'form-control', 'autocomplete'=>'false', 'autocomplete'=>'off', 'required'=>'required']) !!}
      </div>
      <div class="form-group has-feedback">
        {!! Form::label('Product Description') !!}
        {!! Form::textarea('description', null, ['class'=>'form-control', 'id'=>'product-description', 'required'=>'required' ]) !!}
      </div>
    </div>
    <div class="col-md-5">
      <div class="portlet light bordered">
        <div class="portlet-body">
          <div class="form-group has-feedback">
            {!! Form::label('Category') !!}
            {!! Form::select('category_id', $categoyList, '0', ['class'=>'form-control select2', 'placeholder'=>'Select A Category', 'id'=>'select2']) !!}
          </div>
          <div class="form-group has-feedback">
            {!! Form::label('Product Discount') !!}
            {!! Form::number('price', null, ['class'=>'form-control', 'autocomplete'=>'false', 'autocomplete'=>'off', 'required'=>'required', 'min'=>'1']) !!}
          </div>
          <div class="form-group has-feedback">
            {!! Form::label('Product Image(s)') !!}
            <table class="table table-bordered" id="dynamic_field">  
              <tr>  
                <td><input type="file" name="image[]" class="form-control name_list" /></td>  
                <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button>
                </td>  
              </tr>  
            </table>
          </div>
          <div class="form-group">
            {!! Form::submit('Submit', ['class'=>'btn btn-primary btn-block btn-flat']) !!}
          </div>
        </div>
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</div>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace( 'product-description' );
</script>
<script type="text/javascript">
  var i=1;  
  $('#add').click(function(){  
       i++;  
       $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td><input type="file" name="image[]" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
  });  
  $(document).on('click', '.btn_remove', function(){  
       var button_id = $(this).attr("id");   
       $('#row'+button_id+'').remove();  
  });  
</script>
@endsection

