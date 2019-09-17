<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="env" content="{{ App::environment()}}">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <link rel="shortcut icon" href="img/favicon.ico" type="image/png">
    <title>Texano</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/linericon/style.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/owl-carousel/owl.carousel.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/nice-select/css/nice-select.css">
    <link rel="stylesheet" href="css/animate-css/animate.css">
    <link rel="stylesheet" href="css/flaticon/flaticon.css">
    <!-- main css -->
    <link rel="stylesheet" href="css/style_home.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/5ca999d5557d5f68515b42a9/default';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->
</head>

<body>

<!--================Header Menu Area =================-->
<header class="header_area">
    <div class="main_menu">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel fixed-top ">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}"><img src="{{asset('img/logo_new.png')}}"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            
                            <!-- <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                             
                                               language
                                         <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ url('/lang/en') }}">
                                               <img src="{{ asset('svg/united-kingdom.svg') }}" width="30px"> english
                                            </a>
                                            <a class="dropdown-item" href="{{ url('/lang/dutch') }}">
                                               <img src="{{ asset('svg/germany.svg') }}" width="30px"> deutsch
                                            </a>
                                    </div>

                                </li> -->

                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <div class="btn-group">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fas fa-home"></i>  {{ Auth::user()->name }} <span class="caret"></span>
                                        </a>
                                        <div class="dropdown-menu" id="dropdownMenu">
                                             {{ Auth::user()->email }} <span class="caret"></span>
                                            <a class="dropdown-item" href="#" id="dropbox"></a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{route('home',['tab'=>'plan-usage'])}}"><i class="fa fa-user"></i>&nbsp;My Account </a>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                                <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>

                                        </div>

                                    </div>

                                  
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

    </div>
</header>


