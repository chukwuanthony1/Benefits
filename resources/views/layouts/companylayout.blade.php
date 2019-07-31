<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>{{ config('app.name', 'Benefits App') }}</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />

        <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/jquery.blockui.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/moment.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/app.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/layout.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/demo.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/quick-sidebar.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/jquery.dataTables.min.js') }} "></script>
        <script src="{{ asset('js/jquery-ui.min.js') }} "></script>
        <script src="{{ asset('js/sweetalert.min.js') }} "></script>
        <script src="{{ asset('js/bootstrap-datepicker.min.js') }} "></script>
        <script src="{{ asset('js/charts_loader.js') }}"></script>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/components.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/layout.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/themes/light.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
        <link href="{{ asset('css/custom.min.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/datatables.bootstrap.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}" type="text/css">
        <link rel="shortcut icon" href="favicon.ico" />
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <div class="page-header navbar navbar-fixed-top">
            <div class="page-header-inner ">
                <div class="page-logo">
                    <a href="#" style="color:#fff;">
                        <h4>My Company Portal</h4>
                    </a>
                    <div class="menu-toggler sidebar-toggler"> </div>
                </div>
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <li class="dropdown dropdown-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <img alt="" class="img-circle" src="/img/avatar3_small.jpg" />
                                <span class="username username-hide-on-mobile"> {{ Auth::user()->username }} </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li>
                                    <a href="{{url('/userprofile')}}">
                                        <i class="fa fa-user"></i> My Profile </a>
                                </li>
                                <!-- <li>
                                    <a href="app_calendar.html">
                                        <i class="icon-calendar"></i> My Calendar </a>
                                </li>
                                <li>
                                    <a href="app_inbox.html">
                                        <i class="icon-envelope-open"></i> My Inbox
                                        <span class="badge badge-danger"> 3 </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="app_todo.html">
                                        <i class="icon-rocket"></i> My Tasks
                                        <span class="badge badge-success"> 7 </span>
                                    </a>
                                </li> -->
                                <li class="divider"> </li>
                                <li>
                                    <a class="flat-button" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa fa-key"></i>{{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                        <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-quick-sidebar-toggler">
                            <a href="javascript:;" class="dropdown-toggle">
                                <i class="icon-logout"></i>
                            </a>
                        </li>
                        <!-- END QUICK SIDEBAR TOGGLER -->
                    </ul>
                </div>
            </div>
        </div>
        <div class="clearfix"> </div>
        <div class="page-container">
            <div class="page-sidebar-wrapper">
                <div class="page-sidebar navbar-collapse collapse">
                    <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 10px">
                        <!-- <li class="heading">
                            <h3 class="uppercase">Features</h3>
                        </li> -->
                        <li class="sidebar-search-wrapper">
                            <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                            <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                            <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                            
                            <!-- END RESPONSIVE QUICK SEARCH FORM -->
                        </li>
                        <br/>
                        <br/>
                        <br/>
                        <li class="nav-item">
                            <a href="{{ route('company.dashboard') }}" class="nav-link ">
                                <i class="fa fa-line-chart"></i>
                                <span class="title">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('company.invites') }}" class="nav-link ">
                                <i class="fa fa-th-list"></i>
                                <span class="title">Company Invite</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('company.employees') }}" class="nav-link ">
                                <i class="fa fa-th-list"></i>
                                <span class="title">All Employees</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('company.employee.new') }}" class="nav-link ">
                                <i class="fa fa-th-list"></i>
                                <span class="title">New Employee</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('company.employees.upload') }}" class="nav-link ">
                                <i class="fa fa-th-list"></i>
                                <span class="title">Upload New Employees</span>
                            </a>
                        </li>
                        
                        <!-- <li class="nav-item  ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-user"></i>
                                <span class="title">Users Mgt</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item">
                                    <a href="{{ route('admin.adminusers') }}" class="nav-link ">
                                        <i class="fa fa-th-list"></i>
                                        <span class="title">Admins</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.approvedmerchants') }}" class="nav-link ">
                                        <i class="fa fa-th-list"></i>
                                        <span class="title">Approved Merchants</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.pendingmerchants') }}" class="nav-link ">
                                        <i class="fa fa-th-list"></i>
                                        <span class="title">Pending Merchants</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.approvedcompanies') }}" class="nav-link">
                                        <i class="fa fa-th-list"></i>
                                        <span class="title">Approved Companies</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.pendingcompanies') }}" class="nav-link ">
                                        <i class="fa fa-th-list"></i>
                                        <span class="title">Pending Companies</span>
                                    </a>
                                </li>
                            </ul>
                        </li> -->
                        
                    </ul>
                </div>
            </div>
            <div class="page-content-wrapper">
                @yield('content')
            </div>
        </div>
        
        <div class="page-footer">
            <div class="page-footer-inner"><?php echo date('YYYY'); ?> &copy;.
                <a href="#">{{ config('app.name', 'BenefitApp') }}</a>
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
    </body>
</html>