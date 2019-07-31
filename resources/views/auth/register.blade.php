@extends('layouts.frontlayout')

@section('content')
<div class="page-title parallax parallax1" style="background-position: 50% -132px;">
    <div class="section-overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12"> 
                <div class="page-title-heading">
                    <h1 class="title">Sign Up</h1>
                </div><!-- /.page-title-captions -->  
                <div class="breadcrumbs">
                    <ul>
                        <li class="home"><i class="fa fa-home"></i><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="#">Sign-up</a></li>
                    </ul>                   
                </div><!-- /.breadcrumbs --> 
            </div><!-- /.col-md-12 -->  
        </div><!-- /.row -->  
    </div><!-- /.container -->                      
</div>

<section class="flat-row section-product2">
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if (session('warning'))
            <div class="alert alert-danger">
                {{ session('warning') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <ul class="nav nav-tabs nav-pills nav-justified" id="myTab" role="tablist">
            <li class="nav-item active">
                <a class="nav-link" id="company-tab" data-toggle="tab" href="#company" role="tab" aria-controls="company" aria-selected="true"><h3>For Company</h3></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="merchant-tab" data-toggle="tab" href="#merchant" role="tab" aria-controls="merchant" aria-selected="false"><h3>For Merchant</h3></a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade in active entry-border" id="company" role="tabpanel" aria-labelledby="home-tab">
                <div class="inner">
                    <div class="col-md-7">
                        <form method="POST" action="{{ route('register') }}">
                            <h3>Company Registration Form</h3>
                            @csrf
                            <div class="form-group col-md-6">
                                <input type="hidden" name="reg_type" value="company">
                                <label for="name">{{ __('Username') }}</label>
                                <input id="name" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autocomplete="off" autocomplete="false"/>
                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autocomplete="off" autocomplete="false"/>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="form-group col-md-12">
                                <label for="company_name">Company Name</label>
                                <input class="form-control" type="text" name="company_name" placeholder="Company Name" required="required" autocomplete="off" autocomplete="false"/>
                                @if ($errors->has('company_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('company_name') }}</strong>
                                    </span>
                                @endif
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
                            <div class="form-group col-md-6">
                                <label for="city">Number of employee</label>
                                <input type="Number" name="no_of_employee" class="form-control" placeholder="Number of employee" min="2" autocomplete="off" autocomplete="false"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete="off" autocomplete="false" />
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="off" autocomplete="false"/>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-5 no-padding">
                        <img src="{{ asset('img/277.jpg')}}" alt="">
                    </div>
                </div>    
            </div>
            <div class="tab-pane fade entry-border" id="merchant" role="tabpanel" aria-labelledby="profile-tab">
                <div class="wrapper">
                    <div class="inner">
                        <div class="col-md-5 no-padding">
                            <img src="{{ asset('img/167.jpg')}}" alt="">
                        </div>
                        <div class="col-md-7">
                            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            <h3>Merchant Registration Form</h3>
                            @csrf
                            <div class="form-group col-md-6">
                                <label for="name">{{ __('Username') }}</label>
                                <input type="hidden" name="reg_type" value="merchant">
                                <input id="name" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autocomplete="off" autocomplete="false"/>
                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autocomplete="off" autocomplete="false"/>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="company_name">Merchant/Provider's Name</label>
                                <input class="form-control" type="text" name="company_name" placeholder="Merchant Name" required="required" autocomplete="off" autocomplete="false"/>
                                @if ($errors->has('company_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('company_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="company_name">Merchant Logo</label>
                                <input class="form-control" type="file" name="merchant_logo" placeholder="Merchant Logo" required="required"/>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="country">Site Url</label>
                                <input type="url" name="site_url" placeholder="http://example.com" pattern="http://.*" class="form-control" id="site_url" required="required" autocomplete="off" autocomplete="false"/>
                                @if ($errors->has('site_url'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('site_url') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-12">
                                <label for="address">Address</label>
                                <input class="form-control" type="text" name="address" placeholder="Address" required="required" autocomplete="off" autocomplete="false"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="country">Country</label>
                                <select name="country_id" placeholder="Country" class="form-control" id="country1" required="required" autocomplete="off" autocomplete="false"/>
                                    <option value="">Select A Country</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="state">State</label>
                                <select name="state_id"  class="form-control" placeholder="City" id="state1" required="required">
                                    <option value="">Select A State</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="city">City</label>
                                <select name="city_id" class="form-control" placeholder="City" id="city1">
                                    <option value="">Select A City</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete="off" autocomplete="false"/>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="off" autocomplete="false"/>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="flat-row section-client bg-section">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="flat-client" data-item="5" data-nav="false" data-dots="false" data-auto="false">
               <div class="client"><img src="{{ asset('img/slogo.png') }}" alt="image"></div>
               <div class="client"><img src="{{ asset('img/slogo.png') }}" alt="image"></div>
               <div class="client"><img src="{{ asset('img/slogo.png') }}" alt="image"></div>
               <div class="client"><img src="{{ asset('img/slogo.png') }}" alt="image"></div>
               <div class="client"><img src="{{ asset('img/slogo.png') }}" alt="image"></div>
            </div>
            <!-- /.flat-client -->      
         </div>
      </div>
   </div>
</section>
<script>
    $('#myTab a[href="#merchant"]').tab('show');
    $('#myTab a[href="#company"]').tab('show');

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

    $.ajax({
        type: 'GET',
        url:'{!! route('countries.data') !!}',
        data: {
          //'_token': token
        },
        success: function(data){
            $.each(data, function(i, item){
                $('#country1').append($('<option>',{
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

    $(document).on('change', '#country1', function(){
        $('#state1').empty();
        $('#state1').append($('<option>',{
            value: "",
            text: "Select A State",
        }));
        $.ajax({
            type: 'GET',
            url:'{!! route('getCountryStates.data') !!}',
            data: {
              //'_token': token,
              'country_id': $('#country1').val()
            },
            success: function(data){
                $.each(data, function(i, item){
                    $('#state1').append($('<option>',{
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
    $(document).on('change', '#state1', function(){
        $('#city1').empty();
        $('#city1').append($('<option>',{
            value: "",
            text: "Select A City",
        }));
        $.ajax({
            type: 'GET',
            url:'{!! route('cities.data') !!}',
            data: {
              //'_token': token,
              'state_id': $('#state1').val()
            },
            success: function(data){
                $.each(data, function(i, item){
                    $('#city1').append($('<option>',{
                        value: item.id,
                        text: item.name,
                    }));
                });
            }
        });
    });
</script>
@endsection

