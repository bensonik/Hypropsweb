<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Manage</th>
        <th>Project</th>
        <th>Full Name</th>
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
            @if($item->project_head != \App\Helpers\Utility::checkAuth('temp_user')->id || in_array(\App\Helpers\Utility::checkAuth('temp_user')->role,\App\Helpers\Utility::TOP_USERS))
            <td>
                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_project_team_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                </td>
            @else
                <td></td>
        @endif
        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->project->project_name}}</td>
            <td>
                @if(!empty($data->user_id))
                    {{$data->member->firstname}}&nbsp;{{$data->member->lastname}}
                @else
                    {{$data->extUser->firstname}}&nbsp;{{$data->extUser->lastname}}
                @endif
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