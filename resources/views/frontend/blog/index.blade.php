@extends('frontend.layout')
@section('content')

  <!-- Breadcrumbs -->
  <div class="container">
      <ul class="breadcrumbs">
        <li class="breadcrumbs__item">
          <a href="{{ url('/') }}" class="breadcrumbs__url">Home</a>
        </li>
        <li class="breadcrumbs__item">
          <a href="#" class="breadcrumbs__url">Blogs</a>
        </li>
      </ul>
    </div>

<div class="main-container container" id="main-container">         

        <!-- Content -->
        <div class="row">
  
          <!-- Posts -->
          <div class="col-lg-8 blog__content mb-72">
            <h3 class="page-title">Blog</h3>
       @foreach ($blogs as $item)
            <article class="entry card post-list">

              @php
                  $image_url = str_replace(' ', '%20', $item->attachment);
              @endphp
              <div class="entry__img-holder post-list__img-holder card__img-holder" style="background-image: url(uploads/blog/{{  $image_url }})">
                <a href="{{ url('blog', [$item->slug]) }}" class="thumb-url"></a>
                <img src="img/content/list/list_post_1.jpg" alt="" class="entry__img d-none">
                <a href="categories.html" class="entry__meta-category entry__meta-category--label entry__meta-category--align-in-corner entry__meta-category--blue">{{ $item->category->name }}</a>
              </div>
  
              <div class="entry__body post-list__body card__body">
                <div class="entry__header">
                  <h2 class="entry__title">
                    <a href="{{ url('blog', [$item->slug]) }}">{{ $item->title }}</a>
                  </h2>
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
                <div class="entry__excerpt">
                  <p> {!! str_limit($item->description, $limit = 150, $end = '...')  !!}</p>
                   <p>
                     @auth
                          
                     @if ($item->user_id==Auth::user()->id)
                      <a href=" {{ url("/blog/$item->id/edit") }}"> <i class="btn btn-primary fa fa-pencil"></i> Edit blog</a> 
                      |
                      <a href="{{ route('delete-blog', $item->id) }}"  onclick="event.preventDefault();document.getElementById('delete-record-{{$item->id}}').submit();">Delete Blog</a>

                      <form id="delete-record-{{$item->id}}" method="POST" action="{{ route('delete-blog', $item->id) }}" style="display: none;">
                         @csrf
                          @method('DELETE')
                      </form> 

                      @endif
                   
                   @endauth
                  </p>
                </div>
              </div>
            </article>
  
         
            @endforeach
    <div class="paginate_custom">
        {{ $blogs->links() }}
    </div>
           
  
            {{-- @include('vendor.pagination.default', ['paginator' => $blogs, 'link_limit' => 10]) --}}
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


               <!-- Widget Newsletter -->
               <aside class="widget widget_mc4wp_form_widget">
                  <h4 class="widget-title">Create Blog Post</h4>
                  <p class="newsletter__text">
                    <i class="ui-email newsletter__icon"></i>
                    Press the Button below to publish on the Blog
                  </p>
                  <div class="col-md-4">
                      <div>
                        <a href="{{ url('blog-create') }}" class="btn btn-sm btn-color">
                          <span>Create Blog</span>
                        </a>
                      </div>             
                    </div>
                    
                </aside> <!-- end widget newsletter -->

                @include('frontend.subscribe')
  
            <!-- Widget Popular Posts -->
            <aside class="widget widget-popular-posts">
              <h4 class="widget-title">Highly viewed Blogs</h4>
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
                          <img data-src="{{ asset('uploads/blog/'.$image_url) }}" src="img/empty.png" alt="" class=" lazyload">
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
            </aside> <!-- end widget popular posts -->
  
           
            <!-- Widget Socials -->
            @include('layouts.social_media')
          </aside> <!-- end sidebar -->
    
        </div> <!-- end content -->
      </div> <!-- end main container -->
  
    
@endsection