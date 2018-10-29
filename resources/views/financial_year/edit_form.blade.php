<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->fin_name}}" name="name" placeholder="Name">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker_edit" value="{{$edit->fin_date}}" name="date" placeholder="Name">
                    </div>
                </div>
            </div>

        </div>
    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>

<script>
    $(function() {
        $( ".datepicker_edit" ).datepicker({
            /*changeMonth: true,
             changeYear: true*/
        });
    });
</script>