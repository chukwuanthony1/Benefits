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
              <span>Edit</span>
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
  <h3 class="page-title"> Edit Product - {{ $productDetails->product_name }}
      <small></small>
  </h3>
  <!-- END PAGE BAR -->
  <!-- BEGIN PAGE TITLE-->
  <div class="row">
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
      {!! Form::open(['url'=>'/merchant/edit-product/'.$productDetails->id, 'class'=>'form', 'enctype'=>'multipart/form-data']) !!}
      <div class="col-md-7">
        <div class="form-group has-feedback">
          {!! Form::label('Product Name') !!}
          {!! Form::text('product_name', $productDetails->product_name, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group has-feedback">
          {!! Form::label('Description') !!}
          {!! Form::textarea('description', $productDetails->description, ['class'=>'form-control', 'id'=>'product-description']) !!}
        </div>
      </div>
      <div class="col-md-5">
        <div class="portlet light bordered">
          <div class="portlet-body">
            <div class="form-group has-feedback">
              {!! Form::label('Parent Category') !!}
              {!! Form::select('category_id', $categoyList, $productDetails->category_id, ['class'=>'form-control', 'placeholder'=>'Select A Category']) !!}
            </div>
            <div class="form-group has-feedback">
              {!! Form::label('Discount') !!}
              {!! Form::number('price', $productDetails->price, ['class'=>'form-control']) !!}
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
            <div class="preview-images-zone">
            @forelse ($productImage as $productImg)
              <div class="preview-image">
                <a href="{{ url('/merchant/delete-productImg/') }}/{{ $productImg->id }}/{{ $productDetails->id }}" class="image-cancel">x</a>
                <div class="image-zone">
                    <img src="{{ asset('/images/products/small/') }}/{{ $productImg->image_path }}" class="img-thumbnail" />
                </div>
              </div>
            @empty
                <p>No image</p>
            @endforelse
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