@extends('frontend/layout')
@section('content')


    <!-- Trending Now -->
    <div class="container">
        <div class="trending-now">
          <span class="trending-now__label">
            <i class="ui-flash"></i>
          Newsflash</span>
          <div class="newsticker">
            <ul class="newsticker__list">
             @foreach ($latest_news as $item)

             <li class="newsticker__item"><a href="{{ url('news', [$item->slug]) }}" class="newsticker__item-url">{!! $item->title !!}</a></li> 
             @endforeach
            </ul>
          </div>
          <div class="newsticker-buttons">
            <button class="newsticker-button newsticker-button--prev" id="newsticker-button--prev" aria-label="next article"><i class="ui-arrow-left"></i></button>
            <button class="newsticker-button newsticker-button--next" id="newsticker-button--next" aria-label="previous article"><i class="ui-arrow-right"></i></button>
          </div>
        </div>
      </div>
      
  
      <!-- Featured Posts Grid -->      
      <section class="featured-posts-grid">
        <div class="container">
          <div class="row row-8">
  
            <div class="col-lg-6">
  
              <!-- Small post -->

               @foreach ($featured_news as $item)
              <div class="featured-posts-grid__item featured-posts-grid__item--sm">
                  @php
                  $image_url = str_replace(' ', '%20', $item->attachment);
              @endphp
                <article class="entry card post-list featured-posts-grid__entry">
                <div class="entry__img-holder post-list__img-holder card__img-holder" style="background-image: url(uploads/news/{{ $image_url}})">
                    <a href="{{ url('news', [$item->slug]) }}" class="thumb-url"></a>
                    <img src="{{ asset('uploads/news/'.$image_url) }}" alt="" class="entry__img d-none">
                    <a href="categories.html" class="entry__meta-category entry__meta-category--label entry__meta-category--align-in-corner entry__meta-category--red">{{ $item->category->name }}</a>
                  </div>
  
                  <div class="entry__body post-list__body card__body">  
                    <h2 class="entry__title">
                      <a href="{{ url('news', [$item->slug]) }}">{{ $item->title }}</a>
                    </h2>
                    <ul class="entry__meta">
                      <li class="entry__meta-author">
                        <span>by</span>
                        <a href="#"> {{ $item->user->surname." ".$item->user->othername }}</a>
                      </li>
                      <li class="entry__meta-date">
                          @php
                          $exdate = explode(",", $item->created_at->format('d M Y, G:i'));
                $time = (strlen($exdate[1]<=4))? $exdate[0]." &nbsp;&nbsp;".$exdate[1] : $item->created_at->format('d M Y, G:i');
                    @endphp
                    {{ $time }}
                      </li>              
                    </ul>
                  </div>
                </article>
              </div> <!-- end post -->
                   
              @endforeach
  
            </div> <!-- end col -->
  
            <div class="col-lg-6">
  
              <!-- Large post -->
              <div class="featured-posts-grid__item featured-posts-grid__item--lg">
                <article class="entry card featured-posts-grid__entry">
                  <div class="entry__img-holder card__img-holder">
                    <a href="{{ url('blog', [$featured_blog->slug]) }}">
                        @php
                        $image_url = str_replace(' ', '%20', $featured_blog->attachment);
                    @endphp
                      <img src="{{ asset('uploads/blog/'.$image_url) }}" alt="" class="entry__img">
                    </a>
                    <a href="categories.html" class="entry__meta-category entry__meta-category--label entry__meta-category--align-in-corner entry__meta-category--green"> {{ $featured_blog->category->name }}</a>
                  </div>
  
                  <div class="entry__body card__body">   
                    <h2 class="entry__title">
                      <a href="{{ url('blog', [$featured_blog->slug]) }}"> {{ $featured_blog->title }}</a>
                    </h2>
                    <ul class="entry__meta">
                      <li class="entry__meta-author">
                        <span>by</span>
                        <a href="#">{{ $featured_blog->user->surname." ".$featured_blog->user->othername }}</a>
                      </li>
                      <li class="entry__meta-date">
                          @php
                          $exdate = explode(",", $featured_blog->created_at->format('d M Y, G:i'));
                $time = (strlen($exdate[1]<=4))? $exdate[0]." &nbsp;&nbsp;".$exdate[1] : $featured_blog->created_at->format('d M Y, G:i');
                    @endphp
                    {{ $time }}
                      </li>              
                    </ul>
                  </div>
                </article>
              </div> <!-- end large post -->


            </div>          
  
          </div>
        </div>
      </section> <!-- end featured posts grid -->
  
      <div class="main-container container pt-24" id="main-container">         
  
        <!-- Content -->
        <div class="row">
  
          <!-- Posts -->
          <div class="col-lg-8 blog__content">
            
            <!-- Latest News -->
            <section class="section tab-post mb-16">
              <div class="title-wrap title-wrap--line">
                <h3 class="section-title">Latest News</h3>
  
                <div class="tabs tab-post__tabs"> 
                  <ul class="tabs__list">
                    <li class="tabs__item tabs__item--active">
                      <a href="{{ url('news') }}" class="tabs__trigger">All</a>
                    </li>
                    @foreach ($news_categories as $item)
                    <li class="tabs__item">
                        <a href="{{ url('news-category', [$item->id]) }}" class="tabs__trigger">{{ $item->name }}</a>
                      </li>
                    @endforeach
                  
                  </ul> <!-- end tabs -->
                </div>
              </div>
  
              <!-- tab content -->
              <div class="tabs__content tabs__content-trigger tab-post__tabs-content">
                
                <div class="tabs__content-pane tabs__content-pane--active" id="tab-all">
                  <div class="row card-row">
                    @foreach ($latest_news as $item)
                        
                    <div class="col-md-6">
                      <article class="entry card">
                        <div class="entry__img-holder card__img-holder">
                          <a href="{{ url('news', [$item->slug]) }}">
                            <div class="thumb-container thumb-70">
                                @php
                             $image_url = str_replace(' ', '%20', $item->attachment);
                          @endphp
                              <img data-src="{{ asset('uploads/news/'.$image_url) }}" src="{{ asset('frontend/img/empty.png') }}" class="entry__img lazyload" alt="" />
                            </div>
                          </a>
                          <a href="#" class="entry__meta-category entry__meta-category--label entry__meta-category--align-in-corner entry__meta-category--violet">{{ $item->category->name }}</a>
                        </div>
  
                        <div class="entry__body card__body">
                          <div class="entry__header">
                            
                            <h2 class="entry__title">
                              <a href="{{ url('news', [$item->slug]) }}">{{ $item->title }}</a>
                            </h2>
                            <ul class="entry__meta">
                                <li class="entry__meta-author">
                                    <span>by</span>
                                    <a href="#">{{ $item->user->surname." ".$item->user->othername }}</a>
                                  </li>
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
                            <p>{!!  str_limit( $item->description, $limit = 150, $end = '...') !!}</p>
                          </div>
                        </div>
                      </article>
                    </div>
                    
                    @endforeach

                  </div>
                </div> <!-- end pane 1 -->
  
       
          
              </div> <!-- end tab content -->            
            </section> <!-- end latest news -->
  
          </div> <!-- end posts -->
  
          <!-- Sidebar -->
          <aside class="col-lg-4 sidebar sidebar--right">
  
            <!-- Widget Popular Posts -->
            <aside class="widget widget-popular-posts">
                <h4 class="widget-title"> {{ $page->title }}</h4>
                <ul class="post-list-small">
                    <p>{!!  str_limit( $page->description, $limit = 300, $end = '...') !!}</p>
                 
                </ul>           
              </aside> <!-- end widget popular posts -->

              @include('frontend.subscribe')

              <aside class="widget widget-popular-posts">
                  <h4 class="widget-title">Highly viewed discussions</h4>
                  <ul class="post-list-small">
                    @foreach ($highly_related_discussion as $item)
    
                    <li class="post-list-small__item">
                      <article class="post-list-small__entry clearfix">
                        
                        <div class="post-list-small__body">
                          <h3 class="post-list-small__entry-title">
                            <a href="{{ url('discussion', [$item->slug]) }}">{!! $item->topic !!}</a>
                          </h3>
                          <ul class="entry__meta">
                            
                            <li class="entry__meta-date">
                                 By {{ $item->surname." ".$item->othername }}
                                {{-- @php
                                $exdate = explode(",", $item->created_at->format('d M Y, G:i'));
                      $time = (strlen($exdate[1]<=4))? $exdate[0]." &nbsp;&nbsp;".$exdate[1] : $item->created_at->format('d M Y, G:i');
                          @endphp
                          {{ $time }} --}}
                            </li>
                          </ul>
                        </div>   
                                       
                      </article>
                    </li>
                    @endforeach
                  </ul>           
                </aside> <!-- end widget popular posts -->
              
  
        
            <!-- Widget Socials -->
            @include('layouts.social_media')
  
          </aside> <!-- end sidebar -->
    
        </div> <!-- end content -->
  
        <!-- Ad Banner 728 -->
        <div class="text-center pb-48">
          <a href="#">
            <img src="img/content/placeholder_728.jpg" alt="">
          </a>
        </div>
  
     
  
    
  
  
      </div> <!-- end main container -->
  
    
@endsection