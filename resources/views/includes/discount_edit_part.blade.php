<div class="row clearfix">

    <div class="col-sm-4">
        <b>Select Discount Type</b>
        <div class="form-group">
            <div class="form-line">
                <select class="form-control" name="discount_type" >
                        <option selected value="{{\App\Helpers\Utility::LINE_ITEM_DISCOUNT}}">Line Item Discount</option>
                        <option value="{{\App\Helpers\Utility::ONE_TIME_DISCOUNT}}">One time discount excluding line item discount(s)</option>
                </select>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <b>Total Discount Amount</b>
        <div class="form-group">
            <div class="form-line">
                <input type="number" class="form-control" readonly name="one_time_discount_amount" id="total_discount_amount_edit" placeholder="Discount Amount" >
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <b>Total Discount Percentage</b>
        <div class="form-group">
            <div class="form-line">
                <input type="number" class="form-control" id="total_discount_perct_edit" onkeyup="genPercentage('total_discount_perct_edit','total_discount_amount_edit','overall_sum_edit','shared_sub_total_edit','vendorCust_edit','total_tax_amount_edit')" name="one_time_perct" placeholder="Percentage" >
            </div>
        </div>
    </div>

</div>