<!--================Home Banner Area =================-->
<section class="home_banner_area">
    <div class="banner_inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="banner_content">
                        <h2>
                            {{ trans('welcome.description_title') }}
                        </h2>
                        <p>
                             {{ trans('welcome.description') }}
                        </p>
                        <div class="d-flex align-items-center">
                            <a class="primary_btn" href="{{ route('register') }}"><span>{{ trans('welcome.get_started') }}</span></a>
                            <a id="play-home-video" class="video-play-button"
                               href="https://www.youtube.com/watch?v=cy6csTnsKLY">
                                <span></span>
                            </a>
                            <div class="watch_video text-uppercase">
                                {{ trans('welcome.watch_the_video') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="home_right_img">
                        <img class="img-fluid" src="img/newComputer.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<div id="generic_price_table">
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!--PRICE HEADING START-->
                    <div class="price-heading clearfix">
                        <h1>Plans & Pricing</h1>
                    </div>
                    <!--//PRICE HEADING END-->
                </div>
            </div>
        </div>
        <div class="container">

            <!--BLOCK ROW START-->
            <div class="row">
                <div class="col-md-4">

                    <!--PRICE CONTENT START-->
                    <div class="generic_content clearfix">

                        <!--HEAD PRICE DETAIL START-->
                        <div class="generic_head_price clearfix">

                            <!--HEAD CONTENT START-->
                            <div class="generic_head_content clearfix">

                                <!--HEAD START-->
                                <div class="head_bg"></div>
                                <div class="head">
                                    <span>Free</span>
                                </div>
                                <!--//HEAD END-->

                            </div>
                            <!--//HEAD CONTENT END-->

                            <!--PRICE START-->
                            <div class="generic_price_tag clearfix">
                                <span class="price">
                                    <span class="sign"><a class="" href="">Sign up</a> and try</span>

                                </span>
                            </div>
                            <!--//PRICE END-->

                        </div>
                        <!--//HEAD PRICE DETAIL END-->

                        <!--FEATURE LIST START-->
                        <div class="generic_feature_list">
                            <ul>
                                <li><span>1000</span> QUERIES PER MONTH</li>
                                <li><span>10GB</span> Storage</li>
                                <li><span>1</span> Accounts</li>
                                <li><span>No</span> Support</li>
                            </ul>
                        </div>
                        <!--//FEATURE LIST END-->

                        <!--BUTTON START-->
                        <div class="generic_price_btn clearfix">
                            <a class="" href="{{ route('register') }}">Sign up</a>
                        </div>
                        <!--//BUTTON END-->

                    </div>
                    <!--//PRICE CONTENT END-->

                </div>

                <div class="col-md-4">

                    <!--PRICE CONTENT START-->
                    <div class="generic_content active clearfix">

                        <!--HEAD PRICE DETAIL START-->
                        <div class="generic_head_price clearfix">

                            <!--HEAD CONTENT START-->
                            <div class="generic_head_content clearfix">

                                <!--HEAD START-->
                                <div class="head_bg"></div>
                                <div class="head">
                                    <span>Pro</span>
                                </div>
                                <!--//HEAD END-->

                            </div>
                            <!--//HEAD CONTENT END-->

                            <!--PRICE START-->
                            <div class="generic_price_tag clearfix">
                                <span class="price">
                                    <span class="sign">$</span>
                                    <span class="currency">19</span>
                                    <span class="cent">.99</span>
                                    <span class="month">/MON</span>
                                </span>
                            </div>
                            <!--//PRICE END-->

                        </div>
                        <!--//HEAD PRICE DETAIL END-->

                        <!--FEATURE LIST START-->
                        <div class="generic_feature_list">
                            <ul>
                                <li><span>10000</span> QUERIES PER MONTH</li>
                                <li><span>50GB</span> Storage</li>
                                <li><span>3</span> Accounts</li>
                                <li><span>Email</span> Support</li>
                            </ul>
                        </div>
                        <!--//FEATURE LIST END-->

                        <!--BUTTON START-->
                        <div class="generic_price_btn clearfix">
                            <a class="" href="{{ route('register') }}">Sign up</a>
                        </div>
                        <!--//BUTTON END-->

                    </div>
                    <!--//PRICE CONTENT END-->

                </div>
                <div class="col-md-4">

                    <!--PRICE CONTENT START-->
                    <div class="generic_content clearfix">

                        <!--HEAD PRICE DETAIL START-->
                        <div class="generic_head_price clearfix">

                            <!--HEAD CONTENT START-->
                            <div class="generic_head_content clearfix">

                                <!--HEAD START-->
                                <div class="head_bg"></div>
                                <div class="head">
                                    <span>Entreprise</span>
                                </div>
                                <!--//HEAD END-->

                            </div>
                            <!--//HEAD CONTENT END-->

                            <!--PRICE START-->
                            <div class="generic_price_tag clearfix">
                                <span class="price">
                                    <span class="sign">On demand</span>
                                </span>
                            </div>
                            <!--//PRICE END-->

                        </div>
                        <!--//HEAD PRICE DETAIL END-->

                        <!--FEATURE LIST START-->
                        <div class="generic_feature_list">
                            <ul>
                                <li><span>On demand</span> QUERIES PER MONTH</li>
                                <li><span>On demand</span> Storage</li>
                                <li><span>On demand</span> Accounts</li>
                                <li><span>24/7</span> Support</li>
                            </ul>
                        </div>
                        <!--//FEATURE LIST END-->

                        <!--BUTTON START-->
                        <div class="generic_price_btn clearfix">
{{--                            TODO - Add a page to request a demo --}}
                            <a class="" href="">Request a demo</a>
                        </div>
                        <!--//BUTTON END-->

                    </div>
                    <!--//PRICE CONTENT END-->

                </div>
            </div>
            <!--//BLOCK ROW END-->

        </div>
    </section>

</div>


<!--&lt;!&ndash;================Footer Area =================&ndash;&gt;-->
<footer class="footer_area">
    <div class="container">
        <div class="row footer_inner">
            <div class="col-lg-5 col-sm-6">
                <aside class="f_widget ab_widget">
                    <div class="f_title">
                        <h3>About Me</h3>
                    </div>

                    <p>
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                        All rights reserved | This App is made with <i class="fa fa-heart-o" aria-hidden="true"></i> in
                        Frankfurt.</a>
                        Landing page using <a href="https://colorlib.com/">Colorlib</a>
                    </p>
                </aside>
            </div>
            <div class="col-lg-5 col-sm-6">
                <aside class="f_widget news_widget">
                    <div class="f_title">
                        <h3>Newsletter</h3>
                    </div>
                    <p>Stay updated with our latest trends</p>
                    <div id="mc_embed_signup">
                        <form target="_blank"
                              action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01"
                              method="get" class="subscribe_form relative">
                            <div class="input-group d-flex flex-row">
                                <input name="EMAIL" placeholder="Enter email address" onfocus="this.placeholder = ''"
                                       onblur="this.placeholder = 'Email Address '"
                                       required="" type="email">
                                <button class="btn sub-btn"><span class="lnr lnr-arrow-right"></span></button>
                            </div>
                            <div class="mt-10 info"></div>
                        </form>
                    </div>
                </aside>
            </div>
            <div class="col-lg-2">
                <aside class="f_widget social_widget">
                    <div class="f_title">
                        <h3>Follow Me</h3>
                    </div>
                    <p>Let us be social</p>
                    <ul class="list">
                        <li><a href="https://www.linkedin.com/in/anwar-benhamada-831896129/"><i
                                        class="fa fa-linkedin"></i></a></li>
                    </ul>
                </aside>
            </div>
        </div>
    </div>
</footer>
<!--================End Footer Area =================-->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/stellar.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/nice-select/js/jquery.nice-select.min.js"></script>
<script src="js/isotope/imagesloaded.pkgd.min.js"></script>
<script src="js/isotope/isotope-min.js"></script>
<script src="css/owl-carousel/owl.carousel.min.js"></script>
<script src="js/jquery.ajaxchimp.min.js"></script>
<script src="js/counter-up/jquery.waypoints.min.js"></script>
<script src="js/counter-up/jquery.counterup.min.js"></script>
<script src="js/mail-script.js"></script>
<!--gmaps Js-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
<script src="js/gmaps.min.js"></script>
<script src="js/theme.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-131917443-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-131917443-1');
</script>
</body>

</html>