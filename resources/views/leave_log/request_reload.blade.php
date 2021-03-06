<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        {{--<th>Manage</th>--}}
        <th>Description</th>
        <th>Edited</th>
        <th>Leave Type</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Duration</th>
        <th>Requested by</th>
        <th>Department</th>
        <th>Approval Status</th>
        <th>Approved by</th>
        <th>Created by</th>
        <th>Updated by</th>
        <th>Created at</th>
        <th>Updated at</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)

        @if($data->complete_status == 0)
            @if($data->approval_view == 1 && $data->deny_reason == '')
                <tr>
                    <td scope="row">
                        <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                    </td>
                <!--<td>
                                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_leave_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                </td>-->
                    <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                    <td>{{$data->leave_desc}}</td>
                    <td>
                        @if($data->edit_request != '')
                            <?php $edited = json_decode($data->edit_request,true); ?>
                            @foreach($edited as $key => $val)
                                {{$key}} : {{$val}}<br>
                            @endforeach
                        @endif
                    </td>
                    <td>{{$data->leaveType->leave_type}}</td>
                    <td>{{$data->start_date}}</td>
                    <td>{{$data->end_date}}</td>
                    <td>{{$data->duration}} &nbsp; day(s)</td>
                    <td>{{$data->requestUser->firstname}} &nbsp; {{$data->requestUser->lastname}}</td>
                    <td>{{$data->department->dept_id}}</td>
                    <td class="{{\App\Helpers\Utility::statusIndicator($data->approval_status)}}">
                        @if($data->approval_status === 1)
                            Request Approved
                        @endif
                        @if($data->approval_status === 0)
                            Processing Request
                        @endif
                        @if($data->approval_status === 2)
                            Request Denied
                        @endif
                    </td>
                    <td>
                        @if($data->approved_users != '')
                            <table class="table table-bordered table-responsive">
                                <thead>
                                <th>Name</th>
                                <th>Reason</th>
                                </thead>
                                <tbody>
                                @foreach($data->approved_by as $users)
                                    <tr>
                                        <td>{{$users->firstname}} &nbsp; {{$users->lastname}}</td>
                                        <td>Approved</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    @if($data->deny_reason != '')
                                        <td>{{$data->denyUser->firstname}} &nbsp; {{$data->denyUser->lastname}}</td>
                                        <td>Denied: {{$data->deny_reason}}</td>
                                    @endif
                                </tr>
                                </tbody>
                            </table>
                        @endif
                    </td>
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
            @endif
        @endif
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>