@extends('frontend/layout')
@section('content')
  <!-- Breadcrumbs -->
  <div class="container">
        <ul class="breadcrumbs">
          <li class="breadcrumbs__item">
            <a href="{{ url('/', []) }}" class="breadcrumbs__url">Home</a>
          </li>
          <li class="breadcrumbs__item">
            <a href="{{ url('publications') }}" class="breadcrumbs__url">publications</a>
          </li>
          <li class="breadcrumbs__item breadcrumbs__item--current">
           Detail
          </li>
        </ul>
      </div>   

      
      <?php $views_count=\App\Helpers\AppHelper::instance()->view_count($publication->id,'publication'); 
   
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
                      <a href="categories.html" class="entry__meta-category entry__meta-category--label entry__meta-category--green"> {{ $publication->publication_type }}</a>
                      <h3 class="single-post__entry-title">
                       {{ $publication->title }}
                      </h3>
      
                      <div class="entry__meta-holder">
                        <ul class="entry__meta">
                          <li class="entry__meta-author">
                            <span>by</span>
                            <a href="#">{{ $publication->user->surname." ".$publication->user->othername }}</a>
                          </li>
                          <li class="entry__meta-date">
                              @php
                              $exdate = explode(",", $publication->created_at->format('d M Y, G:i'));
                    $time = (strlen($exdate[1]<=4))? $exdate[0]." &nbsp;&nbsp;".$exdate[1] : $publication->created_at->format('d M Y, G:i');
                        @endphp
                        {{ $time }}
                          </li>
                        </ul>
      
                        <ul class="entry__meta">
                          <li class="entry__meta-views">
                            <i class="ui-eye"></i>
                            <span>{{  $views_count->total_views }} Views</span>
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
                        $image_url = str_replace(' ', '%20', $publication->attachment);
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
                        {!! $publication->description !!}
                    @php
                     $file = str_replace(' ', '%20', $publication->attachment);
                        $url=asset('uploads/publications/'.$file)
                    @endphp
                        <iframe src="http://docs.google.com/gview?url=@php
                           echo $url;
                        @endphp&embedded=true" style="width:600px; height:700px;" frameborder="0"></iframe>
    
      
                      </div> <!-- end entry article -->
                    </div> <!-- end entry article wrap -->
                    
      
      
                
                        
      
                  </article> <!-- end standard post -->
      
              
                </div> <!-- end content box -->
              </div> <!-- end post content -->
              
              <!-- Sidebar -->
              <aside class="col-lg-4 sidebar sidebar--right">
      
                <!-- Widget Popular Posts -->
                <aside class="widget widget-popular-posts">
                  <h4 class="widget-title">Other Related category</h4>
                  <ul class="post-list-small">
                   @foreach ($related as $item)
                       
                    <li class="post-list-small__item">
                      <article class="post-list-small__entry clearfix">
                        
                        <div class="post-list-small__body">
                          <h3 class="post-list-small__entry-title">
                            <a href="{{ url('publications', [$item->slug]) }}">{!! $item->title !!}</a>
                          </h3>
                          <ul class="entry__meta">
                            <li class="entry__meta-author">
                              <span>by</span>
                              <a href="#">{{ $item->user->surname }}</a>
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
                    </li>
                    
                   @endforeach
                  </ul>           
                </aside> <!-- end widget popular posts -->
      



                <!-- Widget Socials -->
                @include('layouts.social_media')
                <!-- end widget socials -->
      
              </aside> <!-- end sidebar -->
            
            </div> <!-- end content -->
          </div> <!-- end main container -->

@endsection