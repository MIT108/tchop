@extends('layouts.user_type.auth')

@section('content')
    {{-- datatable --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />


    {{-- Modals --}}

    {{-- create new ingredient modal --}}
    <div class="modal fade" id="newIngredient" tabindex="-1" role="dialog" aria-labelledby="newIngredientTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create a new ingredient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="/create/ingredient" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="file" required name="image" placeholder="Choose image" id="image"
                                    hidden>
                            </div>
                        </div>
                        <label for="image" class="text-center" style="width: 100%">
                            <div class="col-md-12 mb-2 imagePreviewWrapper">
                                <img id="preview-image-before-upload" src="../assets/default/defaultImage.png"
                                    alt="preview image" style="max-height: 250px;">
                            </div>
                        </label>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Name:</label>
                            <input type="text" required class="form-control" value="" name="name"
                                id="recipient-name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-gradient-primary">Create</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- create new Menu modal --}}
    <div class="modal fade" id="newMenu" tabindex="-1" role="dialog" aria-labelledby="newMenuTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create a new Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="/create/menu" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="file" required name="image" placeholder="Choose image" id="menu"
                                    hidden>
                            </div>
                        </div>
                        <label for="menu" class="text-center" style="width: 100%">
                            <div class="col-md-12 mb-2 imagePreviewWrapper">
                                <img id="menuPreview" src="../assets/default/defaultImage.png" alt="preview image"
                                    style="max-height: 250px;">
                            </div>
                        </label>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Name:</label>
                            <input type="text" required class="form-control" value="" name="name"
                                id="recipient-name">
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-form-label">Description:</label>
                            <textarea type="text" required class="form-control" value="" name="description" id="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-gradient-primary">Create</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <div>
        <div class="nav-wrapper position-relative end-0">
            <ul class="nav nav-pills nav-fill p-1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#menuTab" role="tab"
                        aria-controls="code" aria-selected="false">
                        <i class="ni ni-laptop text-sm me-2"></i> Menus
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#ingredient" role="tab"
                        aria-controls="code" aria-selected="false">
                        <i class="ni ni-laptop text-sm me-2"></i> Ingredients
                    </a>
                </li>
            </ul>
        </div>


        <div class="tab-content">



            <div id="menuTab" class="tab-pane fade active show">

                <div class="row my-4">
                    <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="row">
                                    <div class="col-lg-6 col-7">
                                        <h6>Menus</h6>
                                    </div>
                                    <div class="col-lg-6 col-5 my-auto text-end">
                                        <a href="#" class="btn bg-gradient-primary btn-sm mb-3" type="button"
                                            data-bs-toggle="modal" data-bs-target="#newMenu">+&nbsp; New
                                            Menu</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive px-2">
                                    <table class="table align-items-center mb-0 px-2" id="menuTable">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    id</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    image</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    name</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    description</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    created date</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($menus as $menu)
                                                <tr>
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="text-xs font-weight-bold"> {{ $menu->id }} </span>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <a href="{{ $menu->image }}" target="_blank">
                                                            <img src="{{ $menu->image }}" class="avatar avatar-sm me-3"
                                                                alt="user1">
                                                        </a>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="text-xs font-weight-bold"> {{ $menu->name }} </span>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">

                                                        @php
                                                            if (Str::length($menu->description) > 20) {
                                                                $newDescription = Str::substr($menu->description, 0, 12) . '... ';
                                                            }
                                                        @endphp
                                                        @if (Str::length($menu->description) > 20)
                                                            <span class="text-xs font-weight-bold">
                                                                {{ $newDescription }}</span><a
                                                                href="/menu/{{ $menu->id }}">see more</a>
                                                        @else
                                                            <span class="text-xs font-weight-bold">
                                                                {{ $menu->description }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="text-xs font-weight-bold"> {{ $menu->created_at }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="/menu/{{ $menu->id }}" class="mx-3"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="View menu">
                                                            <i class="fas fa-eye text-secondary"></i>
                                                        </a>
                                                        <a href="/menu/delete/{{ $menu->id }}" class="mx-3"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="Delete menu">
                                                            <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="card-header pb-0">
                                <h6>Departments</h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="timeline timeline-one-side">
                                    <div class="timeline-block mb-3">
                                        <span class="timeline-step">
                                            <i class="ni ni-bell-55 text-success text-gradient"></i>
                                        </span>
                                        <div class="timeline-content">
                                            <h6 class="text-dark text-sm font-weight-bold mb-0">$2400, Design changes</h6>
                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">22 DEC 7:20 PM</p>
                                        </div>
                                    </div>
                                    <div class="timeline-block mb-3">
                                        <span class="timeline-step">
                                            <i class="ni ni-html5 text-danger text-gradient"></i>
                                        </span>
                                        <div class="timeline-content">
                                            <h6 class="text-dark text-sm font-weight-bold mb-0">New order #1832412</h6>
                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 11 PM</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div id="ingredient" class="tab-pane fade">

                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4 mx-4">
                            <div class="card-header pb-0">
                                <div class="d-flex flex-row justify-content-between">
                                    <div>
                                        <h5 class="mb-0">All Ingredients</h5>
                                    </div>
                                    <a href="#" class="btn bg-gradient-primary btn-sm mb-3" type="button"
                                        data-bs-toggle="modal" data-bs-target="#newIngredient">+&nbsp; New
                                        Ingredient</a>
                                </div>
                            </div>
                            <div class="card-body px-3 py-3 pt-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table id="ingredients" class="table table-striped table-bordered"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    ID
                                                </th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Image
                                                </th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Image
                                                </th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Creation Date
                                                </th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ingredients as $ingredient)
                                                <tr>
                                                    <td class="ps-4">
                                                        <p class="text-xs font-weight-bold mb-0">{{ $ingredient->id }}
                                                        </p>
                                                    </td>
                                                    <td class="text-center">

                                                        <a href="{{ $ingredient->image }}" target="_blank">
                                                            <img src="{{ $ingredient->image }}"
                                                                class="avatar avatar-sm me-3" alt="user1">
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">
                                                            {{ $ingredient->name }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <span
                                                            class="text-secondary text-xs font-weight-bold">{{ $ingredient->created_at }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="/ingredient/{{ $ingredient->id }}" class="mx-3"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="View indgredient">
                                                            <i class="fas fa-eye text-secondary"></i>
                                                        </a>
                                                        <a href="/ingredient/delete/{{ $ingredient->id }}"
                                                            class="mx-3" data-bs-toggle="tooltip"
                                                            data-bs-original-title="Delete indgredient">
                                                            <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                                        </a>
                                                        <span>
                                                        </span>
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
        </div>


    </div>
@endsection


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="../../assets/js/plugins/datatables.js"></script>


<script type="text/javascript">
    $(document).ready(function() {
        $('#ingredients').DataTable();
    });
    $(document).ready(function() {
        $('#menuTable').DataTable();
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
    $(document).ready(function(e) {


        $('#menu').change(function() {

            let reader = new FileReader();

            reader.onload = (e) => {

                $('#menuPreview').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);

        });

    });
</script>
