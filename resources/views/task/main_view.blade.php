@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Task(s)</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control task_title" name="task_title" placeholder="Task title">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea type="text" class="form-control task_details" name="task" placeholder="Task Details"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4" id="normal_user">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user','myUL1','{{url('default_select')}}','default_search','user');" name="select_user" placeholder="Select User">

                                            <input type="hidden" class="user_class" name="user" id="user" />
                                        </div>
                                    </div>
                                    <ul id="myUL1" class="myUL"></ul>
                                </div>

                                <div class="col-sm-4" id="temp_user" style="display:none;">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_users" onkeyup="searchOptionList('select_users','myUL','{{url('default_select')}}','default_search_temp','users');" name="select_user" placeholder="Select External/Contract User">

                                            <input type="hidden" class="user_class" name="user" id="users" />
                                        </div>
                                    </div>
                                    <ul id="myUL" class="myUL"></ul>
                                </div>
                            </div>
                            <input type="checkbox" value="1" onclick="changeUserT('normal_user','temp_user','change_user');" id="change_user" />Check to select contract/external user
                            <hr/>

                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control task_status" name="task_status" placeholder="Task Status">
                                                <option value="">Select Status</option>
                                                @foreach(\App\Helpers\Utility::TASK_STATUS as $task)
                                                    <option value="{{$task}}">{{$task}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control task_priority" name="task_priority" >
                                                <option value="">Select Priority</option>
                                                @foreach(\App\Helpers\Utility::TASK_PRIORITY as $task)
                                                    <option value="{{$task}}">{{$task}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control time_planned" name="time_planned" placeholder="Time(hrs) Planned">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control start_date datepicker2" autocomplete="off" name="start_date" placeholder="Start Date">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control end_date datepicker2" autocomplete="off" name="end_date" placeholder="End Date">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4" id="hide_button">
                                    <div class="form-group">
                                        <div onclick="addMore('add_more','hide_button','1','<?php echo URL::to('add_more'); ?>','task','hide_button');">
                                            <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>

                            <div id="add_more"></div>

                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaFormClass('createModal','createMainForm','<?php echo url('create_task'); ?>','reload_data',
                            '<?php echo url('task_reload'); ?>','<?php echo csrf_token(); ?>',['task_title','task_details','user_class','task_status','start_date','end_date','task_priority','time_planned'])" type="button" class="btn btn-link waves-effect">
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
                    <button onclick="submitMediaFormClass('editModal','editMainForm','<?php echo url('edit_task'); ?>','reload_task',
                            '<?php echo url('task_reload'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <div class=""> <!-- style="overflow:hidden" -->

        <div class="clearfix"></div>
        <div class="row ">
            <div class="col-md-12" style="overflow:auto">
                <div id="MyAccountsTab" class="tabbable tabs-left">
                    <!-- Account selection for desktop - I -->
                    <ul  class="nav nav-tabs col-md-2 ">
                        <li  class="" onclick="navigatePage('<?php echo url('project_item/'.$item->id) ?>')">
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
                        <li class="active">
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

                    <div class="tab-content col-md-10" style="overflow-x:auto;">
                        <div class="tab-pane active" id="overview"><!--style="padding-left: 60px; padding-right:100px"-->
                            <div class="col-md-offset-1">
                                <div class="row" style="line-height: 14px; margin-bottom: 34.5px;">


                                <!-- Bordered Table -->
                                    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Task(s)
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_task','<?php echo url('reload_task'); ?>',
                                    '<?php echo url('delete_task'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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
                <div class="body table-responsive" id="reload_task">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Project</th>
                            <th>Task</th>
                            <th>Details</th>
                            <th>Assigned User</th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Duration</th>
                            <th>Priority</th>
                            <th>Time Planned(hrs)</th>
                            <th>Time Log(hrs)</th>
                            <th>Created by</th>
                            <th>Created at</th>
                            <th>Updated by</th>
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
                                <td>{{$data->project->project_name}}</td>
                                <td>{{$data->task}}</td>
                                <td>{{$data->task_desc}}</td>
                                <td>
                                    @if(!empty($data->assigned_user))
                                        {{$data->assignee->firstname}}&nbsp;{{$data->assignee->lastname}}
                                    @else
                                        {{$data->extUser->firstname}}&nbsp;{{$data->extUser->lastname}}
                                    @endif
                                </td>
                                <td>{{$data->task_status}}</td>
                                <td>{{$data->start_date}}</td>
                                <td>{{$data->end_date}}</td>
                                <td></td>
                                <td>{{$data->work_hours}}</td>
                                <td></td>
                                <td>
                                    @if($data->created_by != '0')
                                        {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                                    @endif
                                </td>
                                <td>{{$data->created_at}}</td>
                                <td>
                                    @if($data->updated_by != '0')
                                        {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                                    @endif
                                </td>
                                <td>{{$data->updated_at}}</td>


                                <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                                <td>
                                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_task_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="task pagination pull-right">
                        {!! $mainData->render() !!}
                    </div>

                </div>

            </div>

        </div>
    </div>

                                <!-- #END# Bordered Table -->

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

        //SUBMIT FORM WITH A FILE
        function submitMediaFormClass(formModal,formId,submitUrl,reload_id,reloadUrl,token,classList){
            var form_get = $('#'+formId);
            var form = document.forms.namedItem(formId);
            var ckInput = CKEDITOR.instances[ckInputId].getData();

            var postVars = new FormData(form);
            postVars.append('token',token);
            appendClassToPost(classList,postVars);
            console.log(JSON.stringify(postVars));
            $('#loading_modal').modal('show');
            $('#'+formModal).modal('hide');
            /*$('#'+formModal).on("hidden.bs.modal", function () {
             $('#edit_content').html('');
             });*/
            sendRequestMediaForm(submitUrl,token,postVars)
            ajax.onreadystatechange = function(){
                if(ajax.readyState == 4 && ajax.status == 200) {
                    $('#loading_modal').modal('hide');
                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if(message2 == 'fail'){

                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(rollback.message);

                        var messageError = swalFormError(serverError);
                        swal("Error",messageError, "error");

                    }else if(message2 == 'saved'){

                        var successMessage = swalSuccess('Data saved successfully');
                        swal("Success!", successMessage, "success");
                        //location.reload();

                    }else{

                        //alert(message2);
                        console.log(message2)
                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");

                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    reloadContent(reload_id,reloadUrl);
                }
            }

        }


    </script>

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