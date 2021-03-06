<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Manage</th>
        <th>Account Number</th>
        <th>Account Name</th>
        <th>Account Category</th>
        <th>Detail Type</th>
        <th>Default Account Balance {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Foreign Account Balance </th>
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
            <td>
                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_account_chart_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->acct_no}}</td>
            <td>{{$data->acct_name}}</td>
            <td>{{$data->category->category_name}}</td>
            <td>{{$data->detail->detail_type}}</td>
            <td>{{$data->normal_balance}}</td>
            <td>({{$data->chartCurr->code}}){{$data->chartCurr->symbol}}{{$data->foreign_balance}}</td>
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

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>