@extends('layouts.merchantlayout')
@section('content')
<div class="page-content">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>My Profile</span>
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
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> My Profile</h3>
    
    <div class="clearfix"></div>
    <div class="profile">
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
        <div class="row profile-account">
            <div class="col-md-3">
                <ul class="ver-inline-menu tabbable margin-bottom-10">
                    <li class="active">
                        <a data-toggle="tab" href="#tab_1-1" aria-expanded="false">
                            <i class="fa fa-cog"></i> Personal info </a>
                        <span class="after"> </span>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#tab_3-3" aria-expanded="false">
                            <i class="fa fa-lock"></i> Change Password </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="tab-content">
                    <div id="tab_1-1" class="tab-pane active">

                        <div class="responsive">
                            <table class="table table-striped">
                                <tr>
                                    <td><strong>Company Name:</strong></td>
                                    <td>{{$userDetails->company_name}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong></td>
                                    <td>{{$userDetails->email}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Address</strong></td>
                                    <td>{{$userDetails->address}}, {{$userDetails->city_name}}, {{$userDetails->state_name}}, {{$userDetails->country_name}}</td>
                                </tr>
                            </table>
                        </div>
                        <!-- <form role="form" action="#">
                            <div class="form-group">
                                <label class="control-label">First Name</label>
                                <input type="text" placeholder="John" class="form-control"> </div>
                            <div class="form-group">
                                <label class="control-label">Last Name</label>
                                <input type="text" placeholder="Doe" class="form-control"> </div>
                            <div class="form-group">
                                <label class="control-label">Mobile Number</label>
                                <input type="text" placeholder="+1 646 580 DEMO (6284)" class="form-control"> </div>
                            <div class="form-group">
                                <label class="control-label">Interests</label>
                                <input type="text" placeholder="Design, Web etc." class="form-control"> </div>
                            <div class="form-group">
                                <label class="control-label">Occupation</label>
                                <input type="text" placeholder="Web Developer" class="form-control"> </div>
                            <div class="form-group">
                                <label class="control-label">About</label>
                                <textarea class="form-control" rows="3" placeholder="We are KeenThemes!!!"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Website Url</label>
                                <input type="text" placeholder="http://www.mywebsite.com" class="form-control"> </div>
                            <div class="margiv-top-10">
                                <a href="javascript:;" class="btn green"> Save Changes </a>
                                <a href="javascript:;" class="btn default"> Cancel </a>
                            </div>
                        </form> -->
                    </div>
                    <div id="tab_2-2" class="tab-pane">
                        <p> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
                            </p>
                        <form action="#" role="form">
                            <div class="form-group">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""> </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                    <div>
                                        <span class="btn default btn-file">
                                            <span class="fileinput-new"> Select image </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" name="..."> </span>
                                        <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                                <div class="clearfix margin-top-10">
                                    <span class="label label-danger"> NOTE! </span>
                                    <span> Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only </span>
                                </div>
                            </div>
                            <div class="margin-top-10">
                                <a href="javascript:;" class="btn green"> Submit </a>
                                <a href="javascript:;" class="btn default"> Cancel </a>
                            </div>
                        </form>
                    </div>
                    <div id="tab_3-3" class="tab-pane">
                        <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group row">

                                <div class="col-md-12">
                                    <label for="email">{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email" class="form-control form-control-solid placeholder-no-fix form-group {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $userDetails->email ?? old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="password">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control form-control-solid placeholder-no-fix form-group {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control form-control-solid placeholder-no-fix form-group" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="tab_4-4" class="tab-pane">
                        <form action="#">
                            <table class="table table-bordered table-striped">
                                <tbody><tr>
                                    <td> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus.. </td>
                                    <td>
                                        <label class="uniform-inline">
                                            <div class="radio"><span><input type="radio" name="optionsRadios1" value="option1"></span></div> Yes </label>
                                        <label class="uniform-inline">
                                            <div class="radio"><span class="checked"><input type="radio" name="optionsRadios1" value="option2" checked=""></span></div> No </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                    <td>
                                        <label class="uniform-inline">
                                            <div class="checker"><span><input type="checkbox" value=""></span></div> Yes </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                    <td>
                                        <label class="uniform-inline">
                                            <div class="checker"><span><input type="checkbox" value=""></span></div> Yes </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                    <td>
                                        <label class="uniform-inline">
                                            <div class="checker"><span><input type="checkbox" value=""></span></div> Yes </label>
                                    </td>
                                </tr>
                            </tbody></table>
                            <!--end profile-settings-->
                            <div class="margin-top-10">
                                <a href="javascript:;" class="btn green"> Save Changes </a>
                                <a href="javascript:;" class="btn default"> Cancel </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--end col-md-9-->
        </div>
    </div>
</div>

@endsection