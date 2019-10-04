@extends('layouts.app')

@section('content')


    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Service Log</h4>
                </div>
                <div class="modal-body" style="overflow-y:scroll; height:500px;">

                    <form name="vehicleForm" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Vehicle*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_vehicle" onkeyup="searchOptionList('select_vehicle','myUL1','{{url('default_select')}}','search_vehicle','vehicle');" name="select_vehicle" placeholder="Select Vehicle">

                                            <input type="hidden" class="vehicle_class" name="vehicle" id="vehicle" />
                                        </div>
                                    </div>
                                    <ul id="myUL1" class="myUL"></ul>
                                </div>

                                <div class="col-sm-4">
                                    <b>Service Type*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="service_type"  required>
                                                <option value="">Select Service Type</option>
                                                @foreach($serviceType as $data)
                                                    <option value="{{$data->id}}">{{$data->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Total Bill {{\App\Helpers\Utility::defaultCurrency()}}</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" value="0" name="total_bill" placeholder="Total Bill" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Invoice Reference*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="invoice_reference" placeholder="Invoice Reference" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Mileage In</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" value="0" id="" name="mileage_in" placeholder="Mileage In" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Mileage Out</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" value="0" id="" name="mileage_out" placeholder="Mileage Out">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Location</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="location" id="liter_price" placeholder="Location" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Service Date*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" name="service_date" placeholder="Purchase Date" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Attachment</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="file" multiple="multiple" class="form-control" name="attachment[]" >
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <b>Workshop</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="workshop" id="" placeholder="workshop" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <b>Comment</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class="form-control" name="comment" placeholder="Comment" ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>

                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_vehicle_service_log'); ?>','reload_data',
                            '<?php echo url('vehicle_service_log'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size Attachment-->
    <div class="modal fade" id="attachModal" tabindex="-1" role="dialog">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Attachment</h4>
                </div>
                <div class="modal-body" id="attach_content" style="overflow-y:scroll; height:400px;">


                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaForm('attachModal','attachForm','<?php echo url('edit_vehicle_service_log_attachment'); ?>','reload_data',
                            '<?php echo url('vehicle_service_log'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" id="edit_content" style="overflow-y:scroll; height:500px;">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_vehicle_service_log'); ?>','reload_data',
                            '<?php echo url('vehicle_service_log'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Transact Default Size -->
    @include('includes.print_preview')


    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Service Log
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('vehicle_service_log'); ?>',
                                    '<?php echo url('delete_vehicle_service_log'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a class="btn bg-blue-grey waves-effect" onClick ="print_content('main_table');" ><i class="fa fa-print"></i>Print</a></li>
                                <li><a class="btn bg-red waves-effect" onClick ="print_content('main_table');" ><i class="fa fa-file-pdf-o"></i>Pdf</a></li>
                                <li><a class="btn btn-warning" onClick ="$('#main_table').tableExport({type:'excel',escape:'false'});" ><i class="fa fa-file-excel-o"></i>Excel</a></li>
                                <li><a class="btn  bg-light-green waves-effect" onClick ="$('#main_table').tableExport({type:'csv',escape:'false'});" ><i class="fa fa-file-o"></i>CSV</a></li>
                                <li><a class="btn btn-info" onClick ="$('#main_table').tableExport({type:'doc',escape:'false'});" ><i class="fa fa-file-word-o"></i>Msword</a></li>

                            </ul>
                        </li>

                    </ul>
                </div>

                <div class="body table-responsive" id="reload_data">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Manage</th>
                            <th>Attachment</th>
                            <th>Vehicle</th>
                            <th>Service Type</th>
                            <th>Total Bill {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>Driver</th>
                            <th>Workshop</th>
                            <th>Mileage In(Miles)</th>
                            <th>Mileage Out(Miles)</th>
                            <th>Location</th>
                            <th>Service Date</th>
                            <th>Invoice Reference</th>
                            <th>Created by</th>
                            <th>Updated by</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)
                        <tr>
                            <td scope="row">
                                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                            </td>
                            <td>
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_vehicle_service_log_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <td>
                                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_vehicle_service_log_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>{{$data->vehicle_make}} {{$data->vehicle_model}} ({{$data->vehicleDetail->license_plate}})</td>
                            <td>{{$data->service->name}}</td>
                            <td>{{number_format($data->total_price)}}</td>
                            <td>{{$data->driver->firstname}} &nbsp; {{$data->driver->lastname}}</td>
                            <td>{{$data->workshop}}</td>
                            <td>{{number_format($data->mileage_in)}}</td>
                            <td>{{number_format($data->mileage_out)}}</td>
                            <td>{{$data->location}}</td>
                            <td>{{$data->service_date}}</td>
                            <td>{{$data->invoice_reference}}</td>
                            <td>
                                @if($data->created_by != '0')
                                    {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                                @endif
                            </td>
                            <td>
                                @if($data->updated_by != '0')
                                    {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                                @endif
                            </td>
                            <td>{{$data->created_at}}</td>
                            <td>{{$data->updated_at}}</td>
                            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class=" pagination pull-right">
                        {!! $mainData->render() !!}
                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->


<script>
    /*==================== PAGINATION =========================*/

    $(window).on('hashchange',function(){
        page = window.location.hash.replace('#','');
        getProducts(page);
    });

    $(document).on('click','.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getProducts(page);
        location.hash = page;
    });

    function getProducts(page){

        $.ajax({
            url: '?page=' + page
        }).done(function(data){
            $('#reload_data').html(data);
        });
    }

</script>

    <script>
        /*$(function() {
            $( ".datepicker" ).datepicker({
                /!*changeMonth: true,
                changeYear: true*!/
            });
        });*/
    </script>

@endsection