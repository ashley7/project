<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ config('app.name', 'Laravel') }}</title>

  <meta charset="utf-8">
  <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Google Fonts -->
  <link href='https://fonts.googleapis.com/css?family=Montserrat:400,600,700%7CSource+Sans+Pro:400,600,700' rel='stylesheet'>


  <!-- Css -->
  <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('frontend/css/font-icons.css') }}" />
  <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" />

  <!-- Favicons -->
  <link rel="shortcut icon" href="{{ asset('images/icon.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('frontend/img/apple-touch-icon.png') }}">
  <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('frontend/img/apple-touch-icon-72x72.png') }}">
  <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('frontend/img/apple-touch-icon-114x114.png') }}">

  <!-- Lazyload (must be placed in head in order to work) -->
  <script src="{{ asset('frontend/js/lazysizes.min.js') }}"></script>

</head>

<body class="bg-light style-default style-rounded">

  <!-- Preloader -->
  <div class="loader-mask">
    <div class="loader">
      <div></div>
    </div>
  </div>

  <!-- Bg Overlay -->
  <div class="content-overlay"></div>

  <!-- Sidenav -->    
  <header class="sidenav" id="sidenav">

    <!-- close -->
    <div class="sidenav__close">
      <button class="sidenav__close-button" id="sidenav__close-button" aria-label="close sidenav">
        <i class="ui-close sidenav__close-icon"></i>
      </button>
    </div>
    
    <!-- Nav -->
    <nav class="sidenav__menu-container">
      <ul class="sidenav__menu" role="menubar">
        <li>
          <a href="{{ url('/') }}" class="sidenav__menu-url">Home</a>
          <button class="sidenav__menu-toggle" aria-haspopup="true" aria-label="Open dropdown"><i class="ui-arrow-down"></i></button>
        </li>  

        <li>
          <a href="{{ url('news') }}" class="sidenav__menu-url">News Feed</a>
          <button class="sidenav__menu-toggle" aria-haspopup="true" aria-label="Open dropdown"><i class="ui-arrow-down"></i></button>
        </li>  

        <li>
          <a href="{{ url('blog') }}" class="sidenav__menu-url">Blog</a>
          <button class="sidenav__menu-toggle" aria-haspopup="true" aria-label="Open dropdown"><i class="ui-arrow-down"></i></button>
        </li>  

        <li>
          <a href="{{ url('discussion') }}" class="sidenav__menu-url">Discussion Forum</a>
          <button class="sidenav__menu-toggle" aria-haspopup="true" aria-label="Open dropdown"><i class="ui-arrow-down"></i></button>
        </li>  

        
        <li>
          <a href="{{ url('publications') }}" class="sidenav__menu-url">Publications Forum</a>
          <button class="sidenav__menu-toggle" aria-haspopup="true" aria-label="Open dropdown"><i class="ui-arrow-down"></i></button>
        </li>  
        @if (Route::has('login'))
        @auth
        <li ><a href="{{ url('profile') }}" class="sidenav__menu-url">Welcome, <span style="color:#000"> {{ Auth::User()->surname }}</span></a>
        </li>
        <li>
                      <a href="{{ route('logout') }}" class="sidenav__menu-url"
                      onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out pull-right"></i> Sign out |</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                    </form>
         </li>
        
        @else
     <li>
          <a href="{{ route('login') }}" class="sidenav__menu-url">Login</a>
          <button class="sidenav__menu-toggle" aria-haspopup="true" aria-label="Open dropdown"><i class="ui-arrow-down"></i></button>
        </li>  
        @if (Route::has('register'))
           
              <li>
                <a href="{{ route('register') }}" class="sidenav__menu-url">register</a>
                <button class="sidenav__menu-toggle" aria-haspopup="true" aria-label="Open dropdown"><i class="ui-arrow-down"></i></button>
              </li> 
        @endif
    @endauth
