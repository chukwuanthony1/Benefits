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
              <span>Product</span>
              <i class="fa fa-circle"></i>
          </li>
          <li>
              <span>View</span>
              <i class="fa fa-circle"></i>
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
  <h3 class="page-title"> View Product - {{ $productDetails->product_name }}
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
      {!! Form::open(['url'=>'/admin/update-product/'.$productDetails->id, 'class'=>'form', 'enctype'=>'multipart/form-data']) !!}
      <div class="col-md-7">
        <table class="table table-striped">
            <tr>
              <td>Product Name:</td>
              <td> {{ $productDetails->product_name}} </td>
            </tr>
            <tr>
              <td>Discount(%):</td>
              <td> {{ $productDetails->price}} </td>
            </tr>
            <tr>
              <td>Description:</td>
              <td> {!! $productDetails->description !!} </td>
            </tr>
        </table>
      </div>
      <div class="col-md-5">
        <div class="portlet light bordered">
          <div class="portlet-body">
            <table class="table table-striped">
              <tr>
                <td>Merchant:</td>
                <td> {{ $productDetails->company_name}} </td>
              </tr>
              <tr>
                <td>Merchant Url:</td>
                <td> {{ $productDetails->site_url}} </td>
              </tr>
              <tr>
                <td>Merchant Email:</td>
                <td> {{ $productDetails->email }} </td>
              </tr>
            </table>
            <div class="preview-images-zone">
              <h4>Product Image(s)</h4>
              @forelse ($productImage as $productImg)
                <div class="preview-image">
                  <div class="image-zone">
                      <img src="{{ asset('/images/products/small/') }}/{{ $productImg->image_path }}" class="img-thumbnail" />
                  </div>
                </div>
              @empty
                  <p>No image</p>
              @endforelse
            </div>
            <div class="form-group has-feedback">
              {!! Form::label('Parent Category') !!}
              {!! Form::select('category_id', $categoyList, $productDetails->category_id, ['class'=>'form-control', 'placeholder'=>'Select A Category']) !!}
            </div>
            <div class="form-group has-feedback">
              {!! Form::label('Status') !!}
              {!! Form::select('status', ['0'=>'Pending', '1'=>'Approved', '2'=>'Rejected'], $productDetails->status, ['class'=>'form-control', 'placeholder'=>'Select A Status']) !!}
            </div>       
            <div class="form-group">
              {!! Form::submit('Update', ['class'=>'btn btn-primary btn-block btn-flat']) !!}
            </div>
          </div>
        </div>
      </div>
      {!! Form::close() !!}
  </div>
</div>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>

@endsection