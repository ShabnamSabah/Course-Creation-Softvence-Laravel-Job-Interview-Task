@extends('backend.admin.includes.admin_layout')

@section('content')

    <div class="page-content">

        <div class="row justify-content-center">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-body">

                        <div class=" mb-2" style="text-align:center">

                            <h3>Category List</h3>

                        </div>

                        <div style="text-align: right">

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">

                                Category Add

                            </button>

                        </div>

                        <div class="mt-3">
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
                            <div id="success"></div>
                                <div id="failed"></div>
                            </div>

                        <div class="table-responsive" id="print_data">

                            <table id="dataTableExample" class="table" style="width: 100%;">

                                <thead>

                                    <tr>

                                        <th style="">SL</th>

                                        <th style="">Title</th>

                                        <th style="width:15%">action</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($data['category_list'] as $key => $single_category)

                                        <tr>

                                            <td>{{ $key + 1 }}</td>

                                        
                                            <td>

                                                {{ $single_category->title }} 

                                           

                                            </td>

                                       

                                            <td>

                                                <a onclick="open_modal({{ $single_category->id }}, '{{ $single_category->title }}' )"

                                                    class="btn btn-success btn-icon"  data-bs-toggle="modal" data-bs-target="#editModal"><i

                                                        class="fa-solid fa-edit"></i></a>



                                                        

                                                <a class="btn btn-danger btn-icon" data-delete="{{ $single_category->id }}"

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



    <!-- Button trigger modal -->

  <!-- ADD Modal -->

  <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

            <div style="display: flex; justify-content:center; width:100%">

          <h5 class="modal-title text-center" id="addModalLabel">Add Category</h5>

            </div>

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>

        </div>

        <div class="modal-body">

            <form class=" forms-sample" action="{{ route('admin.category.add') }}" method="POST" enctype="multipart/form-data">

          @csrf

            <div class="row">

          

                <div class="col-md-12 mb-3">

                  <label for="addInputUsername1" class="form-label">Title </label>

                  <input type="text" class="form-control" id="addInputUsername1" autocomplete="off" placeholder="Title" name='title' >

                </div>
                
           
                <div class="text-center">

                <button type="submit" class="btn btn-primary me-2">Add</button>

                </div>

                </div>

              </form>

        </div>

      </div>

    </div>

  </div>



  <!-- EDIT Modal -->



      



  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

            <div style="display: flex; justify-content:center; width:100%">

          <h5 class="modal-title text-center" id="editModalLabel">Edit Category</h5>

            </div>

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>

        </div>

        <div class="modal-body">

            <form class="forms-sample" action="{{ route('admin.category.edit') }}" method="post" enctype="multipart/form-data">

                @csrf

                <div class="row">

                <div class="col-md-12 mb-3">

                  <label for="editInputUsername1" class="form-label">Title *</label>

                  <input type="text" class="form-control" id="edit_title" autocomplete="off" placeholder="Title" name='edit_title' value="" required>

                 

                </div>

        

                  <input type="hidden" class="form-control" id="edit_id"  name='edit_id' value="" >

                <div class="text-center">

                <button type="submit" class="btn btn-primary me-2">Update</button>

                </div>

                </div>

              </form>

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

                    url: '/admin/category/delete/' + id,

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



    <script>

        function open_modal(id, title, title_bn, priority, photo, icon){

            var base_url = "{{ url('/') }}";

            $("#edit_id").val(id);

            $("#edit_title").val(title);

            $("#edit_title_bn").val(title_bn);
            $("#edit_priority").val(priority);

            $("#edit_iconPreviewId").attr('src', base_url + '/' + icon ).show();

            $("#edit_imgPreviewId").attr('src', base_url + '/' + photo ).show();

            

            //$("imgPreviewId").attr('src', photo);;

        }

    </script>

@endpush

