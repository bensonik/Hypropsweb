@extends('layouts.app')

@section('content')

    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Individual Goal
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        {{--@if($lowerHodId == Auth::user()->id && $hodId != Auth::user()->id)--}}

                        {{--@endif--}}
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

                <div class="body">

                    <div class="row clearfix">
                        <form name="import_excel" id="searchFrameForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select  class="form-control " name="goal_set" >
                                            <option value="">Goal Set</option>
                                            @foreach($indiGoalSeries as $ap)
                                                <option value="{{$ap->id}}">{{$ap->goal_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT) || ($lowerHod == \App\Helpers\Utility::HOD_DETECTOR && in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT)))
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select  class="form-control " name="department" id="dept" onchange="fillNextInput('dept','display_user','<?php echo url('default_select'); ?>','dept_users')">
                                            <option value="">Department</option>
                                            @foreach($dept as $ap)
                                                <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line" id="display_user" >
                                        <select  class="form-control" name="user"  >
                                            <option value="">Select User</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                           @endif
                            @if($lowerHod == \App\Helpers\Utility::HOD_DETECTOR && !in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT))
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control " name="department" id="dept" onchange="fillNextInput('dept','display_user','<?php echo url('default_select'); ?>','dept_users')">
                                                <option value="{{Auth::user()->dept_id}} selected">My Department</option>
                                                <option value="{{Auth::user()->dept_id}}">My Department</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line" id="display_user" >
                                            <select  class="form-control" name="user"  >
                                                <option value="">Select User</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT) && $lowerHod != \App\Helpers\Utility::HOD_DETECTOR)
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control " name="department" id="dept">
                                                <option value="">Department</option>
                                                @foreach($dept as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line" >
                                            <select  class="form-control" name="user"  >
                                                <option value="{{Auth::user()->id}}">{{Auth::user()->firstname}} {{Auth::user()->lastname}}</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>

                    <button onclick="searchReport('searchFrameForm','<?php echo url('search_indi_goal'); ?>','reload_data',
                            '<?php echo url('individual_goal'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
                        Search
                    </button>

                </div>


                <div class="body table-responsive" id="reload_data">

                <!-- BEGIN OF TAB WIZARD -->

                <div class="row">
                    <section>
                        <div class="wizard">
                            <div class="wizard-inner">
                                <div class="connecting-line"></div>
                                <ul class="nav nav-tabs" role="tablist">

                                    <li role="presentation" class="active">
                                        <a href="#step{{\App\Helpers\Utility::APP_OBJ_GOAL}}" data-toggle="tab" aria-controls="step{{\App\Helpers\Utility::APP_OBJ_GOAL}}" role="tab" title="Appraisal Objectives and Goals">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-folder-open">Appraisal Objectives and Goals</i>
                        </span>
                                        </a>
                                    </li>

                                    <li role="presentation" class="disabled">
                                        <a href="#step{{\App\Helpers\Utility::COMP_ASSESS}}" data-toggle="tab" aria-controls="step{{\App\Helpers\Utility::COMP_ASSESS}}" role="tab" title="Competency Assessment">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-pencil">Competency Assessment</i>
                        </span>
                                        </a>
                                    </li>
                                    <li role="presentation" class="disabled">
                                        <a href="#step{{\App\Helpers\Utility::BEHAV_COMP2}}" data-toggle="tab" aria-controls="step{{\App\Helpers\Utility::BEHAV_COMP2}}" role="tab" title="Behavioural Competency">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-picture">Behavioural Competency</i>
                        </span>
                                        </a>
                                    </li>

                                    <li role="presentation" class="disabled">
                                        <a href="#step{{\App\Helpers\Utility::INDI_REV_COMMENT}}" data-toggle="tab" aria-controls="step{{\App\Helpers\Utility::INDI_REV_COMMENT}}" role="tab" title="Individual/Reviewers Comment">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-picture">Individual/Reviewers Comment</i>
                        </span>
                                        </a>
                                    </li>

                                    <li role="presentation" class="disabled">
                                        <a href="#step{{\App\Helpers\Utility::EMP_COM_APP_PLAT}}" data-toggle="tab" aria-controls="step{{\App\Helpers\Utility::EMP_COM_APP_PLAT}}" role="tab" title="Employee Comment of Appraisal Platform">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-picture">Employee Comment of Appraisal Platform</i>
                        </span>
                                        </a>
                                    </li>

                                    <li role="presentation" class="disabled">
                                        <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-ok"></i>
                        </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <form role="form">
                                <div class="tab-content">
                                    <div class="tab-pane active" role="tabpanel" id="step{{\App\Helpers\Utility::APP_OBJ_GOAL}}">
                                        <h3>Step 1</h3>
                                        <p>This is step 1</p>
                                        <ul class="list-inline pull-right">
                                            <li><button type="button" class="btn btn-primary next-step">Save and continue</button></li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane" role="tabpanel" id="step{{\App\Helpers\Utility::COMP_ASSESS}}">
                                        <h3>Step 2</h3>
                                        <p>This is step 2</p>
                                        <ul class="list-inline pull-right">
                                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                                            <li><button type="button" class="btn btn-primary next-step">Save and continue</button></li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane" role="tabpanel" id="step{{\App\Helpers\Utility::BEHAV_COMP2}}">
                                        <h3>Step 3</h3>
                                        <p>This is step 3</p>
                                        <ul class="list-inline pull-right">
                                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                                            <li><button type="button" class="btn btn-default next-step">Skip</button></li>
                                            <li><button type="button" class="btn btn-primary btn-info-full next-step">Save and continue</button></li>
                                        </ul>
                                    </div>

                                    <div class="tab-pane" role="tabpanel" id="step{{\App\Helpers\Utility::INDI_REV_COMMENT}}">
                                        <h3>Step 3</h3>
                                        <p>This is step 3</p>
                                        <ul class="list-inline pull-right">
                                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                                            <li><button type="button" class="btn btn-default next-step">Skip</button></li>
                                            <li><button type="button" class="btn btn-primary btn-info-full next-step">Save and continue</button></li>
                                        </ul>
                                    </div>

                                    <div class="tab-pane" role="tabpanel" id="step{{\App\Helpers\Utility::EMP_COM_APP_PLAT}}">
                                        <h3>Step 3</h3>
                                        <p>This is step 3</p>
                                        <ul class="list-inline pull-right">
                                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                                            <li><button type="button" class="btn btn-default next-step">Skip</button></li>
                                            <li><button type="button" class="btn btn-primary btn-info-full next-step">Save and continue</button></li>
                                        </ul>
                                    </div>

                                    <div class="tab-pane" role="tabpanel" id="complete">
                                        <h3>Complete</h3>
                                        <p>You have successfully completed all steps.</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>

                <!-- END OF TAB WIZARD -->

                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

<script>

    function save1(formModal,formId,submitUrl,reload_id,reloadUrl,token,obj,review,level) {
        var inputVars = $('#' + formId).serialize();
        var summerNote = '';
        var htmlClass = document.getElementsByClassName('t-editor');
        if (htmlClass.length > 0) {
            summerNote = $('.summernote').eq(0).summernote('code');
            ;
        }

        var obj1 = classToArray2(obj);
        var level1 = classToArray2(level);
        var review1 = classToArray2(review);

        var jobj = sanitizeData(obj);
        var jlevel = sanitizeData(level);
        var jreview = sanitizeData(review);
        //alert(jcompName);

        if(arrayItemEmpty(obj1) == false && arrayItemEmpty(review1) == false){
        var postVars = inputVars + '&editor_input=' + summerNote+'&obj='+jobj+'&review='+jreview+'&level='+jlevel;
        //alert(postVars);
            $('#loading_modal').modal('show');
        $('#' + formModal).modal('hide');
        sendRequestForm(submitUrl, token, postVars)
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4 && ajax.status == 200) {

                $('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if (message2 == 'fail') {

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalFormError(serverError);
                    swal("Error", messageError, "error");

                } else if (message2 == 'saved') {

                    var successMessage = swalSuccess('Data saved successfully');
                    swal("Success!", "Data saved successfully!", "success");
                    location.reload();
                    clearClassInputs('obj_edit,obj_level_edit,');
                    hideAddedInputs2('new_app_obj_goal','add_more_obj','hide_button_obj','<?php echo URL::to('add_more'); ?>','app_obj_goal');

                } else {

                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContent(reload_id, reloadUrl);
            }
        }
        //END OF OTHER VALIDATION CONTINUES HERE
        }else{
            swal("Warning!","Please, fill in all required fields to continue","warning");
        }

    }

    function save2(formModal,formId,submitUrl,reload_id,reloadUrl,token,core_comp,capable,level,review) {
        var inputVars = $('#' + formId).serialize();
        var summerNote = '';
        var htmlClass = document.getElementsByClassName('t-editor');
        if (htmlClass.length > 0) {
            summerNote = $('.summernote').eq(0).summernote('code');
            ;
        }

        var core_comp1 = classToArray2(core_comp);
        var capable1 = classToArray2(capable);
        var level1 = classToArray2(level);
        var review1 = classToArray2(review);
        var jcore_comp = sanitizeData(core_comp);
        var jcapable = sanitizeData(capable);
        var jlevel = sanitizeData(level);
        var jreview = sanitizeData(review);

        if(arrayItemEmpty(core_comp1) == false && arrayItemEmpty(level1) == false){
            var postVars = inputVars + '&editor_input=' + summerNote+'&core_comp='+jcore_comp+'&capable='+jcapable+'&level='+jlevel+'&review='+jreview;
            //alert(postVars);
            $('#loading_modal').modal('show');
            $('#' + formModal).modal('hide');
            sendRequestForm(submitUrl, token, postVars)
            ajax.onreadystatechange = function () {
                if (ajax.readyState == 4 && ajax.status == 200) {

                    $('#loading_modal').modal('hide');
                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if (message2 == 'fail') {

                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(rollback.message);

                        var messageError = swalFormError(serverError);
                        swal("Error", messageError, "error");

                    } else if (message2 == 'saved') {

                        var successMessage = swalSuccess('Data saved successfully');
                        swal("Success!", "Data saved successfully!", "success");
                        location.reload();

                    } else {

                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");

                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    reloadContent(reload_id, reloadUrl);
                }
            }
            //END OF OTHER VALIDATION CONTINUES HERE
        }else{
            swal("Warning!","Please, fill in all required fields to continue","warning");
        }

    }

    function save3(formModal,formId,submitUrl,reload_id,reloadUrl,token,core_comp,element,level,review) {
        var inputVars = $('#' + formId).serialize();
        var summerNote = '';
        var htmlClass = document.getElementsByClassName('t-editor');
        if (htmlClass.length > 0) {
            summerNote = $('.summernote').eq(0).summernote('code');
            ;
        }

        var core_comp1 = classToArray2(core_comp);
        var element1 = classToArray2(element);
        var level1 = classToArray2(level);
        var review1 = classToArray2(review);
        var jcore_comp = sanitizeData(core_comp);
        var jelement = sanitizeData(element);
        var jlevel = sanitizeData(level);
        var jreview = sanitizeData(review);

        if(arrayItemEmpty(core_comp1) == false && arrayItemEmpty(level1) == false){
            var postVars = inputVars + '&editor_input=' + summerNote+'&core_comp='+jcore_comp+'&element='+jelement+'&level='+jlevel+'&review='+jreview;
            //alert(postVars);
            $('#loading_modal').modal('show');
            $('#' + formModal).modal('hide');
            sendRequestForm(submitUrl, token, postVars)
            ajax.onreadystatechange = function () {
                if (ajax.readyState == 4 && ajax.status == 200) {

                    $('#loading_modal').modal('hide');
                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if (message2 == 'fail') {

                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(rollback.message);

                        var messageError = swalFormError(serverError);
                        swal("Error", messageError, "error");

                    } else if (message2 == 'saved') {

                        var successMessage = swalSuccess('Data saved successfully');
                        swal("Success!", "Data saved successfully!", "success");
                        location.reload();

                    } else {

                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");

                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    reloadContent(reload_id, reloadUrl);
                }
            }
            //END OF OTHER VALIDATION CONTINUES HERE
        }else{
            swal("Warning!","Please, fill in all required fields to continue","warning");
        }

    }

</script>



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
        /*$(function() {
            $( ".datepicker" ).datepicker({
                /!*changeMonth: true,
                changeYear: true*!/
            });
        });*/
    </script>

@endsection