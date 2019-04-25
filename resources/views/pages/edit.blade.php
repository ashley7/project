@extends('layouts.app')
@section('content')
    

<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Update page</h2>
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
              <form id="demo-form2" method="POST" action="{{ route('pages.update',[$page->id]) }}" autocomplete="off" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data"> 
                  @csrf
                   <input type="hidden" value="put" name="_method">
                    <div class="form-group">
                        <label for="content">Page Title</label>
                        <input class="form-control"  name="title"  value="{{ $page->title }}">                    
                      </div>  
                       
                      <div class="form-group">
                          <label for="content">Page description</label>
                          <textarea class="form-control" id="article-ckeditor"  name="description" rows="9">{{ $page->description }}</textarea>
                      </div>
                      <div class="form-group">
                            <label for="content">Appear on Home page</label>
                            {{-- featured --}}
                            <div class="radio">
                              <label class="">
                                    <div class="iradio_flat-green" style="position: relative;">
                                            <input type="radio" class="flat" name="featured" value="show" 
                                            @if ($page->position=="show")
                                                checked
                                            @endif style="position: absolute; opacity: 0;">
                                           </div> Yes 
                                           <div class="iradio_flat-green" style="position: relative;">
                                                <input type="radio"
                                                @if ($page->position=="hide")
                                                checked
                                            @endif
                                                 class="flat" name="featured" value="hide" style="position: absolute; opacity: 0;">
                                               </div> No 
    
                                
                              </label>
                            </div>
                      </div>
                    
                  
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class=" col-md-offset-0">
                    <button type="submit" class="btn btn-success">update Page</button>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
@endsection