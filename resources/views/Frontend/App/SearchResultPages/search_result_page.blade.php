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
            <h1>Search Result</h1><br><br>
            <div class="row">
                
                @if(!empty($all_search))
            	@foreach($all_search as $search)

                    <div class="col-md-5 card py-5 rounded ml-5 mt-4">

                    <div class="row">

                        <div class="col-md-4">
                            <img src="public/images/thumbnail/{{$search->thumbnail}}" style="width: 120px;height: 120px;" class="rounded-circle">
                        </div>

                        <div class="col-md-4">
                            <h5>{{$search->course_name}}</h5>
                            <p>{{$search->teaching_method}}</p>
                            <p>{{$search->address}}</p>
                        </div>

                        <div class="col-md-4 mt-4">

                            <a href="#"><button class="btn btn-primary">View Course</button></a><br><br>

                            <a href="#"><button class="btn btn-primary">View Tutor</button></a>
                        </div>
                    </div>
                    
                </div>
                    
            	@endforeach
                @endif

            </div>




            </div>

        </div>
    </section>


@endsection