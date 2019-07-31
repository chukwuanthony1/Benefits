<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Benefits App') }}</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
    <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.easing.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery-waypoints.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery-validate.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/smoothscroll.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/owl.carousel.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.flexslider-min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/headline.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/parallax.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/mainfront.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.themepunch.tools.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.themepunch.revolution.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/slider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/revolution.extension.actions.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/revolution.extension.carousel.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/revolution.extension.kenburn.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/revolution.extension.layeranimation.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/revolution.extension.migration.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/revolution.extension.navigation.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/revolution.extension.parallax.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/revolution.extension.slideanims.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/components.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/stylefrontend.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/headline.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/layers.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/shortcodes.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/settings.css') }}" rel="stylesheet" type="text/css" />
     <link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
</head>
<body class="header_sticky">
    
    <div id="loading-overlay">
        <div class="loader"></div>
    </div>

    <div class="boxed">
        <!-- <div class="top">
           <div class="container">
              <div class="row">
                 <div class="col-lg-6 col-sm-6 reponsive-onehalf">
                    <p class="info-text">Welcome to Financial Services Consultant!</p>
                 </div>      
                 <div class="col-lg-6 col-sm-6 reponsive-onehalf">
                    <div class="wrap-top">
                       <ul class="flat-top social-links">
                          <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                          <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                          <li class="google"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                       </ul>
                       <div class="flat-top flat-language">
                          <ul class="unstyled">
                             <li class="current">
                                <a href="#">English</a>
                                <ul class="unstyled">
                                   <li class="en"><a href="#">French</a></li>
                                   <li class="ge"><a href="#">German</a></li>
                                </ul>
                             </li>
                          </ul>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
        </div> -->

        <div class="flat-header-wrap">
               <!-- Header -->            
           <div class="header widget-header clearfix">
              <div class="container">
                 <div class="header-wrap clearfix">
                    <div class="row">
                       <div class="col-lg-3">
                          <div id="logo" class="logo">
                             <a href="{{ url('/userhome') }}" rel="home">
                                {{ config('app.name', 'Benefits App') }}
                             <!-- <img src="images/logo1.png" alt="image"> -->
                             </a>
                          </div>
                          <!-- /.logo -->
                       </div>
                       <div class="col-lg-9">
                          <div class="wrap-widget-header clearfix">
                            @guest
                                <aside  class="widget widget-info">
                                    <div class="btn-click">
                                       <a href="{{ route('login') }}" class="flat-button">SIGN IN</a>
                                    </div>
                                </aside>
                                @if (Route::has('register'))
                                    <aside  class="widget widget-info">
                                        <div class="btn-click">
                                           <a href="{{ route('register') }}" class="flat-button">SIGN UP</a>
                                        </div>
                                    </aside>
                                @endif
                            @else
                                <aside  class="widget widget-info">
                                    <div class="btn-click">
                                       <a class="flat-button" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </aside>
                                <aside  class="widget widget-info">
                                    <div class="btn-click">
                                       <a href="{{ url('/userprofile') }}" class="flat-button">{{ Auth::user()->username }}</a>
                                    </div>
                                </aside>
                            @endguest
                             <aside class="widget widget-info">
                                <div class="textwidget clearfix">
                                   <div class="info-icon">
                                      <i class="fa fa-map-marker"></i>
                                   </div>
                                   <div class="info-text">
                                      <h6>{{ config('app.address', '10 Lorem Ipsum') }}</h6>
                                      <p>{{ config('app.state', 'Lagos') }}, {{ config('app.country', 'NG') }}</p>
                                   </div>
                                </div>
                             </aside>
                             <aside class="widget widget-info">
                                <div class="textwidget clearfix">
                                   <div class="info-icon">
                                      <i class="fa fa-phone"></i>
                                   </div>
                                   <div class="info-text">
                                      <h6>{{ config('app.tel', '081-653-8368') }}</h6>
                                      <p>{{ config('app.email', 'info@benefit-app.com') }}</p>
                                   </div>
                                </div>
                             </aside>
                          </div>
                       </div>
                    </div>
                    <!-- /.row -->                   
                 </div>
                 <!-- /.header-wrap -->                 
              </div>
           </div>
           <!-- /.header -->
           <header id="header" class="header header-classic header-style1 downscrolled">
              <div class="container">
                 <div class="row">
                    <div class="col-md-12">
                       <div class="flat-wrap-header">
                          <div class="nav-wrap clearfix">
                             <nav id="mainnav" class="mainnav">
                                <ul class="menu">
                                   <li class="active">
                                      <a href="{{ url('/userhome') }}">Home</a> 
                                   </li>
                                   <li><a href="#">About Us</a></li>
                                   <li>
                                      <a href="#">Services</a>
                                      <!-- <ul class="submenu">
                                         <li><a href="services.html">Services Style 01</a></li>
                                         <li><a href="services-v2.html">Services Style 02</a></li>
                                         <li><a href="services-details.html">Services Details</a></li>
                                      </ul> -->
                                   </li>
                                   <li>
                                        <a href="#">Contact</a>
                                        <!-- <ul class="submenu right">
                                             <li><a href="contact.html">Contact Style 01</a></li>
                                             <li><a href="contact-v2.html">Contact Style 02</a></li>
                                        </ul> -->
                                   </li>
                                </ul>
                                <!-- /.menu -->
                             </nav>
                             <!-- /.mainnav -->  
                             <div class="top-search">
                                <form action="#" id="searchform-all" method="get">
                                   <div>
                                      <input type="text" id="input-search" class="sss" placeholder="Search...">
                                      <input type="submit" id="searchsubmit">
                                   </div>
                                </form>
                             </div>
                             <ul class="menu menu-extra">
                                <li id="s" class="show-search">
                                   <a href="#search" class="flat-search"><i class="fa fa-search"></i></a>
                                </li>
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li class="google"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                             </ul>
                             <div class="btn-menu">
                                <span></span>
                             </div>
                             <!-- //mobile menu button --> 
                          </div>
                          <!-- /.nav-wrap -->
                       </div>
                    </div>
                 </div>
              </div>
           </header>
        </div>

        @yield('content')

        <footer class="footer widget-footer">
            <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-6 reponsive-mb30">
                    <div class="widget-logo">
                       <div id="logo-footer" class="logo">
                          <a href="index.html" rel="home">
                            <!-- <img src="images/logofooter1.png" alt="image"> -->
                            <h3 class="widget-title">{{ config('app.name', 'Benefits App') }}</h3>
                          </a>
                       </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore</p>
                       <ul class="flat-information">
                          <li><i class="fa fa-map-marker"></i><a href="#">{{ config('app.address', '10 Lorem Ipsum') }} {{ config('app.state', 'Lagos') }} {{ config('app.country', 'NG') }}</a></li>
                          <li><i class="fa fa-phone"></i><a href="#">{{ config('app.tel', '081-653-8368') }}</a></li>
                          <li><i class="fa fa-envelope"></i><a href="#">{{ config('app.email', 'info@benefit-app.com') }}</a></li>
                       </ul>
                    </div>
                </div>
             <!-- /.col-md-3 --> 
                <div class="col-lg-2 col-sm-6 reponsive-mb30">
                    <div class="widget widget-out-link clearfix">
                        <h5 class="widget-title">Our Links</h5>
                        <ul class="one">
                            <li><a href="index.html">Home</a></li>
                            <li><a href="about-us.html">About Us</a></li>
                            <li><a href="services.html">Benefits</a></li>
                            <li><a href="projects.html">Contacts</a></li>
                        </ul>
                    </div>
                </div>
                 <!-- /.col-md-3 -->
                <div class="col-lg-3 col-sm-6 reponsive-mb30">
                    <div class="widget widget-recent-new">
                        <h5 class="widget-title">Recent News</h5>
                        <ul class="popular-new">
                          <li>
                             <div class="text">
                                <h6><a href="#">Colombia Gets a Business Makeover</a></h6>
                                <span>20 Aug 2017</span>
                             </div>
                          </li>
                          <li>
                             <div class="text">
                                <h6><a href="#">Counting the Cost of Delay & Disruption</a></h6>
                                <span>20 Aug 2017</span>
                             </div>
                          </li>
                       </ul>
                    </div>
                 </div>
                <!-- /.col-md-3 -->
                <div class="col-lg-3 col-sm-6 reponsive-mb30">
                    <div class="widget widget-letter">
                       <h5 class="widget-title">Newsletter</h5>
                       <p class="info-text">Subscribe our newsletter gor get noti-fication about new updates, etc.</p>
                       <form id="subscribe-form" class="flat-mailchimp" method="post" action="#" data-mailchimp="true">
                          <div class="field clearfix" id="subscribe-content">
                             <p class="wrap-input-email">
                                <input type="text" tabindex="2" id="subscribe-email" name="subscribe-email" placeholder="Enter Your Email">
                             </p>
                             <p class="wrap-btn">
                                <button type="button" id="subscribe-button" class="flat-button subscribe-submit" title="Subscribe now">SUBSCRIBE</button>
                             </p>
                          </div>
                          <div id="subscribe-msg"></div>
                       </form>
                    </div>
                 </div>
              </div>
            </div>
        </footer>
        <div class="bottom">
           <div class="container">
              <div class="row">
                 <div class="col-md-6 col-sm-6">
                    <div class="copyright">
                       <p>@<?php echo date('Y'); ?> <a href="#">{{ config('app.name', 'Benefits App') }}</a>. All rights reserved.
                       </p>
                    </div>
                 </div>
                 <div class="col-md-6 col-sm-6">
                    <ul class="social-links style2 text-right">
                       <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                       <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                       <li><a href="#"><i class="fa fa-vimeo"></i></a></li>
                       <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                       <li><a href="#"><i class="fa fa-skype"></i></a></li>
                    </ul>
                 </div>
              </div>
           </div>
           <!-- /.container -->
        </div>
        <!-- bottom -->
        <!-- Go Top -->
        <a class="go-top">
            <i class="fa fa-angle-up"></i>
        </a>
    </div>

</body>
</html>
