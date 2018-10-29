<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                Account Name
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control " value="{{$edit->acct_name}}" name="account_name" placeholder="Account Name">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    Account Number
                    <div class="form-line">
                        <input type="text" class="form-control " value="{{$edit->acct_no}}" name="account_number" placeholder="Account Number">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    Currency
                    <div class="form-line">
                        <select  class="form-control" id="" name="currency" >
                            <option value="{{$edit->curr_id}}" selected>{{$edit->chartCurr->currency}} ({{$edit->chartCurr->code}})</option>
                            @foreach($currency as $ap)
                                <option value="{{$ap->id}}">{{$ap->currency}}({{$ap->code}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>


    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>

<script>
    $(function() {
        $( ".datepicker" ).datepicker({
            /*changeMonth: true,
             changeYear: true*/
        });
    });
</script>