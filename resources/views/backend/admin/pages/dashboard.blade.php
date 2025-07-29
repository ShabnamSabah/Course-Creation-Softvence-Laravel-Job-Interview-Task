@extends('backend.admin.includes.admin_layout')
@section('content')
    <div class="page-content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h6 class="card-title mb-3">Welcome To Dashboard</h6>
               <div class="row">
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Total Courses </h6>
                            </div>
                            <div class="mt-2" style="color: green ;font-size:18px">
                                {{ $data['total_course'] }}
                            </div>
                            <div class="mt-2" style="">
                                <a href="{{route('admin.course.list')}}">Course List <i
                                        class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>             
               </div>
            </div>
        </div>
    </div>
@endsection
