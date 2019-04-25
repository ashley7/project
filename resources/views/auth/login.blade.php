@extends('frontend/layout')
@section('content')
<div class="main-container container pt-80 pb-70" id="main-container">
   <!-- post content -->
   <div class="blog__content mb-72">
      <div class="container text-center">
         <div class="row justify-content-center mt-20">
            <div class="col-md-6">
               <div class="card pt-90">
                  <br><br>
                        <div>
                           
                           <h3 class="card-header">{{ __('Login') }}</h3>
                           <div class="card-body">
                             
                                <form method="POST" action="{{ route('login') }}">
                                        @csrf
                
                                        <div class="form-group row">
                                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                
                                            <div class="col-md-6">
                                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                
                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                
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
                
                                        <div class="form-group row mb-0">
                                            <div class="col-md-8 offset-md-4">
                                                <button type="submit" class="btn btn-sm btn-color btn-button">
                                                    {{ __('Login') }}
                                                </button>
                
                                                @if (Route::has('password.request'))
                                                    <a class="" href="{{ route('password.request') }}">
                                                        {{ __('Forgot Your Password?') }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </form>


                           </div>

                        </div>
                  <br><br>
               </div>
            </div>
            <div class="col-md-6">
               <div class="card pt-90">
                  <br><br>
                        <div>
                           <div class="card-body">
                               <div class="col lg 12">
                                <aside class="widget widget-socials">
                                    <h4 class="widget-title">Login using social media links</h4>
                                    <div class="socials socials--wide socials--large">
                                      <div class="row row-16">
                                        <div class="col">
                                          <a class="social social-facebook" href="{{ url('/auth/facebook') }}" title="facebook" aria-label="facebook">
                                            <i class="ui-facebook"></i>
                                            <span class="social__text">Facebook</span>
                                          </a><!--
                                          --><a class="social social-twitter" href="{{ url('/auth/twitter') }}" title="twitter"  aria-label="twitter">
                                            <i class="ui-twitter"></i>
                                            <span class="social__text">Twitter</span>
                                          </a><!--
                                          -->
                                        </div>
                                        <div class="col">
                                          <a class="social social-google-plus" href="{{ url('/auth/google') }}" title="google"  aria-label="google">
                                            <i class="ui-google"></i>
                                            <span class="social__text">Google+</span>
                                          </a><!--
                                          --><!--
                                          -->
                                        </div>                
                                      </div>            
                                    </div>
                                  </aside> <!-- end widget socials -->
                        
                               </div>
                           </div>
                        </div>
                  <br><br>
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