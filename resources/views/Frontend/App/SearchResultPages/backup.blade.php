@extends('Frontend/App/layout')
@section('user_layout')

<style type="text/css">
    .btn{
        width: 100%;
    }
</style>
	
	<section class="bookShowcase">
        <span class="shape-1"> <img src="public/assets/frontend/images/bg-dot-shape.svg" alt="bg-shape"> </span>
        <div class="container">
            <h1>All Courses</h1><br><br>
            <div class="row">
                
                @if(!empty($all_courses))
            	@foreach($all_courses as $courses)

                    <div class="col-md-5 card py-5 rounded ml-5 mt-4">

                    <div class="row">

                        <div class="col-md-4">
                            <img src="public/images/thumbnail/{{$courses->thumbnail}}" style="width: 120px;height: 120px;" class="rounded-circle">
                        </div>

                        <div class="col-md-4">
                            <h5>{{$courses->course_name}}</h5>
                            <p>{{$courses->teaching_method}}</p>
                            <p>{{$courses->address}}</p>
                        </div>

                        <div class="col-md-4 mt-4">

                            <a href="view-course-detail/{{$courses->id}}"><button class="btn btn-primary">View Course</button></a><br><br>

                            <a href="#"><button class="btn btn-primary">View Tutor</button></a>
                        </div>
                    </div>
                    
                </div>
                    
            	@endforeach
                @endif

            </div>



            <br>
            <h1>All Batchs</h1>
            <br>
            <div class="row">

                @if(!empty($all_batch))
                @foreach($all_batch as $batch)
                    
                    <div class="col-md-5 card py-5 rounded ml-5 mt-4">

                    <div class="row">

                        <div class="col-md-4">
                            <img src="public/images/thumbnail/{{$batch->thumbnail}}" style="width: 120px;height: 120px;" class="rounded-circle">
                        </div>

                        <div class="col-md-4">
                            <h5>{{$batch->batch_name}}</h5>
                            <p>{{$batch->teaching_method}}</p>
                            <p>{{$batch->address}}</p>
                        </div>

                        <div class="col-md-4 mt-4">

                            <a href="view-batch-detail/{{$batch->id}}"><button class="btn btn-primary">View Batch</button></a><br><br>

                            <a href="#"><button class="btn btn-primary">View Tutor</button></a>
                        </div>
                    </div>
                    
                </div>

                @endforeach
                @endif

            </div>


            <br>
            <h1>All Tutors</h1>
            <br>
            <div class="row">

                @if(!empty($all_user))
                @foreach($all_user as $user)
                    @if($user->role=="tutor")
                    <div class="col-md-5 card py-5 rounded ml-5 mt-4">

                    <div class="row">

                        <div class="col-md-4">
                            <img src="public/images/{{$user->image}}" style="width: 120px;height: 120px;" class="rounded-circle">
                        </div>

                        <div class="col-md-4">
                            <h5>{{$user->name}} {{$user->last_name}}</h5>
                            <p>{{$user->email}}</p>
                            <p>{{$user->country_code}} {{$user->phone_no}}</p>
                        </div>

                        <div class="col-md-4 mt-4">

                            <a href="view-tutor-detail/{{$user->id}}"><button class="btn btn-primary">View Profile</button></a><br><br>

                            <a href="#"><button class="btn btn-primary">View Tutor</button></a>
                        </div>
                    </div>
                    
                </div>

                    @endif
                @endforeach
                @endif
            </div>


            <br>
            <h1>All Institutes</h1>
            <br>
            <div class="row">

                @if(!empty($all_user))
                @foreach($all_user as $user)
                    @if($user->role=="institute")

                    <div class="col-md-5 card py-5 rounded ml-5 mt-4">

                    <div class="row">

                        <div class="col-md-4">
                            <img src="public/images/{{$user->image}}" style="width: 120px;height: 120px;" class="rounded-circle">
                        </div>

                        <div class="col-md-4">
                            <h5>{{$user->name}} {{$user->last_name}}</h5>
                            <p>{{$user->email}}</p>
                            <p>{{$user->country_code}} {{$user->phone_no}}</p>
                        </div>

                        <div class="col-md-4 mt-4">

                            <a href="view-institute-detail/{{$user->id}}"><button class="btn btn-primary">View Institute</button></a><br><br>

                            <a href="#"><button class="btn btn-primary">View Tutor</button></a>
                        </div>
                    </div>
                    
                </div>
                    
                    @endif
                @endforeach
                @endif

            </div>

        </div>
    </section>


@endsection