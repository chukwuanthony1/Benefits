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
              <span>Coupon</span>
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
  <h3 class="page-title"> New Coupon
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
    {!! Form::open(['url'=>'/merchant/coupon/new', 'class'=>'form', 'enctype'=>'multipart/form-data']) !!}
    <div class="col-md-7">
      <div class="form-group has-feedback">
        {!! Form::label('Coupon Name') !!}
        {!! Form::text('name', null, ['class'=>'form-control', 'autocomplete'=>'false', 'autocomplete'=>'off', 'required'=>'required']) !!}
      </div>
      <div class="form-group has-feedback">
        {!! Form::label('Coupon Code') !!}
        {!! Form::text('code', null, ['class'=>'form-control', 'autocomplete'=>'false', 'autocomplete'=>'off', 'required'=>'required']) !!}
      </div>
      <div class="form-group has-feedback">
        {!! Form::label('Coupon Code') !!}
        <div class="input-group date date-picker start_date" data-date-format="dd-mm-yyyy" data-date-start-date="+0d" data-date-autoclose="true">
          {!! Form::text('start_date', null, ['class'=>'form-control', 'autocomplete'=>'false', 'autocomplete'=>'off', 'required'=>'required', 'readonly'=>'true']) !!}
          <span class="input-group-btn">
              <button class="btn default" type="button">
                  <i class="fa fa-calendar"></i>
              </button>
          </span>
        </div>
      </div>
      <div class="form-group has-feedback">
        {!! Form::label('End Date') !!}
        <div class="input-group date date-picker start_date" data-date-format="dd-mm-yyyy" data-date-autoclose="true">
          {!! Form::text('end_date', null, ['class'=>'form-control', 'autocomplete'=>'false', 'autocomplete'=>'off', 'required'=>'required', 'readonly'=>'true']) !!}
          <span class="input-group-btn">
              <button class="btn default" type="button">
                  <i class="fa fa-calendar"></i>
              </button>
          </span>
        </div>
      </div>
      <div class="form-group">
        {!! Form::submit('Submit', ['class'=>'btn btn-primary btn-block btn-flat']) !!}
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</div>
<script type="text/javascript">
  $('.start_date').datepicker();
  $('.end_date').datepicker();
</script>
@endsection

