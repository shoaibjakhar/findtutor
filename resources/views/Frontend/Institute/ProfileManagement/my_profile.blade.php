@extends('layout')
@section('content')

<div class="container-fluid" style="margin-top: 11%">
            <div class="row">
              <div class="col-sm-12">
                <div class="card">

                  <div class="card-header">
                    <h5>My Profile</h5>
                  </div>

                  <div class="card-body">

                    <form class="needs-validation" novalidate="" method="POST" action="{{route('institute-update-profile')}}"  enctype="multipart/form-data">
                      @csrf

                      <div class="row g-3">

                        <div class="row">
                          <div class="col-md-6">
                            <img src="public/images/{{Auth::user()->image}}" width="120px" height="140px">
                          </div>
                        </div>
                        

                        <div class="col-md-4">
                          <label class="form-label">Image</label>
                          <input class="form-control" name="images"  type="file">
                        </div>


                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom01">First Name</label>
                          <input class="form-control" id="validationCustom01" type="text" required="" name="first_name" value="{{Auth::user()->name}}">
                          <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom01">Last Name</label>
                          <input class="form-control" id="validationCustom01" type="text" required="" name="last_name" value="{{Auth::user()->last_name}}">
                          <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom01">Email</label>
                          <input class="form-control" id="validationCustom01" type="email" required="" name="email" value="{{Auth::user()->email}}">
                          <div class="valid-feedback">Looks good!</div>
                        </div>

                        <!-- <div class="col-md-4">
                          <label class="form-label" for="validationCustom01">Password</label>
                          <input class="form-control" id="validationCustom01" type="type" required="" name="password" value="{{md5(Auth::user()->password)}}">
                          <div class="valid-feedback">Looks good!</div>
                        </div> -->

                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom01">Country Code</label>
                          <input class="form-control" id="validationCustom01" type="text" required="" name="country_code" value="{{Auth::user()->country_code}}">
                          <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom01">Phone No</label>
                          <input class="form-control" id="validationCustom01" type="text" required="" name="phone_no" value="{{Auth::user()->phone_no}}">
                          <div class="valid-feedback">Looks good!</div>
                        </div>

                        
                      <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                    </form>
                  </div>
                </div>
            </div>
          </div>
        </div>


@endsection