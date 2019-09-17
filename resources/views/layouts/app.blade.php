<!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="env" content="{{ App::environment()}}">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Texano | <?php isset($title) ? $title : 'title'; ?></title>
        <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/png">
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        @if($title =="create" or $title =="edit" )
        <link rel="stylesheet" href="{{ asset('css/toastr.css') }}">
        <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
        <script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
        @endif
        
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
        <script type="text/javascript">
            var  env = $('meta[name=env]').attr("content");
            console.log(env)    
        </script> 
        <style type="text/css">
        .ck-editor__editable{
        background: white;
        height: 260px
        ;overflow: auto;
        }
        </style>        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <!--Start of Tawk.to Script-->
<!--         <script type="text/javascript">
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
 -->        <!--End of Tawk.to Script-->
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
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
                            <li class="nav-item dropdown">
                                <a class="nav-link btn btn-sm btn-success" style="color:white" href="{{route('text.create')}}">
                                    <i class="fas fa-plus" style="font-size:14px;"></i>
                            
                                {{ trans('general.create_text') }}</a>
                            </li>
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
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fas fa-home"></i>  {{ Auth::user()->name }} <span class="caret"></span>
                                        </a>
                                        <div class="dropdown-menu" id="dropdownMenu">
                                            <a class="dropdown-item" href="#"> {{ Auth::user()->email }}  </a> 
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


                                  
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
            <main class="py-4">
                @yield('content')
                @yield('editorconrols')
            </main>
            
        </div>

    </body>
    </html>


    @yield('scripts')
    <script type="text/javascript">


    // CKEDITOR.disableAutoInline = true;
    // CKEDITOR.inline( 'editor1' );
    CKEDITOR.replace('editor1');

    // options = {
    //     success: function(files) {
    //     files.forEach(function(file) {
    //             var binaryData = [];
    //             binaryData.push(file);
    //             var file=window.URL.createObjectURL(new Blob(binaryData, {type: "application/zip"}))
    //         readDocxFile(file);
    //     });
    //     },
    //     cancel: function() {
    //     //optional
    //     },
    //     linkType: "preview", // "preview" or "direct"
    //     multiselect: false, // true or false
    //     extensions: ['.pdf', '.docx'],
    // };

    // var button = Dropbox.createChooseButton(options);
    // document.getElementById("upload-btns").appendChild(button);
    </script>
        @if($title =="create" or $title =="edit" )
            <script src="{{asset('js/index.js')}}"></script>
        @endif
    <!-- <script type="text/javascript" src="https://apis.google.com/js/api.js?onload=onApiLoad"></script> -->

