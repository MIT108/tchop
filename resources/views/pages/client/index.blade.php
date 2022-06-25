@extends('layouts.user_type.auth')

@section('content')
    {{-- datatable --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />

    {{-- Modals --}}

    {{-- create new customer modal --}}
    <div class="modal fade" id="newCustomerModal" tabindex="-1" role="dialog" aria-labelledby="newCustomerModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create a new customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="/customer-create" method="post" enctype="multipart/form">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="firstName" name="firstName" autocomplete="off"
                                required placeholder="First Name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="lastName" placeholder="Last Name"
                                autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="phone" placeholder="Phone Number"
                                autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email Address"
                                autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Enter password"
                                minlength="8" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="cPassword" placeholder="Confirm password"
                                minlength="8" autocomplete="off" required>
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

        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">All Customers</h5>
                            </div>
                            <a href="#" class="btn bg-gradient-primary btn-sm mb-3" type="button"
                                data-bs-toggle="modal" data-bs-target="#newCustomerModal">+&nbsp; New
                                Customer</a>
                        </div>
                    </div>
                    <div class="card-body px-3 py-3 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table id="customers" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            ID
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Name
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Email
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Phone
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            status
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
                                    @foreach ($customers as $customer)
                                        <tr>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $customer->id }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ $customer->firstName . ' ' . $customer->lastName }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $customer->email }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $customer->phone }}</p>
                                            </td>
                                            @if ($customer->status == 'active')
                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="badge badge-sm bg-gradient-success">{{ $customer->status }}</span>
                                                </td>
                                            @else
                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="badge badge-sm bg-gradient-warning">{{ $customer->status }}</span>
                                                </td>
                                            @endif
                                            <td class="text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $customer->created_at }}</span>
                                            </td>
                                            <td class="text-center">
                                                <a href="/customer/{{ $customer->id }}" class="mx-3" data-bs-toggle="tooltip"
                                                    data-bs-original-title="View customer">
                                                    <i class="fas fa-eye text-secondary"></i>
                                                </a>
                                                @if ($customer->status == 'active')
                                                    <a href="/customer/suspend/{{ $customer->id }}" class="mx-3"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-original-title="Suspend customer">
                                                        <i class="fas fa-ban text-secondary"></i>
                                                    </a>
                                                @else
                                                    <a href="/customer/suspend/{{ $customer->id }}" class="mx-3"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-original-title="activate customer">
                                                        <i class="fas fa-check text-secondary"></i>
                                                    </a>
                                                @endif
                                                <a href="/customer/delete/{{ $customer->id }}" class="mx-3" data-bs-toggle="tooltip"
                                                    data-bs-original-title="Delete customer">
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
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="../../assets/js/plugins/datatables.js"></script>


<script type="text/javascript">
    $(document).ready(function() {
        $('#customers').DataTable();
    });
</script>
