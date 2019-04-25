@extends('frontend/layout')
@section('content')
  <!-- Breadcrumbs -->
  <div class="container">
        <ul class="breadcrumbs">
          <li class="breadcrumbs__item">
              <a href="{{ url('/') }}" class="breadcrumbs__url">Home</a>
          </li>
          <li class="breadcrumbs__item">
            <a href="{{ url('publications') }}" class="breadcrumbs__url">Publications</a>
          </li>
          <li class="breadcrumbs__item breadcrumbs__item--current">
            Create publication
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

                    <form method="POST" action="{{ url('upload-publication') }}" enctype="multipart/form-data" autocomplete="off"> 
                            @csrf
                            
                            <div class="col-md-9">

                                    <input type="text" placeholder="Enter publication title(* Required field)" value="{{ old('title') }}" name="title">

                                    @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color:red;margin:bottom:15px;    margin-right: 598px;">{{ $errors->first('title') }}</strong>
                                    </span>
                                     @endif

                                     <div class="form-group">
                                        <select name="country">
                                           <option value="">Please select Country</option>
                                           @foreach ($countries as $item)
                                           <option value="{{ $item->id }}">{{ $item->name }}</option>
                                           @endforeach
                                        </select>
                                        @if ($errors->has('country'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong style="color:red;margin:bottom:15px;    margin-right: 598px;">{{ $errors->first('country') }}</strong>
                                        </span>
                                        @endif
                                     </div>

                                     <div class="form-group">
                                        <label for="content">Publication Abstract</label>
                                        <textarea class="form-control" id="description"  name="description" rows="9">{{ old('description')}}</textarea>
                                    </div>
                                    

                                    @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color:red;margin:bottom:15px;     margin-right: 556px;">{{ $errors->first('description') }}</strong>
                                    </span>
                                    <br>
                                     @endif
                                      
                                    <label for="input-label">attach file below(docx,pdf,word,ppt)</label>
                                    <input name="file" type="file" placeholder="attach photo"> 
                                    @if ($errors->has('file'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color:red;margin:bottom:15px;     margin-right: 430px;">{{ $errors->first('file') }}</strong>
                                    </span>
                                    
                                    <br>
                                     @endif

                                     <div class="form-group">
                                            <label for="content">Publication type( * required)</label>
                                           <select name="publication_type">
                                                <option value="Journal Paper">Journal Paper</option>
                                                <option value="Conference Paper">Conference Paper</option>
                                                <option value="Book Chapters">Book Chapters</option>
                                                <option value="Workshop Presentation">Workshop Presentation</option>
                                           </select>
                                        </div>
                                    <button type="submit" style="margin-right: 651px;" class="btn btn-sm btn-color btn-button">
                                            {{ __('Upload Publication') }}
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
      
@endsection