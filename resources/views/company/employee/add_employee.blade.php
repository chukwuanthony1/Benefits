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
  <h3 class="page-title"> New Employee
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
      <form method="POST" action="{{ route('company.employee.new') }}">
        <!-- <h3>Company Registration Form</h3> -->
        @csrf
        <div class="form-group col-md-6">
            <!-- <input type="hidden" name="reg_type" value="company"> -->
            <label for="name">{{ __('Firstname') }}</label>
            <input id="name" type="text" class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" required autocomplete="off" autocomplete="false"/>
        </div>
        <div class="form-group col-md-6">
            <label for="last_name">{{ __('Lastname') }}</label>
            <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required autocomplete="off" autocomplete="false"/>
        </div>
        
        <div class="form-group col-md-6">
            <label for="email">Email Address</label>
            <input class="form-control" type="email" name="email" placeholder="Email" required="required" autocomplete="off" autocomplete="false"/>
        </div>
        <div class="form-group col-md-6">
            <label for="phone_no">Phone Number</label>
            <input class="form-control" type="text" name="phone_no" placeholder="Phone No" required="required" autocomplete="off" autocomplete="false"/>
        </div>
        <div class="form-group col-md-12">
            <label for="address">Address</label>
            <input class="form-control" type="text" name="address" placeholder="Address" required="required">
        </div>
        <div class="form-group col-md-6">
            <label for="country">Country</label>
            <select name="country_id" placeholder="Country" class="form-control" id="country" required="required">
                <option value="">Select A Country</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="state">State</label>
            <select name="state_id"  class="form-control" placeholder="City" id="state" required="required">
                <option value="">Select A State</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="city">City</label>
            <select name="city_id" class="form-control" placeholder="City" id="city">
                <option value="">Select A City</option>
            </select>
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
<script>

    var token = '{{ csrf_token() }}';
    $.ajax({
        type: 'GET',
        url:'{!! route('countries.data') !!}',
        data: {
          //'_token': token
        },
        success: function(data){
            $.each(data, function(i, item){
                $('#country').append($('<option>',{
                    value: item.id,
                    text: item.name,
                }));
            });
        }
    });

    $(document).on('change', '#country', function(){
        $('#state').empty();
        $('#state').append($('<option>',{
            value: "",
            text: "Select A State",
        }));
        $.ajax({
            type: 'GET',
            url:'{!! route('getCountryStates.data') !!}',
            data: {
              //'_token': token,
              'country_id': $('#country').val()
            },
            success: function(data){
                $.each(data, function(i, item){
                    $('#state').append($('<option>',{
                        value: item.id,
                        text: item.name,
                    }));
                });
            }
        });
    });

    $(document).on('change', '#state', function(){
        $('#city').empty();
        $('#city').append($('<option>',{
            value: "",
            text: "Select A City",
        }));
        $.ajax({
            type: 'GET',
            url:'{!! route('cities.data') !!}',
            data: {
              //'_token': token,
              'state_id': $('#state').val()
            },
            success: function(data){
                $.each(data, function(i, item){
                    $('#city').append($('<option>',{
                        value: item.id,
                        text: item.name,
                    }));
                });
            }
        });
    });
    
</script>
@endsection

