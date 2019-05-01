<!-- Default Size Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Task List(s)</h4>
            </div>
            <div class="modal-body" style="height:400px; overflow:scroll;">

                <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="body">

                        <div class="row clearfix">
                            <div class="col-sm-4" id="currentTList">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="task_input" name="list_title" placeholder="Task List title">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4" id="formerTList" style="display:none;">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control " id="task_dropdown" name="list_title" placeholder="Task List">
                                            <option value="">Select Task List</option>
                                            @foreach($taskList as $task)
                                                <option value="{{$task->id}}">{{$task->list_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <textarea class="form-control" id="" name="list_desc" placeholder="Task List Details"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <input type="checkbox" class="change_task" name="change_task" value="1" onclick="changeUserT('currentTList','formerTList','change_task','task_input','task_dropdown');" id="change_task" />Check to task(s) to existing task list
                        <hr/>
                        <h4>Add task(s) to list</h4>
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

                                        <input type="hidden" class="" name="user" id="users" />
                                    </div>
                                </div>
                                <ul id="myUL" class="myUL"></ul>
                            </div>
                        </div>
                        <input type="checkbox" class="change_user" value="1" onclick="changeUserT('normal_user','temp_user','change_user','user','users');" id="change_user" />Check to select contract/external user
                        <hr/>

                        <div class="row clearfix">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control task_status" name="task_status" placeholder="Task Status">
                                            <option value="">Select Status</option>
                                            @foreach(\App\Helpers\Utility::TASK_STATUS as $key => $task)
                                                <option value="{{$key}}">{{$task}}</option>
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
                                        <input type="text" class="form-control start_date datepicker" autocomplete="off" name="start_date" placeholder="Start Date">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control end_date datepicker" autocomplete="off" name="end_date" placeholder="End Date">
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

                    <input type="hidden" value="{{$item->id}}" name="project_id" />
                </form>

            </div>
            <div class="modal-footer">
                <button onclick="submitMediaFormClass('createModal','createMainForm','<?php echo url('create_task_list'); ?>','reload_data',
                        '<?php echo url('project/'.$item->id.'/task_list'.\App\Helpers\Utility::authLink('temp_user')); ?>','<?php echo csrf_token(); ?>',['task_title','task_details','user_class','task_status','start_date','end_date','task_priority','time_planned','change_user'])" type="button" class="btn btn-link waves-effect">
                    SAVE
                </button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<!-- Default Size Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
            </div>
            <div class="modal-body" id="edit_content">

            </div>
            <div class="modal-footer">
                <button onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_task_list'); ?>','reload_data',
                        '<?php echo url('project/'.$item->id.'/task_list'.\App\Helpers\Utility::authLink('temp_user')); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
                    SAVE
                </button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<!-- Default Size Tasks Modal -->
<div class="modal fade" id="taskModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Tasks</h4>
                <ul class="header-dropdown m-r--5 pull-right" style="list-style-type: none;">
                    @if($item->project_head == \App\Helpers\Utility::checkAuth('temp_user')->id)
                        <li>
                            <button type="button" onclick="deleteTaskItems('kid_checkbox_task','reload_data','<?php echo url('project/'.$item->id.'/task_list'.\App\Helpers\Utility::authLink('temp_user')); ?>',
                                    '<?php echo url('delete_task_list_item'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>
                @endif
                </ul>
            </div>
            <div class="modal-body" id="task_form" style="overflow-x:scroll; ">

            </div>
            <div class="modal-footer">

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
                @include('includes.project_menu',['item',$item])

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
                                                    Task List(s)
                                                </h2>
                                                <ul class="header-dropdown m-r--5">
                                                    @if($item->project_head == \App\Helpers\Utility::checkAuth('temp_user')->id)
                                                    <li>
                                                        <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                                                    </li>
                                                    <li>
                                                        <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('project/'.$item->id.'/task_list'.\App\Helpers\Utility::authLink('temp_user')); ?>',
                                                                '<?php echo url('delete_task_list'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                                            <i class="fa fa-trash-o"></i>Delete
                                                        </button>
                                                    </li>
                                                    @endif
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
                                                        <th>Project</th>
                                                        <th>Task List</th>
                                                        <th>Description</th>
                                                        <th>No. of Task(s)</th>
                                                        <th>Created by</th>
                                                        <th>Created at</th>
                                                        <th>Updated by</th>
                                                        <th>Updated at</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($mainData as $data)
                                                        <tr>
                                                            <td scope="row">
                                                                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                                            </td>
                                                            @if($item->project_head == \App\Helpers\Utility::checkAuth('temp_user')->id)
                                                            <td>
                                                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_task_list_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                                            </td>
                                                            @else
                                                             <td></td>
                                                            @endif
                                                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                                            <td>{{$data->project->project_name}}</td>
                                                            <td>{{$data->list_name}}</td>
                                                            <td>{{$data->list_desc}}</td>
                                                            <td class="btn-link">
                                                                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','task_form','taskModal','<?php echo url('task_form') ?>','<?php echo csrf_token(); ?>')"><span class="badge bg-cyan ">{{$data->count_task}} task(s)</span> <span class="btn-link">View</span></a>
                                                            </td>
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

                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                                <div class="task pagination pull-left">
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

        var postVars = new FormData(form);
        postVars.append('token',token);
        appendClassToPost(classList,postVars);
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

    function deleteTaskItems(klass,reloadId,reloadUrl,submitUrl,token) {
        var items = group_val(klass);
        if (items.length > 0){
            swal({
                        title: "Are you sure you want to delete?",
                        text: "You will not be able to recover this data entry!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel delete!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            deleteEntry(klass, reloadId, reloadUrl, submitUrl, token);
                            hideCheckedClassItems(klass);
                            swal("Deleted!", "Your item(s) has been deleted.", "success");
                        } else {
                            swal("Delete Cancelled", "Your data is safe :)", "error");
                        }
                    });

        }else{
            alert('Please select an entry to continue');
        }

    }


</script>

<script>
    /*==================== PAGINATION =========================*/

    $(window).on('hashchange',function(){
        //page = window.location.hash.replace('#','');
        //getProducts(page);
    });

    /*$(document).on('click','#task .pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getProducts(page);
        location.hash = page;
    });*/

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
