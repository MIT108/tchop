@extends('layouts.user_type.auth')

@section('content')

    {{-- Modals --}}

    {{-- create new ingredient modal --}}
    <div class="modal fade" id="editIngredient" tabindex="-1" role="dialog" aria-labelledby="editIngredientTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create a new customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="/update/ingredient" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="file"  name="image" placeholder="Choose image" id="image" value="{{ $ingredient->image }}"
                                    hidden>
                            </div>
                        </div>
                        <label for="image" class="text-center" style="width: 100%">
                            <div class="col-md-12 mb-2 imagePreviewWrapper">
                                <img id="preview-image-before-upload" src="{{ $ingredient->image }}"
                                    alt="preview image" style="max-height: 250px;">
                            </div>
                        </label>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Name:</label>
                            <input type="text"  class="form-control" value="{{ $ingredient->name }}" name="name"
                                id="recipient-name">
                        </div>
                        <input type="text" name="id" value="{{ $ingredient->id }}" required hidden >
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-gradient-primary">Create</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12 col-xl-8">
                    <div class="card h-100 p-3">
                        <div class="position-relative">
                            <a class="d-block blur-shadow-image">
                                <img src="{{ $ingredient->image }}"
                                    alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                            </a>
                        </div>
                        <div class="card-body px-0 pt-4">
                                <h4>
                                    {{ $ingredient->name }}
                                </h4>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#editIngredient" class="btn bg-gradient-primary mt-3">Edit</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-4">
                    <div class="card h-100">
                        <div class="card-header pb-0 p-3">
                            <h6 class="mb-0">Releted Menu</h6>
                        </div>
                        <div class="card-body p-3">
                            <ul class="list-group">
                                <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                                    <div class="avatar me-3">
                                        <img src="../assets/img/kal-visuals-square.jpg" alt="kal"
                                            class="border-radius-lg shadow">
                                    </div>
                                    <div class="d-flex align-items-start flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">Sophie B.</h6>
                                        <p class="mb-0 text-xs">Hi! I need more information..</p>
                                    </div>
                                    <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto" href="javascript:;">View</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<style>
    .imagePreviewWrapper {
        width: 100%;
        height: 250px;
        display: block;
        cursor: pointer;
        margin: 0 auto 30px;
        background-size: cover;
        background-position: center center;
    }
</style>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(e) {


        $('#image').change(function() {

            let reader = new FileReader();

            reader.onload = (e) => {

                $('#preview-image-before-upload').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);

        });

    });
</script>
@endsection
