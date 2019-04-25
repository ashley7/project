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
            <h3 class="">Content Search</h3>
       
              @foreach ($search_result as $item)
              <article class="card">
                  <div class="entry__body  card__body " style="">
                    <div class="entry__header">
                      <h2 class="entry__title">
                        <a href="
                        
                        @if ($item->table_name=="blogs")
                        {{ url('blog', [$item->slug]) }} 

                        @elseif($item->table_name=="news_posts")
                          {{ url('news', [$item->slug]) }} 

                          @elseif($item->table_name=="discussions")
                          {{ url('discussion', [$item->slug]) }} 

                          @elseif($item->table_name=="publications")
                          {{ url('publications', [$item->slug]) }} 

                        @endif
                        "> {!! $item->key_word !!}</a>
                      </h2>
                          
                      <div class="entry__excerpt">
                        <p> {!! str_limit($item->description, $limit = 150, $end = '...') !!}</p>
                      </div>
                    </div>    
                   
                   
                  </div>
                </article>
              @endforeach
              {{-- <div class="paginate_custom">
                  {{-- {{ $search_result->links() }} --}}
              {{-- </div> --}}
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
  
          
               <!-- Widget social media -->
               @include('layouts.social_media')
  
          </aside> <!-- end sidebar -->
    
        </div> <!-- end content -->
      </div> <!-- end main container -->
  
    
@endsection