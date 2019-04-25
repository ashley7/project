@extends('frontend/layout')
@section('content')
  <!-- Breadcrumbs -->
  <div class="container">
        <ul class="breadcrumbs">
          <li class="breadcrumbs__item">
            <a href="index.html" class="breadcrumbs__url">Home</a>
          </li>
          <li class="breadcrumbs__item">
            <a href="{{ url('news') }}" class="breadcrumbs__url">News</a>
          </li>
          <li class="breadcrumbs__item breadcrumbs__item--current">
           Detail
          </li>
        </ul>
      </div>   

      
      <?php $views_count=\App\Helpers\AppHelper::instance()->view_count($news_post->id,'news'); 
   
      ?>
    <div class="main-container container" id="main-container">

            <!-- Content -->
            <div class="row">
                  
              <!-- post content -->
              <div class="col-lg-8 blog__content mb-72">
                <div class="content-box">           
      
                  <!-- standard post -->
                  <article class="entry mb-0">
                    
                    <div class="single-post__entry-header entry__header">
                      <a href="categories.html" class="entry__meta-category entry__meta-category--label entry__meta-category--green"> {{ $news_post->category->name }}</a>
                      <h1 class="single-post__entry-title">
                       {{ $news_post->title }}
                      </h1>
      
                      <div class="entry__meta-holder">
                        <ul class="entry__meta">
                          <li class="entry__meta-author">
                            <span>by</span>
                            <a href="#">{{ $news_post->user->surname." ".$news_post->user->othername }}</a>
                          </li>
                          <li class="entry__meta-date">
                              @php
                              $exdate = explode(",", $news_post->created_at->format('d M Y, G:i'));
                    $time = (strlen($exdate[1]<=4))? $exdate[0]." &nbsp;&nbsp;".$exdate[1] : $news_post->created_at->format('d M Y, G:i');
                        @endphp
                        {{ $time }}
                          </li>
                        </ul>
      
                        <ul class="entry__meta">
                          <li class="entry__meta-views">
                            <i class="ui-eye"></i>
                            <span>{{  $views_count->total_views }}</span>
                          </li>
                          {{-- <li class="entry__meta-comments">
                            <a href="#">
                              <i class="ui-chat-empty"></i>13
                            </a>
                          </li> --}}
                        </ul>
                      </div>
                    </div> <!-- end entry header -->
      
                    <div class="entry__img-holder">
                        @php
                        $image_url = str_replace(' ', '%20', $news_post->attachment);
                    @endphp
                      <img src="{{ asset('uploads/news/'. $image_url ) }}" src="img/empty.png" alt="" class="entry__img">
                    </div>
      
                    <div class="entry__article-wrap">
      
                      <!-- Share -->
                      <div class="entry__share">
                        <div class="sticky-col">
                          <div class="socials socials--rounded socials--large">
                            <a class="social social-facebook" href="#" title="facebook" target="_blank" aria-label="facebook">
                              <i class="ui-facebook"></i>
                            </a>
                            <a class="social social-twitter" href="#" title="twitter" target="_blank" aria-label="twitter">
                              <i class="ui-twitter"></i>
                            </a>
                            <a class="social social-google-plus" href="#" title="google" target="_blank" aria-label="google">
                              <i class="ui-google"></i>
                            </a>
                            <a class="social social-pinterest" href="#" title="pinterest" target="_blank" aria-label="pinterest">
                              <i class="ui-pinterest"></i>
                            </a>
                          </div>
                        </div>                  
                      </div> <!-- share -->
      
                      <div class="entry__article">
                        {!! $news_post->description !!}
    
                        <!-- tags -->
                        <div class="entry__tags">
                          <i class="ui-tags"></i>
                          <span class="entry__tags-label">Tags:</span>
                          <a href="#" rel="tag">mobile</a><a href="#" rel="tag">gadgets</a><a href="#" rel="tag">satelite</a>
                        </div> <!-- end tags -->
      
                      </div> <!-- end entry article -->
                    </div> <!-- end entry article wrap -->
                    
      
      
                
                    <!-- Related Posts -->
                    <section class="section related-posts mt-40 mb-0">
                      <div class="title-wrap title-wrap--line title-wrap--pr">
                        <h3 class="section-title">Related News Feed</h3>
                      </div>
      
                      <!-- Slider -->
                      <div id="owl-posts-3-items" class="owl-carousel owl-theme owl-carousel--arrows-outside">
                     
                          @php
                          $related_feeds=\App\Helpers\AppHelper::instance()->related_news_feed($news_post->category_id,$news_post->id);  
                          @endphp 
                 @foreach ($related_feeds as $item)
                 @php
                 $image_url = str_replace(' ', '%20', $item->attachment);
             @endphp
                        <article class="entry thumb thumb--size-1">
                        <div class="entry__img-holder thumb__img-holder" style="background-image: url('/uploads/news/{{ $image_url}}');">
                            <div class="bottom-gradient"></div>
                            <div class="thumb-text-holder">   
                              <h2 class="thumb-entry-title">
                                <a href="{{ url('news', [$item->slug]) }}">{!! $item->title !!}</a>
                              </h2>
                            </div>
                            <a href="{{ url('news', [$item->slug]) }}" class="thumb-url"></a>
                          </div>
                        </article>
                        
                       @endforeach
                      </div> <!-- end slider -->
      
                    </section> <!-- end related posts -->            
      
                  </article> <!-- end standard post -->
      
              
                </div> <!-- end content box -->
              </div> <!-- end post content -->
              
              <!-- Sidebar -->
              <aside class="col-lg-4 sidebar sidebar--right">
      
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
          



                <!-- Widget Socials -->
                @include('layouts.social_media')
      
              </aside> <!-- end sidebar -->
            
            </div> <!-- end content -->
          </div> <!-- end main container -->

@endsection