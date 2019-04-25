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
        <div>
            <div>
                <h3 class="card-header">{{ __('Reset Password') }}</h3>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

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

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-sm btn-color btn-button">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
                        
                  <br><br>
              </div>
               </div>     
            
            </div> <!-- end row -->
  
          </div> <!-- end container -->
        </div> <!-- end post content -->
      </div> <!-- end main container -->
      
@endsection