@extends('layouts.app')
@section('content')
    

<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Update User</h2>
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
              <form id="demo-form2" method="POST" action="{{ route('users.update',[$user->id]) }}" autocomplete="off" data-parsley-validate class="form-horizontal form-label-left">
                  @csrf
                  <input type="hidden" name="_method" value="put">
                  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Surname <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" value="{{ $user->surname }}" id="surname" name="surname" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Other name <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" value="{{ $user->othername }}" id="othername" name="othername" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                  <br>
                                    <p>
                                      Male:
                                      <input type="radio" @if ($user->gender=="Male")
                                          checked
                                      @endif class="flat" name="gender" id="Male" value="Male" required /> Female:
                                      <input type="radio" @if ($user->gender=="Female")
                                          checked
                                      @endif class="flat" name="gender" id="Female" value="Female" />
                                    </p>
                              </div>
                            </div>
                            
                              <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">email address <span class="required"></span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                      <input type="email" value="{{ $user->email }}" id="email" name="email" class="form-control col-md-7 col-xs-12">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Phone Number<span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                          <input type="text" value="{{ $user->phone_number }}" id="phone_number" name="phone_number" required="required" class="form-control col-md-7 col-xs-12">
                                        </div>
                                      </div>

                                      <div class="form-group">
                                          <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                              <div class="form-group">
                                                  <strong>Role:</strong>
                                                  {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
                                              </div>
                                          </div>
                                        </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" class="btn btn-success">update Record</button>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
@endsection