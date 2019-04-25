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
                     <h3 class="card-header">{{ __('Register') }}</h3>
                     <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" autocomplete="off">
                           @csrf
                           <div class="form-group row">
                              <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Full Name') }}</label>
                              <div class="col-md-6">
                                 <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                                 @if ($errors->has('name'))
                                 <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('name') }}</strong>
                                 </span>
                                 @endif
                              </div>
                           </div>
                           <div class="form-group row">
                              <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>
                              <div class="col-md-6">

                                 <input type="radio" class="radio-unput" name="gender" id="radio1" value="male">
                                 <label for="radio1">Male</label>
                                 &nbsp; &nbsp;
                                 <input type="radio" class="radio-unput" name="gender" id="radio2" value="female">
                                 <label for="radio2">Female</label>

                                 &nbsp; &nbsp;
                                 <input type="radio" class="radio-unput other_gender_radio" name="gender" id="radio3"  value="other">
                                 <label for="radio3">Other</label>
                                 <br><br>
                                <div id="gender_section">
                                    <input id="other_gender" type="text" class="form-control" placeholder="Enter other gender" name="other_gender">
                                </div>

                                 @if ($errors->has('gender'))
                                 <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('gender') }}</strong>
                                 </span>
                                 @endif
                              </div>
                           </div>
                           <br>
                           <div class="form-group row">
                              <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                              <div class="col-md-6">
                                 <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                                 @if ($errors->has('email'))
                                 <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('email') }}</strong>
                                 </span>
                                 @endif
                              </div>
                           </div>
                           <?php $countries=\App\Helpers\AppHelper::instance()->countries(); 
                              ?>
                           <div class="form-group row">
                              <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label>
                              <div class="col-md-6">
                                 <select name="country">
                                    <option value=""> select country</option>
                                    @foreach ($countries as $item)
                                    <option value="{{ $item->id }}"> {{ $item->name }}</option>
                                    @endforeach
                                 </select>
                                 @if ($errors->has('country'))
                                 <span class="invalid-feedback" role="alert">
                                 <strong>{{ $errors->first('country') }}</strong>
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
                           <div class="form-group row">
                              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                              <div class="col-md-6">
                                 <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                              </div>
                           </div>
                           <div class="form-group row mb-0">
                              <div class="col-md-6 offset-md-4">
                                 <button type="submit" class="btn btn-sm btn-color btn-button">
                                 {{ __('Register') }}
                                 </button>
                              </div>
                           </div>
                           <br>
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
                              <h4 class="widget-title">Register using social media links</h4>
                              <div class="socials socials--wide socials--large">
                                 <div class="row row-16">
                                    <div class="col">
                                       <a class="social social-facebook" href="{{ url('/auth/facebook') }}" title="facebook" target="_blank" aria-label="facebook">
                                       <i class="ui-facebook"></i>
                                       <span class="social__text">Facebook</span>
                                       </a><!--
                                          --><a class="social social-twitter" href="{{ url('/auth/twitter') }}" title="twitter" target="_blank" aria-label="twitter">
                                       <i class="ui-twitter"></i>
                                       <span class="social__text">Twitter</span>
                                       </a><!--
                                          -->
                                    </div>
                                    <div class="col">
                                       <a class="social social-google-plus" href="{{ url('/auth/google') }}" title="google" target="_blank" aria-label="google">
                                       <i class="ui-google"></i>
                                       <span class="social__text">Google+</span>
                                       </a><!--
                                          --><!--
                                          -->
                                    </div>
                                 </div>
                              </div>
                           </aside>
                           <!-- end widget socials -->
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


<script src="{{ asset('backend/vendors/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript">
   $(function() {
      $('#gender_section').hide();
       $('.other_gender_radio').click(function () {
         $('#gender_section').show();
       });


       $('#radio1').click(function () {
         $('#gender_section').hide();
       });

       $('#radio2').click(function () {
         $('#gender_section').hide();
       });
   });
</script>


@endsection