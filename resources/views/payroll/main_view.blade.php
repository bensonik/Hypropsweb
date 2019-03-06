@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Payroll</h4>
                </div>
                <div class="modal-body">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="position_name" placeholder="Position Name">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitDefault('createModal','createMainForm','<?php echo url('create_position'); ?>','reload_data',
                            '<?php echo url('position'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" id="edit_content">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitDefault('editModal','editMainForm','<?php echo url('edit_position'); ?>','reload_data',
                            '<?php echo url('position'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Payroll
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <!--<li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>-->
                        {{--<li>
                            <button type="button" onclick="processPayroll('kid_checkbox','reload_data','<?php echo url('payroll'); ?>',
                                    '<?php echo url('process_payroll'); ?>','<?php echo csrf_token(); ?>','1','payrollForm');" class="btn btn-success">
                                <i class="fa fa-check-square-o"></i>Process Payment
                            </button>
                        </li>--}}
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('payroll'); ?>',
                                    '<?php echo url('delete_payroll'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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

                <div class="body">
                @if(in_array(Auth::user()->role,\App\Helpers\Utility::ACCOUNT_MANAGEMENT))
                <div class="row">
                    <form name="import_excel" id="payForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <select class="form-control" name="month" >
                                    <option value="">Select Account</option>
                                    <option value="">Cash</option>
                                    <option value="">Bank</option>
                                    <option value="">Cheque</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control" name="cheque_no" placeholder="Cheque Number">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">

                            <div class="form-line">
                                Affect General Ledger
                                <input type="checkbox" class="" name="ledger_valid" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <input class="form-control datepicker" name="date" placeholder="Date" >
                            </div>
                        </div>
                    </div>

                    <button type="button" onclick="processPayroll('kid_checkbox','reload_data','<?php echo url('payroll'); ?>',
                            '<?php echo url('approve_payroll'); ?>','<?php echo csrf_token(); ?>','1','payForm');" class="btn btn-success">
                        <i class="fa fa-check-square-o"></i>Pay Salary
                    </button>
                    </form>
                </div>
                @endif
                <hr/>

            @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT))
                <div class="row">
                    <div class="col-sm-12 pull-right">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="search_user" class="form-control"
                                       onkeyup="searchItem('search_user','reload_data','<?php echo url('search_payroll_user') ?>','{{url('user')}}','<?php echo csrf_token(); ?>')"
                                       name="search_user" placeholder="Search Users" >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <form name="import_excel" id="payrollForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="extra_amount" placeholder="Amount">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="month" >
                                                <option value="">Select Month</option>
                                                @foreach(\App\Helpers\Utility::PAY_INTERVAL as $key => $value)
                                                <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="bonus_deduct_type" >
                                                <option value="">Bonus/Deduction/None</option>
                                                <option value="{{\App\Helpers\Utility::ZERO}}">None</option>
                                                <option value="{{\App\Helpers\Utility::PAYROLL_BONUS}}">Bonus</option>
                                                <option value="{{\App\Helpers\Utility::PAYROLL_DEDUCTION}}">Deduction</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input class="form-control datepicker" name="date" placeholder="Date" >

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clear-fix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class="form-control" name="amount_desc" placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" onclick="processPayroll('kid_checkbox','reload_data','<?php echo url('payroll'); ?>',
                                        '<?php echo url('process_payroll'); ?>','<?php echo csrf_token(); ?>','0','payrollForm');" class="btn btn-success">
                                    <i class="fa fa-check-square-o"></i>Process Salary
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
                @endif
                </div>

                <div class="body table-responsive" id="reload_data">

                    <div class="row clear-fix">
                        @if(count($mainData) >0)
                            Sum of Net Salary Under Process : {{\App\Helpers\Utility::defaultCurrency()}} {{number_format($salarySum)}}
                        @endif
                    </div>

                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>User</th>
                            <th>Salary</th>
                            <th>Total/Net Amount {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>Bonus/Deduction {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>Bonus/Deduction Desc</th>
                            <th>Payroll Status</th>
                            <th>Pay Date</th>
                            <th>Created By</th>
                            <th>Updated By</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Manage</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)
                        <tr>
                            <td scope="row">
                                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>{{$data->userDetail->firstname}}&nbsp;{{$data->userDetail->lastname}} </td>
                            <td>{{$data->salary->salary_name}}</td>
                            <td>{{number_format($data->total_amount)}}</td>
                            <td>{{number_format($data->bonus_deduc)}}</td>
                            <td>{{$data->bonus_deduc_desc}}</td>
                            <td>
                                @if($data->payroll_status == \App\Helpers\Utility::PROCESSING)
                                Processing
                                @else
                                    Paid
                                @endif
                            </td>
                            <td>{{$data->pay_date}}</td>
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
                            <td>
                                <!--<a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_position_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>-->
                            </td>
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
            //page = window.location.hash.replace('#','');
            //getProducts(page);
        });

        $(document).on('click','.pagination a', function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getProducts(page);
            //location.hash = page;
        });

        function getProducts(page){

            var searchVar = $('#search_user').val();
            var searchPage = document.getElementsByClassName('search_user_page');
            var targetPage = '';
            if (searchPage.length > 0) {
                targetPage = '<?php echo url('search_payroll_user'); ?>?searchVar='+searchVar+'&page='+page
                console.log(targetPage);
            }else{
                targetPage = '?page=' + page;
            }

            $.ajax({
                url: targetPage
            }).done(function(data){
                $('#reload_data').html(data);
            });
        }

    </script>

    <script>
        /*==================== PAGINATION =========================*/

        /*$(window).on('hashchange',function(){
            //page = window.location.hash.replace('#','');
            //getSearchData(page);
        });

        $(document).on('click','.pagination a', function(event){
            event.preventDefault();

            /!* $('li').removeClass('active');

             $(this).parent('li').addClass('active');

             var myurl = $(this).attr('href');*!/

            var page=$(this).attr('href').split('page=')[1];
            getSearchData(page);
            //location.hash = page;
        });

        function getSearchData(page){
            var searchVar = $('#search_user').val();
            console.log(searchVar+'slkds');

            $.ajax({
                url: '<?php echo url('search_payroll_user'); ?>?searchVar='+searchVar+'&page='+page
            }).done(function(data){
                $('#reload_data').html(data);
            });
        }
*/
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