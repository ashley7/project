@extends('frontend.layout')
@section('content')


  <!-- Breadcrumbs -->
  <div class="container">
      <ul class="breadcrumbs">
        <li class="breadcrumbs__item">
          <a href="{{ url('/') }}" class="breadcrumbs__url">Home</a>
        </li>
        <li class="breadcrumbs__item">
            <a href="#" class="breadcrumbs__url">News</a>
          </li>
          <li class="breadcrumbs__item">
              <a href="#" class="breadcrumbs__url">Latest News</a>
            </li>
      </ul>
    </div>
    

    <div class="main-container container" id="main-container">         

      <!-- Content -->
      <div class="row">

        <!-- Posts -->
        <div class="col-lg-8 blog__content mb-72">
          <h1 class="page-title">Latest News</h1>

          <div class="row card-row">
   @foreach ($news as $item)
   <div class="col-md-6">
      <article class="entry card">
        <div class="entry__img-holder card__img-holder">
          <a href="{{ url('news', [$item->slug]) }}">
            <div class="thumb-container thumb-70">
                @php
                  $image_url = str_replace(' ', '%20', $item->attachment);
              @endphp
              <img data-src="{{ asset('uploads/news/'.$image_url) }}" src="img/empty.png" class="entry__img lazyload" alt="" />
            </div>
          </a>
          <a href="#" class="entry__meta-category entry__meta-category--label entry__meta-category--align-in-corner entry__meta-category--red">{{ $item->category->name }}</a>
        </div>

        <div class="entry__body card__body">
          <div class="entry__header">
            
            <h2 class="entry__title">
              <a href="{{ url('news', [$item->slug]) }}"> {{ $item->title }}</a>
            </h2>
            <ul class="entry__meta">
             
              <li class="entry__meta-date">
                  @php
                            $exdate = explode(",", $item->created_at->format('d M Y, G:i'));
                  $time = (strlen($exdate[1]<=4))? $exdate[0]." &nbsp;&nbsp;".$exdate[1] : $item->created_at->format('d M Y, G:i');
                      @endphp
                      {{ $time }}
              </li>
            </ul>
          </div>
          <div class="entry__excerpt">
            <p>{!! str_limit( $item->description, $limit = 150, $end = '...') !!}</p>
          </div>
        </div>
      </article>
    </div>
      
   @endforeach
   <div class="paginate_custom">
      {{ $news->links() }}
  </div>
       
  </div>
          {{-- @include('vendor.pagination.default') --}}
         
          <!-- Pagination -->
          {{-- <nav class="pagination">
            <span class="pagination__page pagination__page--current">1</span>
            <a href="#" class="pagination__page">2</a>
            <a href="#" class="pagination__page">3</a>
            <a href="#" class="pagination__page">4</a>
            <a href="#" class="pagination__page pagination__icon pagination__page--next"><i class="ui-arrow-right"></i></a>
          </nav> --}}
        </div> <!-- end posts -->

        <!-- Sidebar -->
        <aside class="col-lg-4 sidebar sidebar--right">

          <!-- Widget Popular Posts -->
          <aside class="widget widget-popular-posts">
            <h4 class="widget-title">Highly Viewed</h4>
            <ul class="post-list-small">
              @foreach ($popular_viewed as $item)
              <li class="post-list-small__item">
                <article class="post-list-small__entry clearfix">
                  <div class="post-list-small__img-holder">
                    <div class="thumb-container thumb-100">
                      <a href="{{ url('news', [$item->slug]) }}">
                          @php
                          $image_url = str_replace(' ', '%20', $item->attachment);
                      @endphp
                      <img data-src="{{ asset('uploads/news/'.$image_url) }}" src="img/empty.png" class="lazyload" alt="" />
                      </a>
                    </div>
                  </div>
                  <div class="post-list-small__body">
                    <h3 class="post-list-small__entry-title">
                      <a href="{{ url('news', [$item->slug]) }}">{{ $item->title }}</a>
                    </h3>
                    <ul class="entry__meta">
                      {{-- <li class="entry__meta-author">
                        <span>by</span>
                        <a href="#"> {{ $item->user->surname }}</a>
                      </li> --}}
                      <li class="entry__meta-date">
                       
                   
                    {{ $item->created_at }}
                      </li>
                    </ul>
                  </div>                  
                </article>
              </li>    
              @endforeach
            </ul>           
          </aside> <!-- end widget popular posts -->

          <!-- Widget Newsletter -->
          @include('frontend.subscribe')
          <!-- Widget Socials -->
          @include('layouts.social_media')
        </aside> <!-- end sidebar -->
  
      </div> <!-- end content -->
    </div> <!-- end main container -->

    
@endsection