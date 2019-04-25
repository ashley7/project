@extends('frontend.layout')
@section('content')
  <!-- Breadcrumbs -->
  <div class="container">
      <ul class="breadcrumbs">
        <li class="breadcrumbs__item">
          <a href="{{ url('/') }}" class="breadcrumbs__url">Home</a>
        </li>
        <li class="breadcrumbs__item">
          <a href="#" class="breadcrumbs__url">Discussion Forum</a>
        </li>
      </ul>
    </div>
    <div class="main-container container" id="main-container">        

        <!-- Content -->
        <div class="row">
  
          <!-- Posts -->
          <div class="col-lg-8 blog__content mb-72">
            <h3 class="">Discussion Forum</h3>
       
              @foreach ($discussion as $item)
              <article class="card">
                  <div class="entry__body  card__body " style="">
                    <div class="entry__header">
                      <h2 class="entry__title">
                        <a href="{{ url('discussion', [$item->slug]) }}"> {!! $item->topic !!}</a>
                      </h2>
                          
                      <div class="entry__excerpt">
                        <p> {!! str_limit($item->description, $limit = 150, $end = '...') !!}</p>
                      </div>
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

                        <li class="entry__meta-author">
                            @auth
                          
                     @if ($item->user_id==Auth::user()->id)
                      <a href=" {{ url("/discussion/$item->id/edit") }}"> <i class="btn btn-primary fa fa-pencil"></i> Edit </a> 
                      |
                      <a href="{{ route('delete-discussion', $item->id) }}"  onclick="event.preventDefault();document.getElementById('delete-record-{{$item->id}}').submit();"> Delete</a>

                      <form id="delete-record-{{$item->id}}" method="POST" action="{{ route('delete-discussion', $item->id) }}" style="display: none;">
                         @csrf
                          @method('DELETE')
                      </form> 

                      @endif
                   
                   @endauth
                          </li>
                      </ul>
                    </div>    
                    <div class="entry__excerpt">
                        
                        @php
                        $comments_count=\App\Helpers\AppHelper::instance()->discussion_cts_count($item->id);  
                        @endphp 
                      <p>  <i class="ui-chat-empty"></i> {{ $comments_count }} comments</p>
                    </div>
                   
                  </div>
                </article>
              @endforeach
              <div class="paginate_custom">
                  {{ $discussion->links() }}
              </div>
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
                  <h4 class="widget-title">Create New discussion</h4>
                  <p class="newsletter__text">
                    <i class="ui-email newsletter__icon"></i>
                    Press the Button below 
                  </p>
                  <div class="col-md-4">
                      <div>
                        <a href="{{ url('discussion-create') }}" class="btn btn-sm btn-color">
                          <span>Start A discussion</span>
                        </a>
                      </div>             
                    </div>
                    
                </aside> <!-- end widget newsletter -->
                @include('frontend.subscribe')
          </aside> <!-- end sidebar -->
    
        </div> <!-- end content -->
      </div> <!-- end main container -->
  
    
@endsection