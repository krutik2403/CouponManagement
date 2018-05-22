{{-- Extends Layout --}}
@extends('layouts.backend')

{{-- Page Title --}}
@section('page-title', 'Admin')

{{-- Page Subtitle --}}
@section('page-subtitle', 'Control panel')

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    {!! Breadcrumbs::render('admin') !!}
@endsection

{{-- Header Extras to be Included --}}
@section('head-extras')
    @parent
@endsection

@section('content')

<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('labels.lblcouponmanagement')}}
        <a class="add-modal btn btn-sm btn-primary pull-right">
            <i class="fa fa-plus"></i> <span>Add</span>
        </a>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- right column -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box">
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">X</button>
                    <strong>{{trans('labels.whoops')}}</strong> {{trans('labels.someproblems')}}<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="box-body">
                    <table id="couponListing" class='table table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th>Coupon Name</th>
                                <th>Description</th>
                                <th>Valid From Datetime</th>
                                <th>Valid Until Datetime</th>
                                <th>Coupon Amount</th>
                                <th>Max Redeem</th>
                                <th>Max Redeem Per User</th>
                                <th>{{trans('labels.headeraction')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($coupons as $key=>$value)
                            <tr class="item{{$value->id}}">
                                <td>{{$value->coupon_name}}</td>
                                <td>{{$value->description}}</td>
                                <td>{{$value->vaild_from_datetime}}</td>
                                <td>{{$value->vaild_until_datetime}}</td>
                                <td>{{$value->coupon_amount}}</td>
                                <td>{{$value->max_redeem}}</td>
                                <td>{{$value->max_redeem_per_user}}</td>
                                <td>
                                    <button class="show-modal btn btn-success" data-id="{{$value->id}}" data-coupon_name="{{$value->coupon_name}}" data-description="{{$value->description}}" data-vaild_from_datetime="{{$value->vaild_from_datetime}}" data-vaild_until_datetime="{{$value->vaild_until_datetime}}" data-coupon_amount="{{$value->coupon_amount}}" data-max_redeem="{{$value->max_redeem}}" data-max_redeem_per_user="{{$value->max_redeem_per_user}}">
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                    </button>
                                    <button class="edit-modal btn btn-info" data-id="{{$value->id}}" data-coupon_name="{{$value->coupon_name}}" data-description="{{$value->description}}" data-vaild_from_datetime="{{$value->vaild_from_datetime}}" data-vaild_until_datetime="{{$value->vaild_until_datetime}}" data-coupon_amount="{{$value->coupon_amount}}" data-max_redeem="{{$value->max_redeem}}" data-max_redeem_per_user="{{$value->max_redeem_per_user}}">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </button>
                                    <button class="delete-modal btn btn-danger" data-id="{{$value->id}}" data-coupon_name="{{$value->coupon_name}}" data-description="{{$value->description}}" data-vaild_from_datetime="{{$value->vaild_from_datetime}}" data-vaild_until_datetime="{{$value->vaild_until_datetime}}" data-coupon_amount="{{$value->coupon_amount}}" data-max_redeem="{{$value->max_redeem}}" data-max_redeem_per_user="{{$value->max_redeem_per_user}}">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->

    <!-- Modal form to add a post -->
    <div id="addModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="coupon_name">Coupon name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="coupon_name" id="coupon_name" autofocus>
                                <small>Min: 2, Max: 100, only text</small>
                                <p class="error error_coupon_name text-center alert alert-danger hidden"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Description:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="description" name="description" cols="40" rows="4"></textarea>
                                <small>Put only text</small>
                                <p class="error error_description text-center alert alert-danger hidden"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Valid From Datetime:</label>
                            <div class="col-sm-10">
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control" name="vaild_from_datetime" id="vaild_from_datetime"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <small>{{trans('labels.vaild_from_datetime_not_valid')}}</small>
                                <p class="error error_vaild_from_datetime text-center alert alert-danger hidden"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Vaild Until Datetime:</label>
                            <div class="col-sm-10">
                                <div class='input-group date' id='datetimepicker2'>
                                    <input type='text' class="form-control" name="vaild_until_datetime" id="vaild_until_datetime" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <small>{{trans('labels.vaild_until_datetime_not_valid')}}</small>
                                <p class="error error_vaild_until_datetime text-center alert alert-danger hidden"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Coupon Amount:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="coupon_amount" id="coupon_amount" autofocus>
                                <small>Put proper coupon amount</small>
                                <p class="error error_coupon_amount text-center alert alert-danger hidden"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Max Redeem:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="max_redeem" id="max_redeem" autofocus>
                                <small>Put proper max redeem, because of {{trans('labels.max_redeem_per_user_not_valid')}}</small>
                                <p class="error error_max_redeem text-center alert alert-danger hidden"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Max Redeem Per User:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="max_redeem_per_user" id="max_redeem_per_user" autofocus>
                                <small>Put proper max redeem per user, because of {{trans('labels.max_redeem_per_user_not_valid')}}</small>
                                <p class="error error_max_redeem_per_user text-center alert alert-danger hidden"></p>
                            </div>
                        </div>

                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success add" data-dismiss="modal">
                            <span id="" class='glyphicon glyphicon-check'></span> Add
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to show a post -->
    <div id="showModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="coupon_name">Coupon name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="coupon_name" id="coupon_name_show" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="description">Description:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="description_show" name="description" cols="40" rows="4" disabled></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="vaild_from_datetime">Valid From Datetime:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="vaild_from_datetime" id="vaild_from_datetime_show" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="vaild_until_datetime">Vaild Until Datetime:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="vaild_until_datetime" id="vaild_until_datetime_show" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="coupon_amount">Coupon Amount:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="coupon_amount" id="coupon_amount_show" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="max_redeem">Max Redeem:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="max_redeem" id="max_redeem_show" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="max_redeem_per_user">Max Redeem Per User:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="max_redeem_per_user" id="max_redeem_per_user_show" disabled>
                            </div>
                        </div>

                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to edit a form -->
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="id_edit">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="coupon_name">Coupon name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="coupon_name" id="coupon_name_edit" autofocus>
                                <p class="error error_coupon_name text-center alert alert-danger hidden"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Description:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="description_edit" name="description" cols="40" rows="4"></textarea>
                                <p class="error error_description text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Valid From Datetime:</label>
                            <div class="col-sm-10">
                                <div class='input-group date' id='datetimepicker3'>
                                    <input type='text' class="form-control" name="vaild_from_datetime" id="vaild_from_datetime_edit" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <p class="error error_vaild_from_datetime text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Vaild Until Datetime:</label>
                            <div class="col-sm-10">
                                <div class='input-group date' id='datetimepicker4'>
                                    <input type='text' class="form-control" name="vaild_until_datetime" id="vaild_until_datetime_edit" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <p class="error error_vaild_until_datetime text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Coupon Amount:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="coupon_amount" id="coupon_amount_edit" autofocus>
                                <p class="error error_coupon_amount text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Max Redeem:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="max_redeem" id="max_redeem_edit" autofocus>
                                <p class="error error_max_redeem text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="content">Max Redeem Per User:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="max_redeem_per_user" id="max_redeem_per_user_edit" autofocus>
                                <p class="error error_max_redeem_per_user text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary edit" data-dismiss="modal">
                            <span class='glyphicon glyphicon-check'></span> Edit
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to delete a form -->
    <div id="deleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">Are you sure you want to delete the following post?</h3>
                    <br />
                    <form class="form-horizontal" role="form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id">ID:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="id_delete" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="coupon_name">Coupon name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="coupon_name" id="coupon_name_delete" disabled>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger delete" data-dismiss="modal">
                            <span id="" class='glyphicon glyphicon-trash'></span> Delete
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

{{-- Footer Extras to be Included --}}
@section('footer-extras')
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#couponListing').DataTable({
           "aaSorting": []
        });
    });
