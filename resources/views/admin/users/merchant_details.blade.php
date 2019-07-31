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
              <span>Merchant</span>
              <i class="fa fa-circle"></i>
          </li>
          <li>
              <span>Details</span>
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

  <h3 class="page-title"> Merchant Details - {{ $merchantDetails->username }}
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
      {!! Form::open(['url'=>'/admin/update-merchant/'.$merchantDetails->id, 'class'=>'form', 'enctype'=>'multipart/form-data']) !!}
      <div class="col-md-7">
        <table class="table table-striped">
            <tr>
              <td>Merchant Name:</td>
              <td> {{ $merchantDetails->company_name}} </td>
            </tr>
            <tr>
              <td>Email:</td>
              <td> {{ $merchantDetails->email}} </td>
            </tr>
            <tr>
              <td>Username:</td>
              <td> {{ $merchantDetails->username }} </td>
            </tr>
            <tr>
              <td>Address:</td>
              <td> {{ $merchantDetails->address }}, {{ $merchantDetails->city_name }}
                    <br/>
                    {{ $merchantDetails->state_name }}, {{ $merchantDetails->country_name }}
               </td>
            </tr>
            <tr>
              <td>Site Url:</td>
              <td> {{ $merchantDetails->site_url}} </td>
            </tr>
        </table>
        <div class="form-group has-feedback">
          {!! Form::label('Status') !!}
          {!! Form::select('status', ['0'=>'Pending', '1'=>'Approved', '2'=>'Rejected'], $merchantDetails->status, ['class'=>'form-control', 'placeholder'=>'Select A Status']) !!}
        </div>       
        <div class="form-group">
          {!! Form::submit('Update', ['class'=>'btn btn-primary btn-block btn-flat']) !!}
        </div>
      </div>
      {!! Form::close() !!}
  </div>
</div>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>

@endsection