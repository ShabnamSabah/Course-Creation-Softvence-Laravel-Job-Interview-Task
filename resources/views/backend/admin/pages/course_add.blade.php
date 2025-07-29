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

                        <h3 class=" text-center mb-2">Course Add</h3>

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
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.course.add') }}" method="post" enctype="multipart/form-data">

                            @csrf

                            <div class="row">

                                <div class="col-md-3">

                                    <label for="" class="form-label">Title </label>

                                    <input type="text" class="form-control  @error('course_title') is-invalid @enderror"
                                        name="course_title" placeholder="Enter Course Title">
                                    @error('course_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                                <div class="col-md-3 mb-3">

                                    <label class="form-label" for="">Video Trailer (Youtube ID) </label>

                                    <input type="text" name="video_trailer" class="form-control"
                                        placeholder="Enter Video Trailer">

                                </div>

                                <div class="col-md-3">

                                    <label for="" class="form-label">Category</label>

                                    <select name="category_id"
                                        class="form-select js-example-basic-single  @error('category_id') is-invalid @enderror""
                                        id="">

                                        <option value="">Select </option>

                                        @foreach ($data['category'] as $single_category)
                                            <option value="{{ $single_category->id }}">{{ $single_category->title }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">

                                    <label class="form-label" for="">Price </label>

                                    <input type="int" name="price" class="form-control" placeholder="Enter Price">

                                </div>


                                <div class="col-md-3 mb-3">

                                    <div class="mb-3">

                                        <label class="form-label">Upload Photo </label>

                                        <input name="photo" class="form-control  @error('photo') is-invalid @enderror""
                                            type="file" id="imgPreview" onchange="readpicture(this, '#imgPreviewId');">
                                        @error('photo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <div class="text-center">

                                        <img id="imgPreviewId" onclick="image_upload()"
                                            src="{{ asset('backend_assets/images/uploads_preview.png') }}">

                                    </div>



                                </div>

                                <div class="col-md-12 mb-3">

                                    <label for="issue_date" class="form-label">Description</label>

                                    <textarea name="description" id="editor" style="width:100%" cols="20" rows="5"></textarea>

                                </div>
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-xs btn-primary mb-3" onclick="addModule()">+ Add
                                        Module</button>
                                    <div id="modules-container"></div>

                                </div>

                            </div>

                            <div class="text-center mt-2">

                                <button class="btn btn-xs btn-success" type="submit">Add</button>

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


    <script>
        $(document).ready(function() {
            // Your code here
             const newModuleIndex = addModule();
             addContent(newModuleIndex);
        });
    </script>

    <script>
        let moduleIndex = 0;

        function addModule() {
            const modulesContainer = document.getElementById('modules-container');
            const currentIndex = moduleIndex;

            const moduleDiv = document.createElement('div');
            moduleDiv.classList.add('module');
            moduleDiv.style = 'border: 1px solid #ccc; padding: 10px; margin-bottom: 20px;';
            moduleDiv.setAttribute('data-module-index', currentIndex);

            moduleDiv.innerHTML = `
               <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5>Module #${currentIndex + 1}</h5>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeModule(this)">x</button>
                </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Module Title * </label>
                    <input type="text" class="form-control" name="modules[${currentIndex}][title]" requeired>
                    
                </div>
               
            </div> 

            <div class="mt-3">
                <h6>Contents</h6>
                <div class="contents-container"></div>
                <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="addContent(${currentIndex})">+ Add Content</button>
            </div>
        `;

            modulesContainer.appendChild(moduleDiv);
            moduleIndex++;
        }

        function removeModule(button) {
            button.closest('.module').remove();
        }

        function addContent(moduleIdx) {
            const moduleDiv = document.querySelector(`div.module[data-module-index="${moduleIdx}"]`);
            const contentsContainer = moduleDiv.querySelector('.contents-container');
            const contentIndex = contentsContainer.querySelectorAll('.content').length;

            const contentDiv = document.createElement('div');
            contentDiv.classList.add('content');
            contentDiv.style =
                'border: 1px dashed #aaa; padding: 10px; margin-bottom: 15px; border-radius: 5px; background-color: #fff;';

            contentDiv.innerHTML = `
    <div class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label">Content Title * </label>
            <input type="text" class="form-control" name="modules[${moduleIdx}][contents][${contentIndex}][title]" >
            
        </div>

        <div class="col-md-2">
            <label class="form-label">Content Type *</label>
            <select name="modules[${moduleIdx}][contents][${contentIndex}][content_type]" class="form-select" >
                <option value="video">Video</option>
                <option value="audio">Audio</option>
                <option value="pdf">PDF</option>
                <option value="image">Image</option>
                <option value="text">Text</option>
            </select>
           
        </div>

        <div class="col-md-3">
            <label class="form-label">Content URL (for media)</label>
            <input type="text" class="form-control" name="modules[${moduleIdx}][contents][${contentIndex}][content_url]" placeholder="URL or file path">
            
            </div>

        <div class="col-md-3">
            <label class="form-label">Content Text</label>
            <input type="text" name="modules[${moduleIdx}][contents][${contentIndex}][content_text]" class="form-control" placeholder="Text content here">
             
            </div>

        <div class="col-md-1 text-end">
            <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeContent(this)">x</button>
        </div>
    </div>
`;

            contentsContainer.appendChild(contentDiv);
        }

        function removeContent(button) {
            button.closest('.content').remove();
        }
    </script>
@endpush
