@extends('layouts.app')

@section('content')

    <!-- Bordered Table -->

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Project
                    </h2>
                    <ul class="header-dropdown m-r--5">

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
                <div class="body table-responsive" id="">

                    <!-- TABS -->

                    <div class=""> <!-- style="overflow:hidden" -->

                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-12" style="overflow:auto">
                                <div id="MyAccountsTab" class="tabbable tabs-left">
                                    <!-- Account selection for desktop - I -->
                                    <ul  class="nav nav-tabs col-md-2 ">
                                        <li  class="active">
                                            <div data-target="#overview" data-toggle="tab">
                                                <div>
                                                    <span class="account-type">Overview</span><br/>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div data-target="#timesheet" onclick="fetchHtml3(dataId,displayId,submitUrl,token,type)" data-toggle="tab">
                                                <div class="ellipsis">
                                                    <span class="account-type">Timesheet</span><br/>
                                                    <span class="account-amount">{{$item->timesheet}}</span><br/>
                                                    <a href="#" class="account-link">Entries</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div data-target="#milestone" onclick="fetchHtml3('{{$item->id}}','milestone1','<?php echo url('edit_company_form') ?>','<?php echo csrf_token(); ?>')" data-toggle="tab">
                                                <div>
                                                    <span class="account-type">Milestone</span><br/>
                                                    <span class="account-amount">{{$item->milestone}}</span><br/>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div data-target="#task_list" data-toggle="tab">
                                                <div>
                                                    <span class="account-type">Task List</span><br/>
                                                    <span class="account-amount">{{$item->task_list}}</span><br/>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div data-target="#task" data-toggle="tab">
                                                <div>
                                                    <span class="account-type">Task</span><br/>
                                                    <span class="account-amount">{{$item->task}}</span><br/>
                                                    <a href="#" class="account-link">Assigned</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="">
                                            <div data-target="#team_members" data-toggle="tab">
                                                <div class="ellipsis">
                                                    <span class="account-type">Team Members</span><br/>
                                                    <span class="account-amount">{{$item->members}}</span><br/>
                                                    <a href="#" class="account-link">Members</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div data-target="#requests" data-toggle="tab">
                                                <div>
                                                    <span class="account-type">Requests</span><br/>
                                                    <span class="account-amount">{{$item->requests}}</span><br/>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div data-target="#issues" data-toggle="tab">
                                                <div>
                                                    <span class="account-type">Issues</span><br/>
                                                    <span class="account-amount">{{$item->issues}}</span><br/>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div data-target="#change_log" data-toggle="tab">
                                                <div>
                                                    <span class="account-type">Change Log</span><br/>
                                                    <span class="account-amount">{{$item->change_log}}</span><br/>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div data-target="#decision" data-toggle="tab">
                                                <div>
                                                    <span class="account-type">Decision</span><br/>
                                                    <span class="account-amount">{{$item->decision}}</span><br/>
                                                    <a href="#" class="account-link">taken</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="">
                                            <div data-target="#risk" data-toggle="tab">
                                                <div class="ellipsis">
                                                    <span class="account-type">Risk</span><br/>
                                                    <span class="account-amount">{{$item->risk}}</span><br/>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div data-target="#assumption" data-toggle="tab">
                                                <div>
                                                    <span class="account-type">Assumption</span><br/>
                                                    <span class="account-amount">{{$item->assump}}</span><br/>
                                                    <a href="#" class="account-link">Constraint</a><br/>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div data-target="#deliverable" data-toggle="tab">
                                                <div>
                                                    <span class="account-type">Deliverable</span><br/>
                                                    <span class="account-amount">{{$item->deliverable}}</span><br/>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div data-target="#documents" data-toggle="tab">
                                                <div>
                                                    <span class="account-type">Documents</span><br/>
                                                    <span class="account-amount">{{$item->documents}}</span><br/>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="">
                                            <div data-target="#lesson_learnt" data-toggle="tab">
                                                <div class="ellipsis">
                                                    <span class="account-type">Lesson Learnt</span><br/>
                                                    <span class="account-amount">{{$item->lesson_learnt}}</span><br/>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div data-target="#status_report" data-toggle="tab">
                                                <div>
                                                    <span class="account-type">Status Report</span><br/>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div data-target="#custom_report" data-toggle="tab">
                                                <div>
                                                    <span class="account-type">Custom Report</span><br/>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                    <div class="tab-content col-md-10" style="overflow-x:scroll;">
                                        <div class="tab-pane active" id="overview"><!--style="padding-left: 60px; padding-right:100px"-->
                                            <div class="col-md-offset-1">
                                                <div class="row" style="line-height: 14px; margin-bottom: 34.5px">

                                                    <table class="table table-responsive table-bordered table-hover table-striped">
                                                        <thead>
                                                        <th></th>
                                                        <th></th>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>Project Name</td>
                                                            <td>{{$item->project_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Project Leader</td>
                                                            <td>{{$item->pro_head->title}} {{$item->pro_head->firstname}} {{$item->pro_head->lastname}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Start Date</td>
                                                            <td>{{$item->start_date}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>End Date</td>
                                                            <td>{{$item->end_date}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Customer/Client</td>
                                                            <td>{{$item->customer->name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Budget</td>
                                                            <td>{{\App\Helpers\Utility::defaultCurrency()}} {{number_format($item->budget)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Billing Method</td>
                                                            <td>{{$item->billing->bill_name}}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>

                                                    <p>{{$item->project_desc}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="timesheet">
                                            <div class="col-md-offset-1">
                                                <div class="row" style="line-height: 14px; margin-bottom: 34.5px" id="timesheet1">
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="milestone">
                                            <div class="col-md-offset-1">
                                                <div class="row" style="line-height: 14px; margin-bottom: 34.5px" id="milestone1">
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="task_list">
                                            <div class="col-md-offset-1">
                                                <div class="row" style="line-height: 14px; margin-bottom: 34.5px" id="task_list1">
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="task">
                                            <div class="col-md-offset-1">
                                                <div class="row" style="line-height: 14px; margin-bottom: 34.5px" id="task1">
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="team_members">
                                            <div class="col-md-offset-1">
                                                <div class="row" style="line-height: 14px; margin-bottom: 34.5px" id="team_members1">
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="requests">
                                            <div class="col-md-offset-1">
                                                <div class="row" style="line-height: 14px; margin-bottom: 34.5px" id="requests1">
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="issues">
                                            <div class="col-md-offset-1">
                                                <div class="row" style="line-height: 14px; margin-bottom: 34.5px" id="issues1">
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="requests">
                                            <div class="col-md-offset-1">
                                                <div class="row" style="line-height: 14px; margin-bottom: 34.5px" id="requests1">
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="change_log">
                                            <div class="col-md-offset-1">
                                                <div class="row" style="line-height: 14px; margin-bottom: 34.5px" id="change_log1">
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="decision">
                                            <div class="col-md-offset-1">
                                                <div class="row" style="line-height: 14px; margin-bottom: 34.5px" id="decision1">
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="risk">
                                            <div class="col-md-offset-1">
                                                <div class="row" style="line-height: 14px; margin-bottom: 34.5px" id="risk1">
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="assumption">
                                            <div class="col-md-offset-1">
                                                <div class="row" style="line-height: 14px; margin-bottom: 34.5px" id="assumption1">
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="deliverable">
                                            <div class="col-md-offset-1">
                                                <div class="row" style="line-height: 14px; margin-bottom: 34.5px" id="deliverable1">
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="documents">
                                            <div class="col-md-offset-1">
                                                <div class="row" style="line-height: 14px; margin-bottom: 34.5px" id="documents1">
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="lesson_learnt">
                                            <div class="col-md-offset-1">
                                                <div class="row" style="line-height: 14px; margin-bottom: 34.5px" id="lesson_learnt1">
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="status_report">
                                            <div class="col-md-offset-1">
                                                <div class="row" style="line-height: 14px; margin-bottom: 34.5px" id="status_report1">
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="custom_report">
                                            <div class="col-md-offset-1">
                                                <div class="row" style="line-height: 14px; margin-bottom: 34.5px" id="custom_report1">
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Account selection for desktop - F -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- END OF TABS -->

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