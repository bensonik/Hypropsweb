<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>Manage</th>
        <th>PO Number</th>
        <th>Vendor Invoice Number</th>
        <th>Vendor</th>
        <th>Post Date</th>
        <th>Due date</th>
        <th>Ship to Contact</th>
        <th>PO Status</th>
        <th>Assigned User</th>
        <th>Sum Total</th>
        <th>Sum Total {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Created by</th>
        <th>Updated by</th>

    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

            </td>
            <td>
                <a style="cursor: pointer;" onclick="editTransactForm('{{$data->id}}','edit_content','<?php echo url('edit_po_form') ?>','<?php echo csrf_token(); ?>','foreign_amount_edit','<?php echo url('vendor_customer_currency') ?>','vendorDisplay')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->po_number}}</td>
            <td>{{$data->vendor_invoice_no}}</td>
            <td>{{$data->vendorCon->name}}</td>
            <td>{{$data->post_date}}</td>
            <td>{{$data->due_date}}</td>
            <td>{{$data->ship_to_contact}}</td>
            <td>{{$data->purchase_status}}</td>
            <td>{{$data->UserDetail->firstname}} &nbsp; {{$data->userDetail->lastname}}</td>
            <td>({{$data->currency->code}}){{$data->currency->symbol}}&nbsp;{{$data->sum_total}}</td>
            <td>{{$data->trans_total}}</td>
            <td>{{$data->user_c->firstname}} &nbsp;{{$data->user_c->lastname}} </td>
            <td>{{$data->user_u->firstname}} &nbsp;{{$data->user_u->lastname}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
            <input type="hidden" id="vendorDisplay" value="{{$data->vendor}}">

        </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>