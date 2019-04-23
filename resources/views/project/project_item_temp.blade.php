@extends('layouts.temp_app')

@section('content')


    <div class=""> <!-- style="overflow:hidden" -->

        <div class="clearfix"></div>
        <div class="row ">
            <div class="col-md-12" style="overflow:auto">
                <div id="MyAccountsTab" class="tabbable tabs-left">
                    <!-- Account selection for desktop - I -->
                    <ul  class="nav nav-tabs col-md-2 ">
                        <li  class="active" onclick="navigatePage('<?php echo url('project_item/'.$item->id) ?>')">
                            <div data-target="#overview" data-toggle="tab">
                                <div>
                                    <span class="account-type">Overview</span><br/>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div data-target="#timesheet" onclick="fetchHtml3()" data-toggle="tab">
                                <div class="ellipsis">
                                    <span class="account-type">Timesheet</span><br/>
                                    <span class="account-amount">{{$item->timesheet}}</span><br/>
                                    <a href="#" class="account-link">Entries</a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div data-target="#milestone" data-toggle="tab">
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
                            <div data-target="#task" onclick="navigatePage('<?php echo url('project/'.$item->id.'/task') ?>')" data-toggle="tab">
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

                    </div>
                    <!-- Account selection for desktop - F -->
                </div>
            </div>
        </div>
    </div>

    <!-- END OF TABS -->

    <script>
        /*==================== PAGINATION =========================*/

        $(window).on('hashchange',function(){
            //page = window.location.hash.replace('#','');
            //getProducts(page);
        });

        $(document).on('click','#task .pagination a', function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getProducts(page);
            location.hash = page;
        });

        function getProducts(page){

            $.ajax({
                url: '?page=' + page
            }).done(function(data){
                $('#reload_task').html(data);
            });
        }

    </script>

    <script>
        $(function() {
            $( ".datepicker2" ).datepicker({
                /*changeMonth: true,
                 changeYear: true*/
            });
        });
    </script>

@endsection