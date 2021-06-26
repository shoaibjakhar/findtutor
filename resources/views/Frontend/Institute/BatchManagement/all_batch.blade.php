@extends('layout')
@section('content')



<div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
	<div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h3>All Batches</h3>
                </div>
                <div class="col-6">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">                                       <i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item">Batch Management</li>
                    <li class="breadcrumb-item active">All Batch</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>

          
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="display" id="basic-1">
                        <thead>

                          <tr>
                            <th>ID</th>
                            <th>Thumbnail</th>
                            <th>Batch Name</th>
                            <th>Teaching Method</th>
                            <th>Price</th>
                            <th>Address</th>
                          </tr>

                        </thead>

                        <tbody>

                          @foreach($all_batches as $batch)

                          <tr>

                            <td>{{$batch->id}}</td>
                            <td><img src="public/images/thumbnail/{{$batch->thumbnail}}" width="50px" height="50px"></td>
                            <td>{{$batch->batch_name}}</td>
                            <td>{{$batch->teaching_method}}</td>
                            <td>{{$batch->price}}</td>
                            <td>{{$batch->address}}</td>
                            
                          </tr>

                          @endforeach
                        </tbody>

                      </table>
                    </div>
                  </div>
                </div>
              </div>


@endsection