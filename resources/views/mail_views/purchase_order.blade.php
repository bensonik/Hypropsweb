@extends('mail_views.mail_layout')

@section('content')

    <table class="table table-responsive">
        <thead></thead>
        <tbody>
        <tr>
            <td>Vendor: {{$data['po']->vendor->name}}</td>
            <td>Vendor Invoice No.:{{$data['po']->vendor_invoice_no}}</td>
            <td>Billing Address: {{$data['po']->vendor->address}}</td>
        </tr>
        <tr>
            <td>PO Number: {{$data['po']->po_number}}</td>
            <td>Ship to city: {{$data['po']->ship_to_city}}</td>
            <td>Ship to address: {{$data['po']->ship_to_address}}</td>

        </tr>
        <tr>
            <td>Message:</td>
            <td></td>
        </tr>
        </tbody>
    </table><hr/>

    <table class="table table-responsive">
        <thead>
            <td>Account Name</td>
            <td>Description</td>
            <td>Rate</td>
            <td>Tax(%):</td>
            <td>Tax Amount</td>
            <td>Discount(%):</td>
            <td>Discount Amount</td>
            <td>Sub Total</td>
        </thead>
        <tbody>

        @foreach($data['poData'] as $data)

            @if($data->account_id != '')
                <tr>
                    <td>{{$data->account->acct_name}}</td>
                    <td>{{$data->po_desc}}</td>
                    <td>{{$data->unit_cost_trans}}</td>
                    <td>{{$data->tax_perct}}</td>
                    <td>{{$data->tax_amount_trans}}</td>
                    <td>{{$data->discount_perct}}</td>
                    <td>{{$data->discount_amount_trans}}</td>
                    <td>{{$data->extended_amount_trans}}</td>
                </tr>
            @endif

        @endforeach

        </tbody>
    </table><hr/>

    <table class="table table-responsive">
        <thead>
        <td>Item</td>
        <td>Description</td>
        <td>Quantity</td>
        <td>Unit Measure</td>
        <td>Rate</td>
        <td>Tax(%):</td>
        <td>Tax Amount</td>
        <td>Discount(%):</td>
        <td>Discount Amount</td>
        <td>Sub Total</td>
        </thead>
        <tbody>
        @foreach($data['poData'] as $data)

            @if($data->account_id != '')
                <tr>
                    <td>{{$data->inventory->acct_name}}</td>
                    <td>{{$data->po_desc}}</td>
                    <td>{{$data->quantity}}</td>
                    <td>{{$data->unit_cost_trans}}</td>
                    <td>{{$data->tax_perct}}</td>
                    <td>{{$data->tax_amount_trans}}</td>
                    <td>{{$data->discount_perct}}</td>
                    <td>{{$data->discount_amount_trans}}</td>
                    <td>{{$data->extended_amount_trans}}</td>
                </tr>
            @endif

        @endforeach
        </tbody>
    </table><hr/>
    <?php $totalExclTax =  $data['po']->trans_total - $data['po']->tax_trans; ?>
    <table class="table table-responsive">
        <thead>

        </thead>
        <tbody>
        <tr>
            <td>Total Tax (%)</td>
            <td>{{$data['po']->tax_perct}}</td>
        </tr>
        <tr>
            <td>Total Tax Amount</td>
            <td>{{$data['po']->tax_trans}}</td>
        </tr>
        <tr>
            <td>Total Discount (%)</td>
            <td>{{$data['po']->discount_perct}}</td>
        </tr>
        <tr>
            <td>Total Discount Amount</td>
            <td>{{$data['po']->discount_trans}}</td>
        </tr>
        <tr>
            <td>Grand Total (Excl. Tax)</td>
            <td>{{$totalExclTax}}</td>
        </tr>
        <tr>
            <td>Grand Total</td>
            <td>{{$data['po']->trans_total}}</td>
        </tr>
        </tbody>
    </table><hr/>


@endsection