@extends('frontend/layout')
@section('content')

<style>
 #imagePreview {

}
</style>
 <style type="text/css">
  .bs-example{
    font-family: sans-serif;
    position: relative;
    margin: 50px;
  }
  .typeahead, .tt-query, .tt-hint {
    border: 2px solid #CCCCCC;
    border-radius: 8px;
    font-size: 24px;
    height: 30px;
    line-height: 30px;
    outline: medium none;
    padding: 8px 12px;
    width: 396px;
  }
  .typeahead {
    /* background-color: #FFFFFF; */
  }
  .typeahead:focus {
    /* border: 2px solid #0097CF; */
  }
  .tt-query {
    /* box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset; */
  }
  .tt-hint {
    /* color: #999999; */
  }
  .tt-dropdown-menu {
    background-color: #FFFFFF;
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    margin-top: 12px;
    padding: 8px 0;
    width: 422px;
  }
  .tt-suggestion {
    font-size: 24px;
    line-height: 24px;
    padding: 3px 20px;
  }
  .tt-suggestion.tt-is-under-cursor {
    background-color: #0097CF;
    color: #FFFFFF;
  }
  .tt-suggestion p {
    margin: 0;
  }
  </style>




  <!-- Breadcrumbs -->
  <div class="container">
        <ul class="breadcrumbs">
          <li class="breadcrumbs__item">
            <a href="index.html" class="breadcrumbs__url">Home</a>
          </li>
          <li class="breadcrumbs__item">
            <a href="index.html" class="breadcrumbs__url">Blog</a>
          </li>
          <li class="breadcrumbs__item breadcrumbs__item--current">
            update Blog
          </li>
        </ul>
      </div>   
      <div class="main-container container" id="main-container">                 
        <!-- post content -->
        <div class="blog__content mb-72">
          <div class="container text-center">
            
            <div class="row justify-content-center mt-70">
                  
              <div class="col-md-11">
                    <div class="card pt-0">
                        
                  <br><br>

                    <form method="POST" action="{{ route('update-blog',[$blog->id]) }}" enctype="multipart/form-data" autocomplete="off"> 
                            @csrf
                            <input type="hidden" value="put" name="_method">
                            <div class="col-md-9">

                                    <input type="text" placeholder="Enter Blog title(* Required field)" value="{{ $blog->title }}" name="title">

                                    @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color:red;margin:bottom:15px;    margin-right: 598px;">{{ $errors->first('title') }}</strong>
                                    </span>
                                     @endif
                                     <select name="category">
                                        <option value="">select category</option>
                                         @foreach ($categories as $item)
                                           <option @if ($blog->category_id==$item->id)
                                                 selected
                                           @endif value="{{ $item->id }}">{{ $item->name }}</option>     
                                         @endforeach
                                      </select>
    
                                     @if ($errors->has('category'))
                                     <span class="invalid-feedback" role="alert">
                                         <strong style="color:red;margin:bottom:15px;    margin-right: 598px;">{{ $errors->first('category') }}</strong>
                                     </span>
                                      @endif

                                     <div class="form-group">
                                        <label for="content"> description</label>
                                        <textarea class="form-control" id="description"  name="description" rows="9">{{ $blog->description }}</textarea>
                                    </div>
                                    

                                    @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color:red;margin:bottom:15px;     margin-right: 556px;">{{ $errors->first('description') }}</strong>
                                    </span>
                                    <br>
                                     @endif
                                     
                                      
                                    <label for="input-label">attach image file below</label>
                                    <div class="entry__body post-list__body card__body">
                                        @php
                  $image_url = str_replace(' ', '%20', $blog->attachment);
              @endphp
                                    <ul class="entry__meta">
                                        <li class="entry__meta-author">
                                        <div id="PreviewPicture" style="width: 180px;
                                        height: 180px;
                                        background-position: center center;
                                        background-size: cover;
                                        -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
                                        display: inline-block;">
                                        <img id="old_image" src="{{ asset('uploads/blog/'.$image_url) }}" alt="">
                                        </div>
                                        <br>
                                        <br>
                                        <input name="image" type="file" onchange="ImagePreview()" id="FileUpload" placeholder="attach photo"> 
                                    </li>
                                    </ul>
                                    </div>
                                    @if ($errors->has('image'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color:red;margin:bottom:15px;     margin-right: 430px;">{{ $errors->first('image') }}</strong>
                                    </span>
                                    <br>
                                     @endif

                                    <button type="submit" style="margin-right: 651px;" class="btn btn-sm btn-color btn-button">
                                            {{ __('Update Blog') }}
                                        </button>
                            </div>
                        </form>
                        
                  <br><br>
              </div>
               </div>     
            
            </div> <!-- end row -->
  
          </div> <!-- end container -->
        </div> <!-- end post content -->
      </div> <!-- end main container -->
   
      <script src="{{ asset('backend/vendors/jquery/dist/jquery.min.js') }}"></script>

      <script>
        //   $(document).ready(function(){
        // $('input.typeahead').typeahead({
        //     name: 'typeahead',
        //     // remote:'search.php?key=%QUERY',
        //     remote:'{{url('search-tags/%QUERY')}}'
        //     // url : '{{URL::to('search')}}',
        //     // data:{'search':$value},
        //     limit : 10
        // });
        //   });
   

        $('#keyword').typeahead(null, {
            name: 'query',
            displayKey: 'value',
            source: autosuggest.ttAdapter(),
            templates: {
                empty: [
                    '<div class="empty-message">',
                    'Unable to find any suggestion for your query',
                    '</div>'
                ].join('\n'),
                suggestion: Handlebars.compile('<div>@{{value}}<br><span>@{{data}}</div>')
            }
        }).on('typeahead:selected', function (obj, datum) {
            window.location.href = datum.href;
        });



       </script>

 <script>

   function ImagePreview() { 
 var PreviewIMG = document.getElementById('PreviewPicture'); 
 var UploadFile    =  document.getElementById('FileUpload').files[0]; 
 var ReaderObj  =  new FileReader(); 
 ReaderObj.onloadend = function () { 
   $('#old_image').hide();
    PreviewIMG.style.backgroundImage  = "url("+ ReaderObj.result+")";
  } 
 if (UploadFile) { 
    ReaderObj.readAsDataURL(UploadFile);
  } else { 
     PreviewIMG.style.backgroundImage  = "";
  } 
}
$(function() {
  var PreviewIMG = document.getElementById('PreviewPicture'); 
  PreviewIMG.style.backgroundImage  = "url(images/placeholder_large.jpg)";
});
 </script>
@endsection