</script>

<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker({
          format:'YYYY-MM-DD HH:mm:ss',
          inline: false,
          sideBySide: true
        });

        $('#datetimepicker2').datetimepicker({
          format:'YYYY-MM-DD HH:mm:ss',
          inline: false,
          sideBySide: true
        });

        $('#datetimepicker3').datetimepicker({
          format:'YYYY-MM-DD HH:mm:ss',
          inline: false,
          sideBySide: true
        });

        $('#datetimepicker4').datetimepicker({
          format:'YYYY-MM-DD HH:mm:ss',
          inline: false,
          sideBySide: true
        });
    });
  </script>

<script type="text/javascript">
    // add a new post
    $(document).on('click', '.add-modal', function() {
        $('.modal-title').text('Add');
        $('#addModal').modal('show');
    });

    $('.modal-footer').on('click', '.add', function() {
            $.ajax({
                type: 'POST',
                url: '{{ url("admin/coupon/savecoupon") }}',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'coupon_name': $('#coupon_name').val(),
                    'description': $('#description').val(),
                    'vaild_from_datetime': $('#vaild_from_datetime').val(),
                    'vaild_until_datetime': $('#vaild_until_datetime').val(),
                    'coupon_amount': $('#coupon_amount').val(),
                    'max_redeem': $('#max_redeem').val(),
                    'max_redeem_per_user': $('#max_redeem_per_user').val()
                },
                success: function(data, table)
                {
                    $('.error_coupon_name').addClass('hidden');
                    $('.error_description').addClass('hidden');
                    $('.error_vaild_from_datetime').addClass('hidden');
                    $('.error_vaild_until_datetime').addClass('hidden');
                    $('.error_coupon_amount').addClass('hidden');
                    $('.error_max_redeem').addClass('hidden');
                    $('.error_max_redeem_per_user').addClass('hidden');

                    if ((data.errors))
                    {
                        setTimeout(function () {
                            $('#addModal').modal('show');
                            toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                        }, 500);

                        if (data.errors.coupon_name) {
                            $('.error_coupon_name').removeClass('hidden');
                            $('.error_coupon_name').text(data.errors.coupon_name);
                        }
                        if (data.errors.description) {
                            $('.error_description').removeClass('hidden');
                            $('.error_description').text(data.errors.description);
                        }
                        if (data.errors.vaild_from_datetime) {
                            $('.error_vaild_from_datetime').removeClass('hidden');
                            $('.error_vaild_from_datetime').text(data.errors.vaild_from_datetime);
                        }
                        if (data.errors.vaild_until_datetime) {
                            $('.error_vaild_until_datetime').removeClass('hidden');
                            $('.error_vaild_until_datetime').text(data.errors.vaild_until_datetime);
                        }
                        if (data.errors.coupon_amount) {
                            $('.error_coupon_amount').removeClass('hidden');
                            $('.error_coupon_amount').text(data.errors.coupon_amount);
                        }
                        if (data.errors.max_redeem) {
                            $('.error_max_redeem').removeClass('hidden');
                            $('.error_max_redeem').text(data.errors.max_redeem);
                        }
                        if (data.errors.max_redeem_per_user) {
                            $('.error_max_redeem_per_user').removeClass('hidden');
                            $('.error_max_redeem_per_user').text(data.errors.max_redeem_per_user);
                        }
                    }
                    else
                    {
                        toastr.success('Successfully added Post!', 'Success Alert', {timeOut: 5000});
                        $('#couponListing').prepend("<tr class='item" + data.id + "'><td>" + data.coupon_name + "</td><td>" + data.description + "</td><td>" + data.vaild_from_datetime + "</td><td>" + data.vaild_until_datetime + "</td><td>" + data.coupon_amount + "</td><td>" + data.max_redeem + "</td><td>" + data.max_redeem_per_user + "</td><td><button class='show-modal btn btn-success' data-id='" + data.id + "' data-coupon_name='" + data.coupon_name + "' data-description='" + data.description + "' data-vaild_from_datetime='" + data.vaild_from_datetime + "' data-vaild_until_datetime='" + data.vaild_until_datetime + "' data-coupon_amount='" + data.coupon_amount + "' data-max_redeem='" + data.max_redeem + "' data-max_redeem_per_user='" + data.max_redeem_per_user + "'><span class='glyphicon glyphicon-eye-open'></span></button> <button class='edit-modal btn btn-info' data-id='" + data.id + "' data-coupon_name='" + data.coupon_name + "' data-description='" + data.description + "' data-vaild_from_datetime='" + data.vaild_from_datetime + "' data-vaild_until_datetime='" + data.vaild_until_datetime + "' data-coupon_amount='" + data.coupon_amount + "' data-max_redeem='" + data.max_redeem + "' data-max_redeem_per_user='" + data.max_redeem_per_user + "'><span class='glyphicon glyphicon-edit'></span></button> <button class='delete-modal btn btn-danger' data-id='" + data.id + "' data-coupon_name='" + data.coupon_name + "' data-description='" + data.description + "' data-vaild_from_datetime='" + data.vaild_from_datetime + "' data-vaild_until_datetime='" + data.vaild_until_datetime + "' data-coupon_amount='" + data.coupon_amount + "' data-max_redeem='" + data.max_redeem + "' data-max_redeem_per_user='" + data.max_redeem_per_user + "'><span class='glyphicon glyphicon-trash'></span></button></td></tr>");
                    }
                },
            });
        });


    // Show a post
    $(document).on('click', '.show-modal', function() {
        $('.modal-title').text('Show');
        $('#coupon_name_show').val($(this).data('coupon_name'));
        $('#description_show').val($(this).data('description'));
        $('#vaild_from_datetime_show').val($(this).data('vaild_from_datetime'));
        $('#vaild_until_datetime_show').val($(this).data('vaild_until_datetime'));
        $('#coupon_amount_show').val($(this).data('coupon_amount'));
        $('#max_redeem_show').val($(this).data('max_redeem'));
        $('#max_redeem_per_user_show').val($(this).data('max_redeem_per_user'));
        $('#showModal').modal('show');
    });


     // Edit a post
        $(document).on('click', '.edit-modal', function() {
            $('.modal-title').text('Edit');
            $('#id_edit').val($(this).data('id'));
            $('#coupon_name_edit').val($(this).data('coupon_name'));
            $('#description_edit').val($(this).data('description'));
            $('#vaild_from_datetime_edit').val($(this).data('vaild_from_datetime'));
            $('#vaild_until_datetime_edit').val($(this).data('vaild_until_datetime'));
            $('#coupon_amount_edit').val($(this).data('coupon_amount'));
            $('#max_redeem_edit').val($(this).data('max_redeem'));
            $('#max_redeem_per_user_edit').val($(this).data('max_redeem_per_user'));
            id = $('#id_edit').val();
            $('#editModal').modal('show');
        });

        $('.modal-footer').on('click', '.edit', function() {
            $.ajax({
                type: 'POST',
                url: '{{ url("admin/coupon/savecoupon") }}',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': $("#id_edit").val(),
                    'coupon_name': $('#coupon_name_edit').val(),
                    'description': $('#description_edit').val(),
                    'vaild_from_datetime': $('#vaild_from_datetime_edit').val(),
                    'vaild_until_datetime': $('#vaild_until_datetime_edit').val(),
                    'coupon_amount': $('#coupon_amount_edit').val(),
                    'max_redeem': $('#max_redeem_edit').val(),
                    'max_redeem_per_user': $('#max_redeem_per_user_edit').val()
                },
                success: function(data)
                {
                    $('.error_coupon_name').addClass('hidden');
                    $('.error_description').addClass('hidden');
                    $('.error_vaild_from_datetime').addClass('hidden');
                    $('.error_vaild_until_datetime').addClass('hidden');
                    $('.error_coupon_amount').addClass('hidden');
                    $('.error_max_redeem').addClass('hidden');
                    $('.error_max_redeem_per_user').addClass('hidden');

                    if ((data.errors)) {
                        setTimeout(function () {
                            $('#editModal').modal('show');
                            toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                        }, 500);

                        if (data.errors.coupon_name) {
                            $('.error_coupon_name').removeClass('hidden');
                            $('.error_coupon_name').text(data.errors.coupon_name);
                        }
                        if (data.errors.description) {
                            $('.error_description').removeClass('hidden');
                            $('.error_description').text(data.errors.description);
                        }
                        if (data.errors.vaild_from_datetime) {
                            $('.error_vaild_from_datetime').removeClass('hidden');
                            $('.error_vaild_from_datetime').text(data.errors.vaild_from_datetime);
                        }
                        if (data.errors.vaild_until_datetime) {
                            $('.error_vaild_until_datetime').removeClass('hidden');
                            $('.error_vaild_until_datetime').text(data.errors.vaild_until_datetime);
                        }
                        if (data.errors.coupon_amount) {
                            $('.error_coupon_amount').removeClass('hidden');
                            $('.error_coupon_amount').text(data.errors.coupon_amount);
                        }
                        if (data.errors.max_redeem) {
                            $('.error_max_redeem').removeClass('hidden');
                            $('.error_max_redeem').text(data.errors.max_redeem);
                        }
                        if (data.errors.max_redeem_per_user) {
                            $('.error_max_redeem_per_user').removeClass('hidden');
                            $('.error_max_redeem_per_user').text(data.errors.max_redeem_per_user);
                        }
                    }
                    else
                    {
                        toastr.success('Successfully updated Post!', 'Success Alert', {timeOut: 5000});
                        $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'><td>" + data.coupon_name + "</td><td>" + data.description + "</td><td>" + data.vaild_from_datetime + "</td><td>" + data.vaild_until_datetime + "</td><td>" + data.coupon_amount + "</td><td>" + data.max_redeem + "</td><td>" + data.max_redeem_per_user + "</td><td><button class='show-modal btn btn-success' data-id='" + data.id + "' data-coupon_name='" + data.coupon_name + "' data-description='" + data.description + "' data-vaild_from_datetime='" + data.vaild_from_datetime + "' data-vaild_until_datetime='" + data.vaild_until_datetime + "' data-coupon_amount='" + data.coupon_amount + "' data-max_redeem='" + data.max_redeem + "' data-max_redeem_per_user='" + data.max_redeem_per_user + "'><span class='glyphicon glyphicon-eye-open'></span></button> <button class='edit-modal btn btn-info' data-id='" + data.id + "' data-coupon_name='" + data.coupon_name + "' data-description='" + data.description + "' data-vaild_from_datetime='" + data.vaild_from_datetime + "' data-vaild_until_datetime='" + data.vaild_until_datetime + "' data-coupon_amount='" + data.coupon_amount + "' data-max_redeem='" + data.max_redeem + "' data-max_redeem_per_user='" + data.max_redeem_per_user + "'><span class='glyphicon glyphicon-edit'></span></button> <button class='delete-modal btn btn-danger' data-id='" + data.id + "' data-coupon_name='" + data.coupon_name + "' data-description='" + data.description + "' data-vaild_from_datetime='" + data.vaild_from_datetime + "' data-vaild_until_datetime='" + data.vaild_until_datetime + "' data-coupon_amount='" + data.coupon_amount + "' data-max_redeem='" + data.max_redeem + "' data-max_redeem_per_user='" + data.max_redeem_per_user + "'><span class='glyphicon glyphicon-trash'></span></button></td></tr>");

                    }
                }
            });
        });

        // delete a post
        $(document).on('click', '.delete-modal', function() {
            $('.modal-title').text('Delete');
            $('#id_delete').val($(this).data('id'));
            $('#coupon_name_delete').val($(this).data('coupon_name'));
            $('#deleteModal').modal('show');
            id = $('#id_delete').val();
        });

        $('.modal-footer').on('click', '.delete', function() {
            $.ajax({
                type: 'POST',
                url: '{{ url("admin/coupon/delete") }}',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': id
                },
                success: function(data) {
                    toastr.success('Successfully deleted Post!', 'Success Alert', {timeOut: 5000});
                    $('.item' + data['id']).remove();
                }
            });
        });

</script>
@endsection



