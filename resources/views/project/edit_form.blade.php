<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->project_name}}" name="project_name" placeholder="Project Name">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control" name="project_description" placeholder="Project Description">
                            {{$edit->project_desc}}
                        </textarea>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>