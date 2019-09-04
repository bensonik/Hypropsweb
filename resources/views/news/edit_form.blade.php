<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->news_title}}" name="news_title" placeholder="News Title">
                    </div>
                </div>
            </div>

        </div>
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" id="edit_details" class="form-control " name="details" placeholder="Details">Enter news details</textarea>
                        <script>
                            CKEDITOR.replace('edit_details');
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>