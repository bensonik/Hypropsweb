
    <div class=""> <!-- style="overflow:hidden" -->

        <div class="clearfix"></div>
        <div class="row ">
            <div class="col-md-12" style="overflow:auto">
                <div id="MyAccountsTab" class="tabbable tabs-left">
                    <!-- Account selection for desktop - I -->
                    @include('includes.project_menu',['item',$item])

                    <div class="tab-content col-md-10" style="overflow-x:auto;">
                        <div class="tab-pane active" id="overview"><!--style="padding-left: 60px; padding-right:100px"-->
                            <div class="col-md-offset-1">
                            <!-- Bordered Table -->
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="header">
                                            <h2>
                                                Selected Decision and Comments
                                            </h2>
                                            <ul class="header-dropdown m-r--5">

                                                <li class="dropdown">
                                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                        <i class="material-icons">more_vert</i>
                                                    </a>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li><a class="btn bg-blue-grey waves-effect" onClick ="print_content('main_table');" ><i class="fa fa-print"></i>Print</a></li>
                                                        <li><a class="btn bg-red waves-effect" onClick ="print_content('main_table');" ><i class="fa fa-file-pdf-o"></i>Pdf</a></li>
                                                        <li><a class="btn btn-warning" onClick ="$('#main_table').tableExport({type:'excel',escape:'false'});" ><i class="fa fa-file-excel-o"></i>Excel</a></li>
                                                        <li><a class="btn  bg-light-green waves-effect" onClick ="$('#main_table').tableExport({type:'csv',escape:'false'});" ><i class="fa fa-file-o"></i>CSV</a></li>
                                                        <li><a class="btn btn-info" onClick ="$('#main_table').tableExport({type:'doc',escape:'false'});" ><i class="fa fa-file-word-o"></i>Msword</a></li>

                                                    </ul>
                                                </li>

                                            </ul>
                                        </div>

                                        <div class="body table-responsive" id="reload_data">

                                                    <!-- Default Media -->

                                                    <div class="media">
                                                        <div class="media-left">
                                                            <a href="#">
                                                                <img class="media-object" src="{{ asset('images/'.$item->pro_head->photo) }}" width="64" height="64">
                                                            </a>
                                                        </div>
                                                        <div class="media-body">
                                                            <h4 class="media-heading">{{$item->pro_head->firstname}} {{$item->pro_head->lastname}}</h4>
                                                            {{$mainData->decision_desc}} @ {{$mainData->created_at}}

                                                            <div class="media" id="display_comment"></div>
                                                            @if(!empty($mainData->allComments))
                                                            @foreach($mainData->allComments as $data)
                                                            <div class="media">
                                                                <div class="media-left">
                                                                    @if($data->user_id == '')
                                                                    <a href="#">
                                                                        <img class="media-object" src="{{ asset('images/'.$data->tempUser->photo) }}" width="64" height="64">
                                                                    </a>
                                                                    @else
                                                                    <a href="#">
                                                                        <img class="media-object" src="{{ asset('images/'.$data->user->photo) }}" width="64" height="64">
                                                                    </a>
                                                                    @endif
                                                                </div>
                                                                <div class="media-body">
                                                                    @if($data->user_id == '')
                                                                    <h4 class="media-heading">{{$data->tempUser->firstname}} {{$data->tempUser->lastname}}</h4>
                                                                    @else
                                                                    <h4 class="media-heading">{{$data->user->firstname}} {{$data->user->lastname}}</h4>
                                                                    @endif
                                                                    {{$data->comment}} <br/> @ {{$data->created_at}}
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                            @endif <br/>

                                                            <div class="media">
                                                                <div class="media-left">
                                                                        <a href="#">
                                                                            <img class="media-object" src="{{ asset('images/'.\App\Helpers\Utility::checkAuth('temp_user')->photo) }}" width="64" height="64">
                                                                        </a>
                                                                </div>
                                                                <div class="media-body">
                                                                        <h4 class="media-heading">{{\App\Helpers\Utility::checkAuth('temp_user')->firstname}} {{\App\Helpers\Utility::checkAuth('temp_user')->lastname}}</h4>

                                                                    <form name="comment" id="commentMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <textarea type="text" class="form-control" name="comment" placeholder="Comment on decision"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                        <input type="hidden" name="decision_id" value="{{$mainData->id}}" />
                                                                        <input type="hidden" name="project" value="{{$item->id}}" />
                                                                    </form>
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                                <button type="button" class="form-control pull-right btn-info"
                                                                                        onclick="submitComment('commentModal','commentMainForm','<?php echo url('comment_decision'); ?>','display_comment',
                                                                                                '<?php echo url('project/'.$item->id.'/decision'.\App\Helpers\Utility::authLink('temp_user')); ?>','<?php echo csrf_token(); ?>')"
                                                                                        name="comment" >Submit Comment</button>

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <!-- #END# Default Media -->

                                        </div>



                                    </div>

                                </div>
                            </div>

                            <!-- #END# Bordered Table -->

                            </div>
                        </div>

                    </div>
                    <!-- Account selection for desktop - F -->
                </div>
            </div>
        </div>
    </div>

    <!-- END OF TABS -->

<script>
    /*==================== PAGINATION =========================*/

    $(window).on('hashchange',function(){
        page = window.location.hash.replace('#','');
        getProducts(page);
    });

    $(document).on('click','.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getProducts(page);
        location.hash = page;
    });

    function getProducts(page){

        $.ajax({
            url: '?page=' + page
        }).done(function(data){
            $('#reload_data').html(data);
        });
    }

</script>



    <script>
        function submitComment(formModal,formId,submitUrl,reload_id,reloadUrl,token){
            var inputVars = $('#'+formId).serialize();
            var summerNote = '';
            var htmlClass = document.getElementsByClassName('t-editor');
            if (htmlClass.length > 0) {
                summerNote = $('.summernote').eq(0).summernote('code');;
            }
            var postVars = inputVars+'&editor_input='+summerNote;

            $('#'+formModal).modal('hide');
            sendRequestForm(submitUrl,token,postVars)
            ajax.onreadystatechange = function(){
                if(ajax.readyState == 4 && ajax.status == 200) {

                    $('#'+reload_id).prepend(ajax.responseText);

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS

                }
            }

        }
    </script>


