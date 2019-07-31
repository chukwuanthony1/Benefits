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
              <span>Company</span>
              <i class="fa fa-circle"></i>
          </li>
          <li>
              <span>Invite</span>
              <i class="fa fa-circle"></i>
          </li>
          <li>
              <span>New</span>
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
  <h3 class="page-title"> New Invites
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
      <form method="POST" action="{{ route('company.invites.new') }}">
        <!-- <h3>Company Registration Form</h3> -->
        @csrf
        <div class="form-group col-md-6">
            <label for="name">{{ __('Paste email address(es)') }}</label>
            <br/>
            <span class="small"> Kindly seperate the email addresses using comma(,)</span>
            <br/>
            <textarea id="email_address"  name="email_address" class="form-control {{ $errors->has('email_address') ? ' is-invalid' : '' }}" rows="12" required autocomplete="off" autocomplete="false"></textarea>
        </div>

        <div class="clearfix"></div>
        <div class="form-group">
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">
                    {{ __('Submit') }}
                </button>
            </div>
        </div>
    </form>
  </div>
</div>

@endsection

