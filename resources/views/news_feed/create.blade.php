@extends('layouts.app')
@section('content')
    

<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Create News Post</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Settings 1</a>
                    </li>
                    <li><a href="#">Settings 2</a>
                    </li>
                  </ul>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <br />
              <form id="demo-form2" method="POST" action="{{ route('news-publish') }}" autocomplete="off" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data"> 
                  @csrf
                
                    <div class="form-group">
                        <label for="content">News title</label>
                        <input class="form-control"  name="title"  value="{{ old('title') }}">                    
                      </div>  
                      <div class="form-group">
                          <label for="content">News Category</label>
                         <select name="category" class="form-control">
                           <option value=""> select category</option>
                           @foreach ($categories as $item)
                               <option value="{{ $item->id }}">{{ $item->name }}</option>
                           @endforeach
                           </select>                
                        </div>  
                      <div class="form-group">
                          <label for="content">News description</label>
                          <textarea class="form-control" id="article-ckeditor"  name="description" rows="9">{{ old('description')}}</textarea>
                      </div>
                      <div class="form-group">
                          <div class="col-md-8 col-sm-8 col-xs-12">
                              <div id="PreviewPicture" style="width: 180px;
                                        height: 180px;
                                        background-position: center center;
                                        background-size: cover;
                                        -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
                                        display: inline-block;"></div>
                            <input type="file" onchange="ImagePreview()" id="FileUpload" name="file"class="form-control col-md-7 col-xs-12">
                          </div>
                        </div>
                      
                  
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class=" col-md-offset-0">
                    <button type="submit" class="btn btn-success">Publish News</button>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>

      <script src="{{ asset('backend/vendors/jquery/dist/jquery.min.js') }}"></script>
      <script>
        function ImagePreview() { 
      var PreviewIMG = document.getElementById('PreviewPicture'); 
      var UploadFile    =  document.getElementById('FileUpload').files[0]; 
      var ReaderObj  =  new FileReader(); 
      ReaderObj.onloadend = function () { 
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