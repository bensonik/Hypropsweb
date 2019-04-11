@extends('layouts.letter_head')

@section('content')

    <table class="table-bordered table-hover table-striped">
        <thead></thead>
        <tbody>
        <tr>
            <td>RFQ Number: {{$po->rfq_no}}</td>
        </tr>

        </tbody>
    </table><hr/>

    <table class="table-bordered table-hover table-striped">
        <thead>
        <td>Account Name</td>
        <td>Description</td>
        <td>Rate </td>
        <td>Tax(%):</td>
        <td>Tax Amount </td>
        <td>Discount(%):</td>
        <td>Discount Amount </td>
        <td>Sub Total </td>
        </thead>
        <tbody>

        @foreach($poData as $data)

            @if($data->account_id != '')
                <tr>
                    <td>{{$data->account->acct_name}}</td>
                    <td>{{$data->rfq_desc}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
        <td>Rate </td>
        <td>Tax(%):</td>
        <td>Tax Amount </td>
        <td>Discount(%):</td>
        <td>Discount Amount </td>
        <td>Sub Total </td>
        </thead>
        <tbody>
        @foreach($poData as $data)

            @if($data->item_id != '')
                <tr>
                    <td>{{$data->inventory->item_name}} ({{$data->inventory->item_no}})</td>
                    <td>{{$data->rfq_desc}}</td>
                    <td>{{$data->quantity}}</td>
                    <td>{{$data->unit_measurement}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endif

        @endforeach
        </tbody>
    </table><hr/>


@endsection