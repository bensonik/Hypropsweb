<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

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
                        <textarea type="text" class="form-control task_details" name="task_details" placeholder="Task Details"></textarea>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <?php $divId = ($edit->assigned_user != '') ? 'norm_user_edit': 'temp_user_edit'; ?>
                <?php $changeVal = ($edit->assigned_user != '') ? '1': '0'; ?>
                <?php $checkStatus = ($edit->assigned_user != '') ? '': 'checked'; ?>

                <div class="form-group" id="{{$divId}}">
                    <div class="form-line">
                        @if($edit->assigned_user != '')
                            <input type="text" class="form-control" value="{{$edit->assignee->firstname}} {{$edit->assignee->lastname}}" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user_edit','myUL1_edit','{{url('default_select')}}','default_search','user_edit');" name="select_user" placeholder="Select User">
                            <input type="hidden" value="{{$edit->assigned_user}}" class="user_class" name="user" id="user_edit" />
                        @else
                            <input type="text" class="form-control" value="{{$edit->extUser->firstname}} {{$edit->extUser->lastname}}" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user_edit','myUL1_edit','{{url('default_select')}}','default_search','user_edit');" name="select_user" placeholder="Select User">
                            <input type="hidden" value="{{$edit->temp_user}}" class="user_class" name="user" id="user_edit" />
                        @endif


                    </div>
                </div>
                <ul id="myUL1_edit" class="myUL"></ul>
            </div>

            @if($edit->assigned_user != '')

                <div class="col-sm-4" id="temp_user_edit" style="display:none;">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" autocomplete="off" id="select_users_edit" onkeyup="searchOptionList('select_users_edit','myUL_edit','{{url('default_select')}}','default_search_temp','users_edit');" name="select_user" placeholder="Select External/Contract User">

                            <input type="hidden" class="" name="user" id="users_edit" />
                        </div>
                    </div>
                    <ul id="myUL_edit" class="myUL"></ul>
                </div>

            @else

                <div class="col-sm-4" id="normal_user_edit" style="display:none;">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" autocomplete="off" id="select_user_edit" onkeyup="searchOptionList('select_user_edit','myUL1_edit','{{url('default_select')}}','default_search','user_edit');" name="select_user" placeholder="Select User">

                            <input type="hidden" class="user_class" name="user" id="user_edit" />
                        </div>
                    </div>
                    <ul id="myUL1" class="myUL"></ul>
                </div>

            @endif

        </div>
        <input type="checkbox" class="change_user" {{$checkStatus}} value="{{$changeVal}}" onclick="changeUserT('normal_user_edit','temp_user_edit','change_user_edit','user_edit','users_edit');" id="change_user_edit" />Check to select contract/external user
        <hr/>

        <div class="row clearfix">

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control task_status" name="task_status" placeholder="Task Status">
                            <option value="{{$edit->task_status}}">Select Status</option>
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
                            <option value="{{$edit->task_priority}}">Select Priority</option>
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

        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text"  class="form-control start_date datepicker1" name="start_date" placeholder="Start Date">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control end_date datepicker1" name="end_date" placeholder="End Date">
                    </div>
                </div>
            </div>

        </div>
        <hr/>

    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>

<script>
    $(function() {
        $( ".datepicker1" ).datepicker({
            /*changeMonth: true,
             changeYear: true*/
        });
    });
</script>