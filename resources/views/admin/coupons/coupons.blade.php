@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Catalogues</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Coupons</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header card-success">
                            <h3 class="card-title mt-2">Data Coupons</h3>
                            <a href="{{ url('admin/add-edit-coupon')}}" class="btn btn-primary float-right">Add Coupons</a>
                        </div>

                        @if (Session::has('success_message'))
                        <div class="mt-2 mr-3 ml-3" style="margin-bottom: -10px">
                            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                {{ Session::get('success_message')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        @endif

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="coupon" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>No. </th>
                                        <th>Code</th>
                                        <th>Coupon Type</th>
                                        <th>Amount</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;?>
                                    @foreach ($coupons as $coupon)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>
                                            {{$coupon['coupon_code']}}
                                        </td>
                                        <td>{{$coupon['coupon_type']}}</td>
                                        <td>
                                            @if ($coupon['amount_type'] == "Precentage")
                                                {{$coupon['amount']}} %
                                            @else
                                                @currency($coupon['amount'])
                                            @endif
                                        </td>
                                        <td>{{$coupon['expiry_date']}}</td>
                                        <td>
                                            @if ($coupon['status'] == 1)
                                            <a class="updateCouponStatus btn btn-primary btn-block"
                                                id="coupon-{{$coupon['id']}}" coupon_id="{{$coupon['id']}}"
                                                href="javascript:void(0)">Active</a>
                                            @else
                                            <a class="updateCouponStatus btn btn-danger btn-block"
                                                id="coupon-{{$coupon['id']}}" coupon_id="{{$coupon['id']}}"
                                                href="javascript:void(0)">Inactive</a>
                                            @endif
                                        </td>
                                        <td style="text-align: center">
                                            <a title="Edit coupon" href="{{ url('admin/add-edit-coupon/'.$coupon['id'])}}" class="btn btn-success "><i class="fas fa-edit"></i></a>
                                            <a title="Delete coupon" href="javascript:void(0)" record="coupon" recordid="{{ $coupon['id'] }}" class="confirmDelete btn btn-danger ml-3"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php $no++?>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No. </th>
                                        <th>Code</th>
                                        <th>Coupon Type</th>
                                        <th>Amount</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