@endif

      

        
        {{-- <li class="pull-right"><a href="{{ url('profile') }}">Welcome, <span style="color:#000"> {{ Auth::User()->surname }}</span></a></li>
        <li class="pull-right">
            <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
          <i class="fa fa-sign-out pull-right"></i> Sign out |</a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
          </form>
        </li> --}}
      

        





      </ul>
    </nav>

    <div class="socials sidenav__socials"> 
      <a class="social social-facebook" href="#" target="_blank" aria-label="facebook">
        <i class="ui-facebook"></i>
      </a>
      <a class="social social-twitter" href="#" target="_blank" aria-label="twitter">
        <i class="ui-twitter"></i>
      </a>
      <a class="social social-google-plus" href="#" target="_blank" aria-label="google">
        <i class="ui-google"></i>
      </a>
      <a class="social social-youtube" href="#" target="_blank" aria-label="youtube">
        <i class="ui-youtube"></i>
      </a>
      <a class="social social-instagram" href="#" target="_blank" aria-label="instagram">
        <i class="ui-instagram"></i>
      </a>
    </div>
  </header> <!-- end sidenav -->

  <main class="main oh" id="main">

    <!-- Top Bar -->
    <div class="top-bar d-none d-lg-block">
      <div class="container">
        <div class="row">

          <!-- Top menu -->
          <div class="col-lg-6">
            <ul class="top-menu">
              <li><a href="#">ABOUT</a></li>
              <li><a href="#">CONTACT</a></li>

              @if (Route::has('login'))
                  @auth
                  <li class="pull-right"><a href="{{ url('profile') }}">Welcome, <span style="color:#000"> {{ Auth::User()->surname }}</span></a></li>
                  <li class="pull-right">
                      <a href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out pull-right"></i> Sign out |</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                    </form>
                  </li>
                 @can ('dashboard-index')
                 <li class="pull-right"><a href="{{ url('home', []) }}"> | Admin Dashborad </a></li>
                 @endcan
                  @else
                      <li class="pull-right"><a href="{{ route('login') }}">Login</a></li>

                      @if (Route::has('register'))
                            <li class="pull-right"><a href="{{ route('register') }}">Register</a></li>
                      @endif
                  @endauth
          @endif


           
            </ul>
          </div>
          
          <!-- Socials -->
          <div class="col-lg-6">
            <div class="socials nav__socials socials--nobase socials--white justify-content-end"> 
              <a class="social social-facebook" href="#" target="_blank" aria-label="facebook">
                <i class="ui-facebook"></i>
              </a>
              <a class="social social-twitter" href="#" target="_blank" aria-label="twitter">
                <i class="ui-twitter"></i>
              </a>
              <a class="social social-google-plus" href="#" target="_blank" aria-label="google">
                <i class="ui-google"></i>
              </a>
              <a class="social social-youtube" href="#" target="_blank" aria-label="youtube">
                <i class="ui-youtube"></i>
              </a>
              <a class="social social-instagram" href="#" target="_blank" aria-label="instagram">
                <i class="ui-instagram"></i>
              </a>
            </div>
          </div>

        </div>
      </div>
    </div> <!-- end top bar -->        

    <!-- Navigation -->
    <header class="nav">

      <div class="nav__holder">
        <div class="container relative">
          <div class="flex-parent">

            <!-- Side Menu Button -->
            <button class="nav-icon-toggle" id="nav-icon-toggle" aria-label="Open side menu">
              <span class="nav-icon-toggle__box">
                <span class="nav-icon-toggle__inner"></span>
              </span>
            </button> 

            <!-- Logo -->
            <a href="{{ url('/') }}" class="logo">
              <img class="logo__img" src="{{ asset('images/logo-ICWEA-1.png') }}" alt="logo">
            </a>

            <!-- Nav-wrap -->
            <nav class="flex-child nav__wrap d-none d-lg-block">              
              <ul class="nav__menu">

                <li class="nav__dropdown active">
                  <a href="{{ url('/') }}">Home</a>
                </li>

                <li class="nav__dropdown">
                  <a href="{{ url('news') }}">News Feed </a>
                </li>

                <li class="nav__dropdown">
                  <a href="{{ url('blog') }}">Blog</a>
                </li>                

                <li class="nav__dropdown">
                    <a href="{{ url('discussion') }}">Discussion Forum</a>
                  </li>

                  <li class="nav__dropdown">
                      <a href="{{ url('publications') }}">Publications</a>
                    </li>
              </ul> <!-- end menu -->
            </nav> <!-- end nav-wrap -->

            <!-- Nav Right -->
            <div class="nav__right">

              <!-- Search -->
              <div class="nav__right-item nav__search">
                <a href="#" class="nav__search-trigger" id="nav__search-trigger">
                  <i class="ui-search nav__search-trigger-icon"></i>
                </a>
                <div class="nav__search-box" id="nav__search-box">
                  <form class="nav__search-form" action="{{ url('search') }}" method="POST">
                     @csrf
                    <input type="text" placeholder="Search an article" name="search_key" class="nav__search-input">
                    <button type="submit" class="search-button btn btn-lg btn-color btn-button">
                      <i class="ui-search nav__search-icon"></i>
                    </button>
                  </form>
                </div>                
              </div>             

            </div> <!-- end nav right -->            
        
          </div> <!-- end flex-parent -->
        </div> <!-- end container -->

      </div>
    </header> <!-- end navigation -->
  
     @yield('content')
    <!-- Footer -->
    <footer class="footer footer--dark">
      <div class="container">
        <div class="footer__widgets">
          <div class="row">

            <div class="col-lg-3 col-md-6">
              <aside class="widget widget-logo">
                <a href="{{ url('/') }}">
                  <img src="{{ asset('images/logo-ICWEA-1.png') }}" srcset="" class="logo__img" alt="">
                </a>
                <p class="copyright">
                  <a href="https://creativecommons.org/licenses/by/4.0">Except where otherwise noted, content on this site is licensed under a Creative Commons Attribution 4.0 International license. </a>
                 <div class="row">
                   <div class="col-md-3">
                      <img src="{{ asset('images/commons_logo.png') }}" style="height:43px;width:43px;" srcset="" class="logo__img" alt="">
                   </div>
                   <div class="col-md-3" style="width:0px !important;margin-left:0px;">
                  <img src="{{ asset('images/cc_icon_white_x2.png') }}" style="height:43px;width:43px;" srcset="" class="logo__img" alt="">
                   </div>
                 </div>
                 
                </p>
               
              </aside>
            </div>

            <div class="col-lg-2 col-md-6">
              <aside class="widget widget_nav_menu">
                <h4 class="widget-title">Useful Links</h4>
                <ul>
                  <li><a href="{{ url('blog') }}">Blog</a></li>
                  <li><a href="{{ url('news') }}">News</a></li>
                </ul>
              </aside>
            </div>  
   
            <?php $popular_blogs=\App\Helpers\AppHelper::instance()->popular_blogs(); 
   
            ?>
            <div class="col-lg-4 col-md-6">
              <aside class="widget widget-popular-posts">
                <h4 class="widget-title">Popular Blogs</h4>
                <ul class="post-list-small">
                  @foreach ($popular_blogs as $item)
                      
                  <li class="post-list-small__item">
                    <article class="post-list-small__entry clearfix">
                      <div class="post-list-small__img-holder">
                        <div class="thumb-container thumb-100">
                            @php
                            $image_url = str_replace(' ', '%20', $item->attachment);
                        @endphp
                          <a href="{{ url('blog', [$item->slug]) }}">
                            <img data-src="{{ asset('uploads/blog/'.$image_url) }}" src="img/empty.png" alt="" class="post-list-small__img--rounded lazyload">
                          </a>
                        </div>
                      </div>
                      <div class="post-list-small__body">
                        <h3 class="post-list-small__entry-title">
                          <a href="{{ url('blog', [$item->slug]) }}">{{ $item->title }}</a>
                        </h3>
                        <ul class="entry__meta">
                          <li class="entry__meta-author">
                            <span>by</span>
                            <a href="#">{{ $item->surname." ".$item->othername }}</a>
                          </li>
                          <li class="entry__meta-date">
                           {{ $item->created_at }}
                          </li>
                        </ul>
                      </div>                  
                    </article>
                  </li>
                  
                  @endforeach
                 
                </ul>
              </aside>              
            </div>

            <div class="col-lg-3 col-md-6">
             
          @include('layouts.social_media')
            </div>

          </div>
        </div>    
      </div> <!-- end container -->
    </footer> <!-- end footer -->

    <div id="back-to-top">
      <a href="#top" aria-label="Go to top"><i class="ui-arrow-up"></i></a>
    </div>

  </main> <!-- end main-wrapper -->

  
  <!-- jQuery Scripts -->
  <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
  <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('frontend/js/easing.min.js') }}"></script>
  <script src="{{ asset('frontend/js/owl-carousel.min.js') }}"></script>
  <script src="{{ asset('frontend/js/flickity.pkgd.min.js') }}"></script>
  <script src="{{ asset('frontend/js/twitterFetcher_min.js') }}"></script>
  <script src="{{ asset('frontend/js/jquery.newsTicker.min.js') }}"></script>  
  <script src="{{ asset('frontend/js/modernizr.min.js') }}"></script>
  <script src="{{ asset('frontend/js/scripts.js') }}"></script>
  <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
  <script src="{{ asset('js/typeahead.min.js') }}"></script>
  <script src="{{ asset('js/share.js') }}"></script>
  
  <script src="{{ asset('js/frontend.js') }}"></script>
   <script>
            CKEDITOR.replace('description');
            
   </script>
   
</body>
</html>