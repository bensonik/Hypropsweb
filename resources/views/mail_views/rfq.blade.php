@extends('mail_views.mail_layout')

@section('content')

    <table class="table table-responsive">
        <thead></thead>
        <tbody>
        <tr>
            <td>RFQ Number: {{$data['rfq']->rfq_no}}</td>
            <td>RFQ Due Date: {{$data['rfq']->due_date}}</td>
        </tr>
        <tr>
            <td>Message:  {{$data['rfq']->message}}</td>
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

        @foreach($data['rfqData'] as $data)

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
        @foreach($data['rfqData'] as $data)

            @if($data->item_id != '')
                <tr>
                    <td>{{$data->inventory->item_name}} (</td>
                    <td>{{$data->rfq_desc}}</td>
                    <td>{{$data->quantity}}</td>
                    <td>{{$data->unit_measurement}}</td>
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