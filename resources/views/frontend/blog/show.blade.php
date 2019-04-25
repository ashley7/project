@extends('frontend/layout')
@section('content')
  <!-- Breadcrumbs -->
  <div class="container">
        <ul class="breadcrumbs">
          <li class="breadcrumbs__item">
            <a href="{{ url('/') }}" class="breadcrumbs__url">Home</a>
          </li>
          <li class="breadcrumbs__item">
            <a href="{{ url('blog') }}" class="breadcrumbs__url">Blog</a>
          </li>
          <li class="breadcrumbs__item breadcrumbs__item--current">
             Blog
          </li>
        </ul>
      </div>   

      <?php $views_count=\App\Helpers\AppHelper::instance()->view_count($blog->id,'blog'); 
   
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
                      <a href="categories.html" class="entry__meta-category entry__meta-category--label entry__meta-category--green">Lifestyle</a>
                      <h1 class="single-post__entry-title">
                       {{ $blog->title }}
                      </h1>
      
                      <div class="entry__meta-holder">
                        <ul class="entry__meta">
                          <li class="entry__meta-author">
                            <span>by</span>
                            <a href="#">{{ $blog->user->surname." ".$blog->user->othername }}</a>
                          </li>
                          <li class="entry__meta-date">
                              @php
                              $exdate = explode(",", $blog->created_at->format('d M Y, G:i'));
                    $time = (strlen($exdate[1]<=4))? $exdate[0]." &nbsp;&nbsp;".$exdate[1] : $blog->created_at->format('d M Y, G:i');
                        @endphp
                        {{ $time }}
                          </li>
                        </ul>
      
                        <ul class="entry__meta">
                         
                           
                              <li class="entry__meta-views">
                                  <i class="ui-eye"></i>
                                  <span>{{ $views_count->total_views }}</span>
                                </li>

                              <li class="entry__meta-comments">
                                  <a href="#">
                                    <i class="ui-chat-empty"></i>{{ $comment_count }} 
                                  </a>
                                </li>
                        </ul>
                      </div>
                    </div> <!-- end entry header -->
      
                    <div class="entry__img-holder">
                        @php
                  $image_url = str_replace(' ', '%20', $blog->attachment);
              @endphp
                      <img src="{{ asset('uploads/blog/'.$image_url) }}" alt="" class="entry__img">
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
                      
                        <!-- tags -->
                        <div class="entry__tags">
                          <i class="ui-tags"></i>
                          <span class="entry__tags-label">Tags:</span>
                          <a href="#" rel="tag">mobile</a><a href="#" rel="tag">gadgets</a><a href="#" rel="tag">satelite</a>
                        </div> <!-- end tags -->
      
                      </div> <!-- end entry article -->
                    </div> <!-- end entry article wrap -->
                    
      
       
      
                  </article> <!-- end standard post -->
      
                   <!-- Comments -->
                   <div class="entry-comments">
                      {{-- <div class="title-wrap title-wrap--line"> --}}
                        <span>{!! $blog->description !!} </span>
                      {{-- </div> --}}
                      <?php 
                      // $comments=\App\Helpers\AppHelper::instance()->blog_comments($blog->id);  
                      ?>
                    
                      <ul class="comment-list">
                      
                        {{-- @foreach ($comments as $item)
                        <li class="comment">  
                          <div class="comment-body">
                            <div class="comment-avatar">
                              <img alt="" src="img/content/single/comment_1.jpg">
                            </div>
                            <div class="comment-text">
                              <h6 class="comment-author"> {{ $item->surname." ".$item->othername }}</h6>
                              <div class="comment-metadata">
                                <a href="#" class="comment-date"> {{ $item->created_at }}</a>
                              </div>                      
                              <p>{!! $item->description !!}</p>
                              {{-- <a href="#" class="comment-reply">Reply</a> --}}
                            {{-- </div>
                          </div> --}}
  
    
                          <?php
                          //  $child_comments=\App\Helpers\AppHelper::instance()->child_comments($item->id);  
                          ?>
                          {{-- <ul class="children">
                            @foreach ($child_comments as $item)
                            <li class="comment">
                              <div class="comment-body">
                                <div class="comment-avatar">
                                  <img alt="" src="img/content/single/comment_2.jpg">
                                </div>
                                <div class="comment-text">
                                  <h6 class="comment-author">{{ $item->surname." ".$item->othername }}</h6>
                                  <div class="comment-metadata">
                                    <a href="#" class="comment-date">{{ $item->created_at }}</a>  
                                  </div>                      
                                  <p>{!! $item->description !!}</p>
                                  <a href="#" class="comment-reply">Reply</a>
                                </div>
                              </div>
                            </li> <!-- end reply comment -->
                             
                                
                            @endforeach
                          </ul> --}}
        
                        {{-- </li>  --}}
                        <!-- end 1-2 comment -->
                
                        {{-- @endforeach --}}
        
                      </ul>         
                    </div> <!-- end comments -->
        
                    <!-- Comment Form --> 
                    {{-- <div id="respond" class="comment-respond">
                      <div class="title-wrap">
                        <h5 class="comment-respond__title section-title">Leave a Reply</h5>
                      </div>
                      <form id="form" class="comment-form" method="post" action="{{ url('blog-comment') }}">
                        @csrf
                        <input type="hidden"  name="blog_id" value="{{  $blog->id }}">
                        <p class="comment-form-comment">
                          <label for="comment">Comment</label>
                          <textarea id="comment" name="comment" rows="5" required="required"></textarea>
                        </p> 
                        @if (Route::has('login'))
                        @auth 
                        <div class="row row-20">
                            <div class="col-lg-4">
                              <label for="name">Name: *</label>
                              <input name="name" id="name" value="{{ Auth::user()->surname }}" type="text" required>
                            </div>
                            <div class="col-lg-4">
                              <label for="comment">Email: *</label>
                              <input name="email" id="email" value="{{ Auth::user()->email }}" type="email" required>
                            </div>
                          </div>
                          @endauth
                          @endif
                          
                          
                        <p class="">
                        
                          <button type="submit" style="margin-right: 651px;" class="btn btn-sm btn-color btn-button">
                              {{ __('Post Comment') }}
                          </button>
                        </p>
                        
                      </form>
                    </div>  --}}
                    <!-- end comment form -->


                </div> <!-- end content box -->
              </div> <!-- end post content -->
              
              <!-- Sidebar -->
              <aside class="col-lg-4 sidebar sidebar--right">
      
                <!-- Widget Popular Posts -->
                <aside class="widget widget-popular-posts">
                  <h4 class="widget-title">Popular Blogs</h4>
                  <ul class="post-list-small">
                    @foreach ($popular_blogs as $item)
                    <li class="post-list-small__item">
                      <article class="post-list-small__entry clearfix">
                        <div class="post-list-small__img-holder">
                          <div class="thumb-container thumb-100">
                            <a href="{{ url('blog', [$item->slug]) }}">
                                @php
                  $image_url = str_replace(' ', '%20', $item->attachment);
              @endphp
                      <img data-src="{{ asset('uploads/blog/'.$image_url) }}" alt="" class="post-list-small__img--rounded lazyload" src="img/empty.png">
                            </a>
                          </div>
                        </div>
                        <div class="post-list-small__body">
                          <h3 class="post-list-small__entry-title">
                            <a href="{{ url('blog', [$item->slug]) }}">{{ $item->title }}</a>
                          </h3>
                          <ul class="entry__meta">
                            
                            <li class="entry__meta-date">
                                @php
                                $exdate = explode(",", $blog->created_at->format('d M Y, G:i'));
                      $time = (strlen($exdate[1]<=4))? $exdate[0]." &nbsp;&nbsp;".$exdate[1] : $blog->created_at->format('d M Y, G:i');
                          @endphp
                          {{ $time }}
                            </li>
                          </ul>
                        </div>                  
                      </article>
                    </li> 
                    @endforeach
                  </ul>           
                </aside> <!-- end widget popular posts -->
      
                <!-- Widget Newsletter -->
                <aside class="widget widget_mc4wp_form_widget">
                  <h4 class="widget-title">Subscribe</h4>
                  <p class="newsletter__text">
                    <i class="ui-email newsletter__icon"></i>
                    Subscribe to the site
                  </p>
                  <a href="{{ url('register') }}" class="btn btn-lg btn-color">Sign Up</a>
                </aside> <!-- end widget newsletter -->
      
                <!-- Widget Socials -->
                @include('layouts.social_media')
      
              </aside> <!-- end sidebar -->
            
            </div> <!-- end content -->
          </div> <!-- end main container -->
      



      @endsection