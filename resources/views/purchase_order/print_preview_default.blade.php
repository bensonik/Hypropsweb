@extends('layouts.letter_head')

@section('content')

    <table class="table-bordered table-hover table-striped">
        <thead></thead>
        <tbody>
        <tr>
            <td>Vendor: {{$po->vendorCon->name}}</td>
            <td>Vendor Invoice No.:{{$po->vendor_invoice_no}}</td>
            <td>Billing Address: {{$po->vendorCon->address}}</td>
        </tr>
        <tr>
            <td>PO Number: {{$po->po_number}}</td>
            <td>Ship to city: {{$po->ship_to_city}}</td>
            <td>Ship to address: {{$po->ship_address}}</td>

        </tr>

        </tbody>
    </table><hr/>

    <table class="table-bordered table-hover table-striped">
        <thead>
        <td>Account Name</td>
        <td>Description</td>
        <td>Rate ({{$currency}})</td>
        <td>Tax(%):</td>
        <td>Tax Amount ({{$currency}})</td>
        <td>Discount(%):</td>
        <td>Discount Amount ({{$currency}})</td>
        <td>Sub Total ({{$currency}})</td>
        </thead>
        <tbody>

        @foreach($poData as $data)

            @if($data->account_id != '')
                <tr>
                    <td>{{$data->account->acct_name}}</td>
                    <td>{{$data->po_desc}}</td>
                    <td>{{$data->unit_cost}}</td>
                    <td>{{$data->tax_perct}}</td>
                    <td>{{$data->tax_amount}}</td>
                    <td>{{$data->discount_perct}}</td>
                    <td>{{$data->discount_amount}}</td>
                    <td>{{$data->extended_amount}}</td>
                </tr>
            @endif

        @endforeach

        </tbody>
    </table><hr/>

    <table class="table-bordered table-hover table-striped">
        <thead>
        <td>Item</td>
        <td>Description</td>
        <td>Quantity</td>
        <td>Unit Measure</td>
        <td>Rate ({{$currency}})</td>
        <td>Tax(%):</td>
        <td>Tax Amount ({{$currency}})</td>
        <td>Discount(%):</td>
        <td>Discount Amount ({{$currency}})</td>
        <td>Sub Total ({{$currency}})</td>
        </thead>
        <tbody>
        @foreach($poData as $data)

            @if($data->item_id != '')
                <tr>
                    <td>{{$data->inventory->item_name}} ({{$data->inventory->item_no}})</td>
                    <td>{{$data->po_desc}}</td>
                    <td>{{$data->quantity}}</td>
                    <td>{{$data->unit_measurement}}</td>
                    <td>{{$data->unit_cost}}</td>
                    <td>{{$data->tax_perct}}</td>
                    <td>{{$data->tax_amount}}</td>
                    <td>{{$data->discount_perct}}</td>
                    <td>{{$data->discount_amount}}</td>
                    <td>{{$data->extended_amount}}</td>
                </tr>
            @endif

        @endforeach
        </tbody>
    </table><hr/>
    <?php $totalExclTax =  $po->sum_total + $po->tax_total; ?>
    <table class="table-bordered table-hover table-striped pull-right">
        <thead>

        </thead>
        <tbody>
        <tr>
            <td>Total Tax (%)</td>
            <td>{{$po->tax_perct}}</td>
        </tr>
        <tr>
            <td>Total Tax Amount ({{$currency}})</td>
            <td>{{$po->tax_total}}</td>
        </tr>
        <tr>
            <td>Total Discount (%)</td>
            <td>{{$po->discount_perct}}</td>
        </tr>
        <tr>
            <td>Total Discount Amount ({{$currency}})</td>
            <td>{{$po->discount_total}}</td>
        </tr>
        <tr>
            <td>Grand Total (Excl. Tax)</td>
            <td>{{$totalExclTax}}</td>
        </tr>
        <tr>
            <td>Grand Total ({{$currency}})</td>
            <td>{{$po->sum_total}}</td>
        </tr>
        </tbody>
    </table><hr/>


@endsection