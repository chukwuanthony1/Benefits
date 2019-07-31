@extends('layouts.companylayout')
@section('content')
<div class="page-content">
  <div class="page-bar">
      <ul class="page-breadcrumb">
          <li>
              <a href="#">Home</a>
              <i class="fa fa-circle"></i>
          </li>
          <li>
              <span>Employee</span>
          </li>
          <li>
              <span>Upload</span>
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
  <h3 class="page-title"> Upload Employee
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
      @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif
      <form method="POST" action="{{ route('company.employees.upload') }}" enctype="multipart/form-data">
        <!-- <h3>Company Registration Form</h3> -->
        @csrf
        <div class="form-group col-md-6">
            <!-- <input type="hidden" name="reg_type" value="company"> -->
            <label for="uploadfile">{{ __('Upload') }}</label>
            <input id="uploadfile" type="file" class="form-control" name="uploadfile" required/>
        </div>

        <div class="clearfix"></div>
        <div class="form-group">
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">
                    {{ __('Submit') }}
                </button>
            </div>
        </div>
        <br/>
        <div class="clearfix"></div>
        <div class="form-group col-md-6">
          <h3>Kindly download and use the <a href="{{ asset('file/SampleUpload.xlsx')}}">sample excel format</a></h3>
        </div>
      </form>

      @if(session('status'))
        <div class="alert alert-warning">
          {{ session('status') }}
        </div>
      @endif
  </div>
</div>

@endsection

