@extends('mail_views.mail_layout')

@section('content')

    <table class="table table-responsive">
        <thead></thead>
        <tbody>
        <tr>
            <td>Vendor: </td>
            <td>Vendor Invoice No.:</td>
            <td>Billing Address:</td>
        </tr>
        <tr>
            <td>Ship to city:</td>
            <td>Ship to address:</td>
            <td></td>
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

        </tbody>
    </table><hr/>

    <table class="table table-responsive">
        <thead>
        <td>Total Tax (%)</td>
        <td>Total Tax Amount</td>
        <td>Total Discount (%)</td>
        <td>Total Discount Amount</td>
        <td>Grand Total</td>
        </thead>
        <tbody>

        </tbody>
    </table><hr/>


@endsection