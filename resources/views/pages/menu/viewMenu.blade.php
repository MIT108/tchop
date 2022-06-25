@extends('layouts.user_type.auth')

@section('content')
    {{-- datatable --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />


    {{-- Modals --}}

    {{-- create new ingredient modal --}}
    <div class="modal fade" id="editIngredient" tabindex="-1" role="dialog" aria-labelledby="editIngredientTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">update a menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="/update/menu" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="file" name="image" placeholder="Choose image" id="image"
                                    value="{{ $menu->image }}" hidden>
                            </div>
                        </div>
                        <label for="image" class="text-center" style="width: 100%">
                            <div class="col-md-12 mb-2 imagePreviewWrapper">
                                <img id="preview-image-before-upload" src="{{ $menu->image }}" alt="preview image"
                                    style="max-height: 250px;">
                            </div>
                        </label>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" value="{{ $menu->name }}" name="name"
                                id="recipient-name">
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-form-label">Description:</label>
                            <textarea type="text" required class="form-control" name="description" id="description">{{ $menu->description }}</textarea>
                        </div>
                        <input type="text" name="id" value="{{ $menu->id }}" required hidden>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-gradient-primary">update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    {{-- add ingredient modal --}}
    <div class="modal fade" id="addIngredient" tabindex="-1" role="dialog" aria-labelledby="addIngredientTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add ingredient to menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="/menu/ingredients/{{ $menu->id }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <table class="table align-items-center mb-0 px-2" id="ingredents">
                            <thead>
                                <tr>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        id</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        action</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        name</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        created date</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ingredients as $ingredient)
                                    <tr>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold"> {{ $ingredient->id }} </span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <center>
                                                <div class="form-check text-center">
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                        name="{{ $ingredient->id }}" id="fcustomCheck1">
                                                </div>
                                            </center>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold">
                                                {{ $menu->name }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold"> {{ $menu->created_at }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-gradient-primary">update</button>
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
                                <img src="{{ $menu->image }}" alt="img-blur-shadow"
                                    class="img-fluid shadow border-radius-lg">
                            </a>
                        </div>
                        <div class="card-body px-0 pt-4">
                            <h4>
                                {{ $menu->name }}
                            </h4>
                            <p>
                                {{ $menu->description }}
                            </p>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#editIngredient"
                                class="btn bg-gradient-primary mt-3">Edit</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-4">
                    <div class="card h-100">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-lg-6 col-7">
                                    <h6>Ingredient</h6>
                                </div>
                                <div class="col-lg-6 col-5 my-auto text-end">
                                    <a href="#" class="btn bg-gradient-primary btn-sm mb-3" type="button"
                                        data-bs-toggle="modal" data-bs-target="#addIngredient">+&nbsp; add ingredient</a>
                                </div>
                            </div>
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


    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../assets/js/plugins/datatables.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#ingredents').DataTable();
        });
    </script>

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
