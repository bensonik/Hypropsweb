<div class="row clearfix">

    <div class="col-sm-4">
        <b>Select Tax Type</b>
        <div class="form-group">
            <div class="form-line">
                <select class="form-control" name="discount_type" >
                    <option selected value="{{\App\Helpers\Utility::LINE_ITEM_TAX}}">Line Item Tax</option>
                    <option value="{{\App\Helpers\Utility::ONE_TIME_TAX}}">One time tax excluding line item tax(es)</option>
                </select>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <b>Total Tax Amount</b>
        <div class="form-group">
            <div class="form-line">
                <input type="number" class="form-control" readonly name="one_time_tax_amount_edit" id="total_tax_amount_edit" placeholder="Tax Amount" >
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <b>Total Tax Percentage</b>
        <div class="form-group">
            <div class="form-line">
                <input type="number" class="form-control" id="total_tax_perct_edit" onkeyup="genPercentage('total_tax_perct_edit','total_tax_amount_edit','overall_sum_edit','shared_sub_total_edit','vendorCust_edit','total_discount_amount_edit')" name="one_time_perct" placeholder="Percentage" >
            </div>
        </div>
    </div>

</div>