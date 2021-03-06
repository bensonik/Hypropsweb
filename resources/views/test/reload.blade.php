<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Manage</th>
        <th>Manage Department(s)</th>
        <th>Manage Test Category(ies)</th>
        <th>Test Name</th>
        <th>Test Details</th>
        <th>Department(s)</th>
        <th>Test Category(ies)</th>
        <th>Created by</th>
        <th>Updated by</th>
        <th>Created at</th>
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
                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_test_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <td>
                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','edit_dept_content','editDeptModal','<?php echo url('edit_test_dept_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <td>
                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','edit_cat_content','editCatModal','<?php echo url('edit_test_category_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->test_name}}</td>
            <td>{{$data->test_desc}}</td>
            <td>
                @if(!empty($data->dept))
                    <table>
                        <tbody>
                        @foreach($data->dept as $dept)
                            <tr><td>{{$dept->dept_name}}</td></tr>

                        @endforeach
                        </tbody>
                    </table>
                @endif
            </td>
            <td>
                @if(!empty($data->testCategory))
                    <table>
                        <tbody>
                        @foreach($data->testCategory as $dept)
                            <tr><td>{{$dept->category_name}}</td></tr>

                        @endforeach
                        </tbody>
                    </table>
                @endif
            </td>
            <td>
                {{$data->user_c->firstname}} {{$data->user_c->lastname}}
            </td>
            <td>
                {{$data->user_u->firstname}} {{$data->user_u->lastname}}
            </td>
            <td>{{$data->created_at}}</td>
            <td>{{$data->updated_at}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>