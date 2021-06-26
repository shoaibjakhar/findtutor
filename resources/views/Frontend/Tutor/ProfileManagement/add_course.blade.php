@extends('layout')
@section('content')

<div class="container-fluid" style="margin-top: 11%">
            <div class="row">
              <div class="col-sm-12">
                <div class="card">

                  <div class="card-header">
                    <h5>Add Course</h5>
                  </div>

                  <div class="card-body">

                    <form class="needs-validation" novalidate="" method="POST" action="{{URL::to('tutor-save-course')}}" enctype="multipart/form-data">
                      @csrf

                      <div class="row g-3">

                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom01">Course name</label>
                          <input class="form-control" id="validationCustom01" type="text" required="" name="course_name">
                          <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom01">Thumbnail</label>
                          <input class="form-control" id="validationCustom01" type="file" required="" name="thumbnail" value="">
                          <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom01">Teaching Method</label>
                          <!-- <input class="form-control" id="validationCustom01" type="text" value="Mark" required="" name="course_name"> -->
                          <select class="form-control" id="validationCustom01" required="" name="teaching_method">
                            <option value="">Select</option>
                            <option value="offline">Offline</option>
                            <option value="online">Online</option>
                          </select>
                          <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom02">Price</label>
                          <input class="form-control" id="validationCustom02" type="number" required="" name="price">
                          <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-4">
                          <label class="form-label" for="validationCustom02">Address</label>
                          <input class="form-control" id="validationCustom02" type="text" required="" name="address">
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