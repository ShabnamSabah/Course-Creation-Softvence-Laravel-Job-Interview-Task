@extends('backend.admin.includes.admin_layout')

@push('css')
<link rel="stylesheet" href="{{ asset('backend_assets/css/ckeditor.css') }}">
@endpush

@section('content')

    <div class="page-content">

        <div class="row justify-content-center">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-body">

                        <h3 class=" text-center mb-2">Course Edit</h3>

                        @if (session('success'))

                            <div style="width:100%" class="alert alert-primary alert-dismissible fade show" role="alert">

                                <strong> Success!</strong> {{ session('success') }}

                                <button type="button" class="btn-close" data-bs-dismiss="alert"

                                    aria-label="btn-close"></button>

                            </div>

                        @elseif(session('error'))

                            <div class="alert alert-warning alert-dismissible fade show" role="alert">

                                <strong>Failed!</strong> {{ session('error') }}

                                <button type="button" class="btn-close" data-bs-dismiss="alert"

                                    aria-label="btn-close"></button>

                            </div>

                        @endif

                        <form action="{{ route('admin.course.edit', $data['course']->id) }}" method="post" enctype="multipart/form-data">

                            @csrf

                            <div class="row">

                                <div class="col-md-3">

                                    <label for="" class="form-label">Title *</label>

                                    <input type="text" class="form-control" name="title" value="{{  $data['course']->title }}"

                                        placeholder="Enter Course Title" required>

                                </div>
                                <div class="col-md-3">

                                    <label for="" class="form-label">Title (Bangla) *</label>

                                    <input type="text" class="form-control" name="title_bn" value="{{  $data['course']->title_bn }}"

                                        placeholder="Enter Course Title" required>

                                </div>

                                <div class="col-md-3 mb-3">

                                    <label class="form-label" for="">Offline Price  </label>

                                    <input type="int" name="offline_price" value="{{  $data['course']->offline_price }}" class="form-control"

                                        placeholder="Enter Online Price">

                                </div>

                                <div class="col-md-3 mb-3">

                                    <label class="form-label" for="">Online Price  </label>

                                    <input type="int" name="online_price" value="{{  $data['course']->online_price }}"class="form-control"

                                        placeholder="Enter Online Price" >

                                </div>

                                <div class="col-md-3 mb-3">

                                    <label class="form-label" for="">Offline Discount  </label>

                                    <input type="int" name="offline_discount"  value="{{  $data['course']->offline_discount }}"class="form-control"

                                        placeholder="Enter Offine Discount" >

                                </div>

                                <div class="col-md-3 mb-3">

                                    <label class="form-label" for="">Online Discount </label>

                                    <input type="int" name="online_discount" value="{{  $data['course']->online_discount }}" class="form-control"

                                        placeholder="Enter Online Discount" >

                                </div>

                             

                                

                                <div class="col-md-3">

                                    <label for="" class="form-label">Category</label>

                                    <select name="category_id" class="form-select js-example-basic-single" 

                                        id="" >

                                        <option value="">Select </option>

                                        @foreach ($data['category'] as $single_category)

                                            <option value="{{ $single_category->id}}" @if($data['course']->category_id == $single_category->id) selected @endif >{{ $single_category->title }}</option>

                                        @endforeach

                                    </select>

                                </div>



                                <div class="col-md-3 mb-3">

                                    <label for="" class="form-label">Instructor</label>

                                    <select name="instructor_id" class="form-select js-example-basic-single" 

                                        id="" >

                                        <option value="">Select </option>

                                        @foreach ($data['operator'] as $single_operator)

                                            <option value="{{ $single_operator->id}}" @if($data['course']->instructor_id == $single_operator->id) selected @endif>{{ $single_operator->name }}</option>

                                        @endforeach

                                    </select>

                                </div>



                                <div class="col-md-3 mb-3">

                                    <label for="" class="form-label">Sub Instructors </label>

                                    <select class="js-example-basic-multiple form-select" name="subinstructors[]"

                                    multiple="multiple" id="" data-width="100%">

                                    <?php $sub_instructors_array = explode(',', $data['course']->subinstructors);

                                    $sub_instructors_filtered_array = array_filter($sub_instructors_array);

       

                                   ?>

                                        @foreach ($data['operator'] as $single_operator)

                                            <option value="{{ $single_operator->id}}" @if(in_array($single_operator->id, $sub_instructors_filtered_array)) selected @endif>{{ $single_operator->name }}</option>

                                        @endforeach

                                    </select>

                                </div>



                                <div class="col-md-3 mb-3">

                                    <label for="issue_date" class="form-label">Start Date </label>

                                    <div class="input-group flatpickr" id="flatpickr-date">

                                        <input type="text" name="start_date" value="{{  $data['course']->start_date }}" id="news_date"

                                            class="form-control" placeholder="Select date" data-input >

                                        <span class="input-group-text input-group-addon" data-toggle><i

                                                data-feather="calendar"></i></span>

                                    </div>

                                </div>



                                <div class="col-md-3 mb-3">

                                    <label for="issue_date" class="form-label">End Date</label>

                                    <div class="input-group flatpickr" id="flatpickr-date">

                                        <input type="text" name="end_date" value="{{  $data['course']->end_date }}" id="news_date1"

                                            class="form-control" placeholder="Select date" data-input>

                                        <span class="input-group-text input-group-addon" data-toggle><i

                                                data-feather="calendar"></i></span>

                                    </div>

                                </div>



      

                                <div class="col-md-3 mb-3">

                                    <label class="form-label" for="">Duration </label>

                                    <input type="text" name="duration" value="{{  $data['course']->duration }}" class="form-control"

                                        placeholder="Enter Duration" >

                                </div>



                                <div class="col-md-3 mb-3">

                                    <label class="form-label" for="">Total Lesson </label>

                                    <input type="int" name="total_lessons" value="{{  $data['course']->total_lessons }}" class="form-control"

                                        placeholder="Enter Total Lesson" >

                                </div>

                                <div class="col-md-3 mb-3">

                                    <label class="form-label" for="">Class Time </label>

                                    <input type="text" name="class_time" value="{{  $data['course']->class_time }}"  class="form-control"

                                        placeholder="Enter Maximum Seat Number" >

                                </div>

                                <div class="col-md-3 mb-3">

                                    <label class="form-label" for="">Max Seat </label>

                                    <input type="int" name="max_seat" value="{{  $data['course']->max_seat }}"  class="form-control"

                                        placeholder="Enter Maximum Seat Number" >

                                </div>



                                <div class="col-md-3 mb-3">

                                    <label class="form-label" for="">Language </label>

                                    <input type="text" name="language" value="{{  $data['course']->language }}" class="form-control"

                                        placeholder="Enter Language" >

                                </div>

                           

                                <div class="col-md-3 mb-3">

                                    <label class="form-label" for="">Video Trailer (Youtube ID)</label>

                                    <input type="text" name="video_trailer" value="{{  $data['course']->video_trailer }}" class="form-control"

                                        placeholder="Enter Video Trailer" >

                                </div>

                                <div class="col-md-3 mb-3">

                                    <div class="mb-3">

                                        <label class="form-label">Your Photo</label>

                                        <input name="photo" class="form-control" type="file" id="imgPreview" accept=".jpg, .jpeg, .png"

                                            onchange="readpicture(this, '#imgPreviewId');">

                                    </div>

                                    <div class="text-center">

                                        <img id="imgPreviewId" onclick="image_upload()"

                                            src="{{ asset($data['course']->thumb ? $data['course']->thumb : 'backend_assets/images/uploads_preview.png') }}">

                                    </div>

                                </div>

                                <div class="col-md-12 mb-3">

                                    <label for="issue_date" class="form-label">Description </label>
                                    <textarea  name="description" id="editor" style="width:100%" cols="20" rows="5">{{  $data['course']->description}}</textarea>


                                </div>
                                <div class="col-md-12 mb-3">

                                    <label for="issue_date" class="form-label">Description (Bangla) </label>
                                    <textarea  name="description_bn" id="editor2" style="width:100%" cols="20" rows="5">{{  $data['course']->description_bn}}</textarea>


                                    </div>

                            </div>

                            <div class="text-center mt-2">

                                <button class="btn btn-xs btn-primary" type="submit">Update</button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection



@push('js')
<script src="{{ asset('backend_assets/js/ckeditor.js') }}"></script>

<script src="{{ asset('backend_assets/js/ckeditor_custom.js') }}"></script>

    <script>

        function image_upload() {



            $('#imgPreview').trigger('click');

        }



        function readpicture(input, preview_id) {



            if (input.files && input.files[0]) {

                var reader = new FileReader();



                reader.onload = function(e) {

                    $(preview_id)

                        .attr('src', e.target.result);

                };



                reader.readAsDataURL(input.files[0]);

            }



        }

    </script>

        

        

@endpush

