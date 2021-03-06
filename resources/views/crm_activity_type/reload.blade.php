<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>View</th>
        <th>Name</th>
        <th>Created by</th>
        <th>Updated by</th>
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
            <td>
                <a style="cursor: pointer;" onclick="readDetails('{{$data->name}}','{!!$data->summary!!}','news_title_id','news_detail_id','news_modal')">See Details</a>

            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->name}}</td>
            <td>
                {{$data->user_c->firstname}} {{$data->user_c->lastname}}
            </td>
            <td>
                {{$data->user_u->firstname}} {{$data->user_u->lastname}}
            </td>
            <td>{{$data->created_at}}</td>
            <td>{{$data->updated_at}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
            @if(Auth::user()->id == $data->created_by)
                <td>
                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_crm_activity_type_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>

                </td>
            @else
                <td></td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>