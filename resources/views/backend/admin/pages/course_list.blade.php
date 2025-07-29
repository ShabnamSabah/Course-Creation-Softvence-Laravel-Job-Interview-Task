@extends('backend.admin.includes.admin_layout')
@section('content')
    <div class="page-content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class=" mb-2" style="text-align:center">
                            <h3>Course List</h3>
                        </div>
                        <div class="mt-3">
                            @if (session('error'))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>Failed!</strong> {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="btn-close"></button>
                                </div>
                            @endif
                            <div id="success"></div>
                            <div id="failed"></div>
                        </div>
                        <div class="table-responsive" id="print_data">
                            <table id="dataTableExample" class="table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width:5%">SL</th>
                                        <th style="width:10%">Photo</th>
                                        <th style="width:20%">Title</th>
                                        <th style="width:15%">Price</th>
                                         <th style="width:15%">Category</th>
                                        <th style="width:15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['course_list'] as $key => $single_course)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <img src="{{ asset($single_course->thumb ? $single_course->thumb : 'backend_assets/images/user-dummy.png') }}"
                                                    alt="" loading="lazy" style="width:1000px" >
                                            </td>
                                             <td>{{ $single_course->course_title }}
                                               
                                            </td> 
                                          
                                             <td>{{$single_course->price }}
                                            </td>
                                             <td>{{ $single_course->category->title}}</td> 
                                            <td>

                                  

                                                        
                                                <a class="btn btn-danger btn-icon" data-delete="{{ $single_course->id }}"
                                                    id="delete"><i class="fa-solid fa-trash"></i> </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).on('click', '#delete', function() {
            if (confirm('Are You Sure ?')) {
                let id = $(this).attr('data-delete');
                let row = $(this).closest('tr');
                $.ajax({
                    url: '/admin/course/delete/' + id,
                    success: function(data) {
                        var data_object = JSON.parse(data);
                        if (data_object.status == 'SUCCESS') {
                            row.remove();
                            $('#Table tbody tr').each(function(index) {
                                $(this).find('td:first').text(index + 1);
                            });
                            $('#success').css('display', 'block');
                            $('#success').html(
                                '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success! </strong>' +
                                data_object.message +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button></div>'
                            );
                        } else {
                            $('#failed').html('display', 'block');
                            $('#failed').html(
                                '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failed! </strong>' +
                                data_object.message +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button></div>'
                            );
                        }

                    }
                });
            }
        });
    </script>
@endpush
