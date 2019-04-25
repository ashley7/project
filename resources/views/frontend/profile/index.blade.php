@extends('frontend/layout')
@section('content')
<!-- Breadcrumbs -->
<div class="container">
   <ul class="breadcrumbs">
      <li class="breadcrumbs__item">
         <a href="{{ url('/') }}" class="breadcrumbs__url">Home</a>
      </li>
      <li class="breadcrumbs__item breadcrumbs__item--current">
         Profile
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
                  <div class="row mb-80">
                     <div class="col-lg-12">
                        <div class="tabs">
                           <ul class="tabs__list">
                              <li class="tabs__item tabs__item--active">
                                 <a href="#tab-1" class="tabs__url tabs__trigger">Profile</a>
                              </li>
                              <li class="tabs__item">
                                 <a href="#tab-2" class="tabs__url tabs__trigger">Location Information</a>
                              </li>
                              <li class="tabs__item">
                                 <a href="#tab-3" class="tabs__url tabs__trigger">settings</a>
                              </li>
                           </ul>
                           <!-- end tabs -->
                        </div>
                        <!-- tab content -->
                        <div class="tabs__content tabs__content-trigger">
                           <div class="tabs__content-pane tabs__content-pane--active" id="tab-1">
                              <form method="POST" action="{{ url('publish-blog') }}" enctype="multipart/form-data" autocomplete="off">
                                 @csrf
                                 <div class="col-md-9">
                                    <label for="input-label" style="margin-right: 660px;color:#a9aaad">First Name</label>
                                    <input type="text" placeholder="Enter surname" value="{{ Auth::user()->surname }}" name="surname">
                                    @if ($errors->has('surname'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong style="color:red;margin:bottom:15px;    margin-right: 598px;">{{ $errors->first('surname') }}</strong>
                                    </span>
                                    @endif
                                    <label for="input-label" style="margin-right: 660px;color:#a9aaad">Last Name</label>
                                    <input type="text" placeholder="Enter other name" value="{{ Auth::user()->othername }}" name="othername">
                                    @if ($errors->has('othername'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong style="color:red;margin:bottom:15px;    margin-right: 598px;">{{ $errors->first('othername') }}</strong>
                                    </span>
                                    @endif
                                    <div class="form-group row">
                                       <div class="col-md-6">
                                          <input type="radio" @if (Auth::user()->gender=="male")
                                          checked    
                                          @endif class="radio-unput" name="gender" id="radio1" value="male">
                                          <label for="radio1">Male</label>
                                          <input type="radio" @if (Auth::user()->gender=="female")
                                          checked    
                                          @endif class="radio-unput" name="gender" id="radio2" value="female">
                                          <label for="radio2">Female</label>
                                          @if ($errors->has('gender'))
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('gender') }}</strong>
                                          </span>
                                          @endif
                                       </div>
                                    </div>
                                    <br>
                                    <label for="input-label" style="margin-right: 630px;color:#a9aaad">Email address</label>
                                    <input type="text" placeholder="Enter email address" value="{{ Auth::user()->email }}" name="email">
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong style="color:red;margin:bottom:15px;    margin-right: 598px;">{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                    <button type="submit" style="margin-right: 651px;" class="btn btn-sm btn-color btn-button">
                                    {{ __('update profile') }}
                                    </button>
                                 </div>
                              </form>
                           </div>
                           <div class="tabs__content-pane" id="tab-2">
                              <form method="POST" action="{{ url('publish-blog') }}" enctype="multipart/form-data" autocomplete="off">
                                 @csrf
                                 <div class="col-md-9">
                                    <label for="input-label" style="margin-right: 660px;color:#a9aaad">Country</label>
                                    <select name="">
                                       <option value=""> select country</option>
                                       @foreach ($countries as $item)
                                       <option value="{{ $item->id }}"> {{ $item->name }}</option>
                                       @endforeach
                                    </select>
                                    <label for="input-label" style="margin-right: 660px;color:#a9aaad">Phone Number</label>
                                    <input type="text" placeholder="Enter Phone number" value="{{ Auth::user()->phone_number }}" name="phone_number">
                                    @if ($errors->has('phone_number'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong style="color:red;margin:bottom:15px;    margin-right: 598px;">{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                    @endif
                                    <button type="submit" style="margin-right: 651px;" class="btn btn-sm btn-color btn-button">
                                    {{ __('update location') }}
                                    </button>
                                 </div>
                              </form>
                           </div>
                           <div class="tabs__content-pane" id="tab-3">
                              <form method="POST" action="{{ url('publish-blog') }}" enctype="multipart/form-data" autocomplete="off">
                                 @csrf
                                 <div class="col-md-9">
                                    <div class="form-group row">
                                       <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                                       <div class="col-md-6">
                                          <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                          @if ($errors->has('password'))
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('password') }}</strong>
                                          </span>
                                          @endif
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                                       <div class="col-md-6">
                                          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                       </div>
                                    </div>
                                    <br>
                                    <div class="form-group row">
                                       <label for="password-confirm" class="col-md-4 col-form-label text-md-right"></label>
                                       <div class="col-md-6">
                                          <button type="submit" style="margin-right: 651px;" class="btn btn-sm btn-color btn-button">
                                          {{ __('change password') }}
                                          </button>
                                       </div>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- end row -->
      </div>
      <!-- end container -->
   </div>
   <!-- end post content -->
</div>
<!-- end main container -->
@endsection