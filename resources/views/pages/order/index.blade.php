@extends('layouts.user_type.auth')

@section('content')
    {{-- datatable --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />


    {{-- Modals --}}




    <div>
        <div class="nav-wrapper position-relative end-0">
            <ul class="nav nav-pills nav-fill p-1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#Order" role="tab"
                        aria-controls="code" aria-selected="false">
                        <i class="ni ni-laptop text-sm me-2"></i> Order
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#delivered" role="tab"
                        aria-controls="code" aria-selected="false">
                        <i class="ni ni-laptop text-sm me-2"></i> Delivered
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#canceled" role="tab"
                        aria-controls="code" aria-selected="false">
                        <i class="ni ni-laptop text-sm me-2"></i> Canceled
                    </a>
                </li>
            </ul>
        </div>


        <div class="tab-content">



            <div id="Order" class="tab-pane fade active show">

                <div class="row">
                    <div class="col-12">
                        <div class="card  mb-4 mx-4">
                            <div class="card-header pb-0">
                                <div class="d-flex flex-row justify-content-between">
                                    <div>
                                        <h5 class="mb-0">Orders</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive px-2">
                                    <table class="table align-items-center mb-0 px-2" id="orders">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    id</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Customer</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Total amount</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Status</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    created date</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="text-xs font-weight-bold"> {{ $order->id }} </span>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="text-xs font-weight-bold">
                                                            {{ $order['customer']->firstName." ".$order['customer']->lastName }} </span>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="text-xs font-weight-bold"> {{ $order->totalAmount }}
                                                            FCFA</span>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <span
                                                            class="badge badge-sm bg-gradient-warning">{{ $order->status }}</span>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="text-xs font-weight-bold"> {{ $order->created_at->diffForHumans() }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="/order/{{ $order->id }}" class="mx-3"
                                                            data-bs-toggle="tooltip" data-bs-original-title="View order">
                                                            <i class="fas fa-eye text-secondary"></i>
                                                        </a>
                                                        <a href="/order/updateStatus/delivered/{{ $order->id }}" class="mx-3"
                                                            data-bs-toggle="tooltip" data-bs-original-title="Deliver Order">
                                                            <i class="cursor-pointer fas fa-check text-secondary"></i>
                                                        </a>
                                                        <a href="/order/updateStatus/canceled/{{ $order->id }}" class="mx-3"
                                                            data-bs-toggle="tooltip" data-bs-original-title="Cancel order">
                                                            <i class="cursor-pointer fas fa-ban text-secondary"></i>
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
                </div>
            </div>


            <div id="delivered" class="tab-pane fade">

                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4 mx-4">
                            <div class="card-header pb-0">
                                <div class="d-flex flex-row justify-content-between">
                                    <div>
                                        <h5 class="mb-0">Delivered Orders</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-3 py-3 pt-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table id="delivereds" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    id</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Customer</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Total amount</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Status</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    created date</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($deliveredOrders as $order)
                                                <tr>
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="text-xs font-weight-bold"> {{ $order->id }} </span>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="text-xs font-weight-bold">
                                                            {{ $order['customer']->firstName." ".$order['customer']->lastName }} </span>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="text-xs font-weight-bold">
                                                            {{ $order->totalAmount }} FCFA</span>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <span
                                                            class="badge badge-sm bg-gradient-success">{{ $order->status }}</span>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="text-xs font-weight-bold"> {{ $order->created_at }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="/order/{{ $order->id }}" class="mx-3"
                                                            data-bs-toggle="tooltip" data-bs-original-title="View order">
                                                            <i class="fas fa-eye text-secondary"></i>
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
                </div>
            </div>
            <div id="canceled" class="tab-pane fade">

                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4 mx-4">
                            <div class="card-header pb-0">
                                <div class="d-flex flex-row justify-content-between">
                                    <div>
                                        <h5 class="mb-0">Canceled Orders</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-3 py-3 pt-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table id="canceleds" class="table table-striped table-bordered" style="width:100%">

                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    id</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Customer</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Total amount</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Status</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    created date</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($canceledOrders as $order)
                                                <tr>
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="text-xs font-weight-bold"> {{ $order->id }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="text-xs font-weight-bold">
                                                            {{ $order['customer']->firstName." ".$order['customer']->lastName }} </span>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="text-xs font-weight-bold">
                                                            {{ $order->totalAmount }} FCFA</span>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <span
                                                            class="badge badge-sm bg-gradient-danger">{{ $order->status }}</span>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="text-xs font-weight-bold"> {{ $order->created_at }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="/order/{{ $order->id }}" class="mx-3"
                                                            data-bs-toggle="tooltip" data-bs-original-title="View order">
                                                            <i class="fas fa-eye text-secondary"></i>
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
        $('#orders').DataTable();
    });
    $(document).ready(function() {
        $('#delivereds').DataTable();
    });
    $(document).ready(function() {
        $('#canceleds').DataTable();
    });
</script>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
