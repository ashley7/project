@extends('frontend/layout')
@section('content')
  <!-- Breadcrumbs -->
  <div class="container">
        <ul class="breadcrumbs">
          <li class="breadcrumbs__item">
            <a href="index.html" class="breadcrumbs__url">Home</a>
          </li>
          <li class="breadcrumbs__item">
            <a href="{{ url('discussion') }}" class="breadcrumbs__url">Discussion</a>
          </li>
          <li class="breadcrumbs__item breadcrumbs__item--current">
            Details
          </li>
        </ul>
      </div>   


      <?php $views_count=\App\Helpers\AppHelper::instance()->view_count($discussion->id,'discussion'); 
   
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
                      {{-- <a href="#" class="entry__meta-category entry__meta-category--label entry__meta-category--green">Lifestyle</a> --}}
                      <h1 class="single-post__entry-title">
                        {!! $discussion->topic !!}
                      </h1>
      
                      <div class="entry__meta-holder">
                        <ul class="entry__meta">
                          <li class="entry__meta-author">
                            <span>by</span>
                            <a href="#">{{ $discussion->user->surname." ".$discussion->user->othername }}</a>
                          </li>
                          <li class="entry__meta-date">
                              @php
                              $exdate = explode(",", $discussion->created_at->format('d M Y, G:i'));
                    $time = (strlen($exdate[1]<=4))? $exdate[0]." &nbsp;&nbsp;".$exdate[1] : $discussion->created_at->format('d M Y, G:i');
                        @endphp
                        {{ $time }}
                          </li>
                        </ul>
      
                        <ul class="entry__meta">
                          <li class="entry__meta-views">
                            <i class="ui-eye"></i>
                            <span>{{ $views_count->total_views }} Views</span>
                          </li>
                          <li class="entry__meta-comments">
                            <a href="#">
                              <i class="ui-chat-empty"></i>{{ $comment_count }} Comments
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div> <!-- end entry header -->
      
      
                    <div class="entry__article-wrap">
            <p>{!! $discussion->description !!}</p>
                         
                    </div> <!-- end entry article wrap -->
                    
      
      
                               
      
                  </article> <!-- end standard post -->
      
                  <!-- Comments -->
                  <div class="entry-comments">
                    <div class="title-wrap title-wrap--line">
                      <h3 class="section-title">{{ $comment_count }}  comments</h3>
                    </div>
                    <?php $parent_comments=\App\Helpers\AppHelper::instance()->parent_comments($discussion->id);  
                    ?>

                          <!-- Comment Form --> 

                        
                  <div id="respond" class="comment-respond">
                      @if (Route::has('login'))
                      @auth 
                      <form  method="POST" action="#">
                        <input type="hidden"  name="discussion_id" id="discussion_id" value="{{  $discussion->id }}">
                        <p class="comment-form-comment">
                          <label for="comment">Comment</label>
                          <textarea id="main_comment" name="main_comment" rows="5" required="required"></textarea>
                        </p>     
                        <p class="">
                        
                          <button type="button" style="margin-right: 651px;" class="btn btn-sm btn-color btn-button main_comment-btn">
                              {{ __('Post Comment') }}
                          </button>
                        </p>
                        
                      </form>
                      <br>
                    <p>  <span style="color:#F59B3A" id="success_message">
                        </span></p>
                        @else
                           <a href=""> Login/Register to leave a comment</a>
                           
                        @endauth
                        @endif
                    </div> <!-- end comment form -->
                    <br>
                  
                    <ul class="comment-list">
                    
                      @foreach ($parent_comments as $item)
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
                            {{-- <a href="#" class="comment-reply">Reply</a>
                            <input type="text" class="form-control" id="comment-{{$item->id}}" placeholder="enter reply here"> --}}
                          </div>
                        </div>

  
                        <?php $child_comments=\App\Helpers\AppHelper::instance()->child_comments($item->id);  
                        ?>
                        <ul class="children">
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
                        </ul>
      
                      </li> <!-- end 1-2 comment -->
                   
                      @endforeach
                      <div class="paginate_custom">
                          {{ $parent_comments->links() }}
                      </div>
      
                    </ul>         
                  </div> <!-- end comments -->
               
      
                </div> <!-- end content box -->
              </div> <!-- end post content -->
              
              <!-- Sidebar -->
              <aside class="col-lg-4 sidebar sidebar--right">
      
                <!-- Widget Popular Posts -->
                <aside class="widget widget-popular-posts">
                  <h4 class="widget-title">Latest discussions</h4>
                  <ul class="post-list-small">
                    @foreach ($highly_related_discussion as $item)
                    <li class="post-list-small__item">
                      <article class="post-list-small__entry clearfix">

                        <div class="post-list-small__body">
                          <h3 class="post-list-small__entry-title">
                            <a href="{{ url('discussion', [$item->slug]) }}">{{ $item->topic }}</a>
                          </h3>
                          <ul class="entry__meta">
                            <li class="entry__meta-author">
                              <span>by</span>
                              <a href="#">{{ $item->surname." ".$item->othername}}</a>
                            </li>
                            <li class="entry__meta-date">
                             
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