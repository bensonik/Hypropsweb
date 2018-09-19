

<div class=" table-responsive" id="reload_data_warehouse">

<input type="hidden" id="whseId" value="{{$itemId}}">
<table class="table table-bordered table-hover table-striped" id="main_table_warehouse">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox_warehouse');" id="parent_check_warehouse"
                   name="check_all" class="" />

        </th>
        <th>Item Name</th>
        <th>Warehouse</th>
        <th>Zone</th>
        <th>Bin</th>
        <th>Quantity Received</th>
        <th>Quantity Remaining</th>
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
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox_warehouse" />

            </td>

            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->

            <td>{{$data->inventory->item_name}} </td>
            <td>{{$data->warehouse->name}}</td>
            <td>{{$data->to_zone->name}}</td>
            <td>{{$data->to_bin->code}}</td>
            <td>{{$data->qty_received}}</td>
            <td>{{$data->qty_remaining}}</td>
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
    @endforeach
    </tbody>
</table>

    <div class="warehouse_pagination pull-right">
        {!! $mainData->render() !!}
    </div>

</div>

