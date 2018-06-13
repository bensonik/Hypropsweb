@extends('master')

@section('content')

<!-- EDIT MODAL -->
<div class="modal fade modal-full-pad" id="edit_assessment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Staff</h4>
            </div>
            <div class="modal-body" id="assess_edit_form" style="overflow: scroll; height: 400px;">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" onclick="edit_assessment('student_edit_form','<?php echo URL::to('edit_staff'); ?>','{{ csrf_token() }}');" class="btn btn-primary">Save</button>
            </div>


        </div>
    </div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <div id="del_message" ></div>
            </div>
            <div class="modal-footer" id="ctrl_buttons" style="display:none;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <!--entry_delete(input checkbox class,prev confirm modal,modal_id,message_id,refresh_id after delete,refresh url,url for delete)-->

                <button onclick="entry_delete('assessment_checkbox','delete_modal','message_box','se_message','refresh_assess',
                    '<?php echo URL::to('staff'); ?>','<?php echo URL::to('delete_staff'); ?>');" type="button" class="btn btn-primary">Delete</button>
            </div>
        </div>

    </div>
</div>

<!-- CHANGE STATUS MODAL -->
<div class="modal fade" id="status_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                <h4 class="modal-title" id="myModalLabel">Status Confirmation</h4>
            </div>
            <div class="modal-body">
                <div id="status_message" ></div>
            </div>
            <div class="modal-footer" id="status_ctrl_buttons" style="display:none;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <!--entry_delete(input checkbox class,prev confirm modal,modal_id,message_id,refresh_id after delete,refresh url,url for delete)-->

                <button onclick="change_status('assessment_checkbox','status_modal','message_box','se_message','refresh_assess',
                    '<?php echo URL::to('staff'); ?>','<?php echo URL::to('staff_status'); ?>','activity_status');" type="button" class="btn btn-primary">Change</button>
            </div>
        </div>

    </div>
</div>

<!-- IMPORT STUDENT FROM EXCEL -->
<div class="modal fade " id="user_excel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                <h4 class="modal-title" id="myModalLabel">Import staff from excel</h4>
            </div>
            <div class="modal-body" >
            <form name="import_excel" id="import_excel" class="form form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Import Excel:</label>
                        <div class="col-sm-8">
                            <input type="file" name="excel" class=" form-control" placeholder="">
                        </div>
                    </div>
            </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" onclick="assessment('import_excel','user_excel','<?php echo URL::to('import_staff'); ?>','{{ csrf_token() }}');" class="btn btn-primary">Save</button>
            </div>


        </div>
    </div>
</div>

<!-- MESSAGE MODAL -->
<div class="modal " id="message_box" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body" >

                <div id="se_message" class="text-center"></div>
            </div>

        </div>

    </div>
</div>


<!-- ADD MODAL -->
<div class="modal fade modal-full-pad" id="add_assessment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Add Staff</h4>
                <button class="btn btn-gray" onClick ="print_table('export_student');" ><i class="fa fa-print"></i>Print</button>&nbsp;
                <button class="btn btn-warning" onClick ="$('#export_student').tableExport({type:'excel',escape:'false'});" ><i class="fa fa-file-excel-o"></i>Excel</button>&nbsp;
                <button class="btn btn-green" onClick ="$('#export-student').tableExport({type:'csv',escape:'false'});" ><i class="fa fa-file-o"></i>Csv</button>
                <button class="btn btn-info" onClick ="$('#export_student').tableExport({type:'doc',escape:'false'});" ><i class="fa fa-file-word-o"></i>Msword</button>&nbsp;
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ti-close"></span></button>

            </div>
            <div class="modal-body" style="overflow: scroll; height: 400px;">

            <form id="student_form" onsubmit="false;" class="form form-horizontal">
            <table class="table table-bordered table-responsive" id="export_student">

            <tbody id="">

            <!--Default Horizontal Form-->

            <tr>

                <td>

                    <div class="form-group">
                        <label class="col-sm-4 col-md-4 control-label">Email:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8">
                            <input type="text"  name="email" class="  form-control" placeholder="Email">
                        </div>
                    </div>

                </td>
                <td>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Title:</label>
                        <div class="col-sm-8">
                            <input type="text" name="title" class=" form-control" placeholder="Title">
                        </div>
                    </div>

                </td>
                <td>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">First Name:</label>
                        <div class="col-sm-8">
                            <input type="text" name="first_name" class=" form-control" placeholder="First Name">
                        </div>
                    </div>

                </td>
                <td>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Othername:</label>
                        <div class="col-sm-8">
                            <input type="text" name="other_name" class=" form-control" placeholder="Othername">
                        </div>
                    </div>

                </td>
                <td>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Surname:</label>
                        <div class="col-sm-8">
                            <input type="text" name="surname" class=" form-control" placeholder="Surname">
                        </div>
                    </div>

                </td>
            </tr>

            <tr>
                <td>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Photo:</label>
                        <div class="col-sm-8">
                            <input type="file" name="photo" class=" form-control" placeholder="">
                        </div>
                    </div>

                </td>
                <td>

                    <div class="form-group">
                        <label class="col-sm-4 col-md-4 control-label">Password:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8">
                            <input type="password" name="password" class=" col-sm-8  form-control" placeholder="">
                        </div>
                    </div>

                </td>
                <td>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Retype-Password:</label>
                        <div class="col-sm-8">
                            <input type="password" name="password_confirmation" class=" form-control" placeholder="">
                        </div>
                    </div>

                </td>
                <td>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Address:</label>
                        <div class="col-sm-8">
                            <input type="text" name="address" class=" form-control" placeholder="Address">
                        </div>
                    </div>

                </td>
                <td>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Date of Birth:</label>
                        <div class="col-sm-8">
                            <input type="text" name="birthday" class="datepicker form-control" placeholder="Date of Birth">
                        </div>
                    </div>

                </td>

            </tr>

            <tr>
                <td>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Sex:</label>
                        <div class="col-sm-8">
                            <select type="number" name="sex" class=" form-control" >
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>

                </td>
                <td>

                    <div class="form-group">
                        <label class="col-sm-4 col-md-4 control-label">State:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8">
                            <input type="text" name="state" class=" col-sm-8  form-control" placeholder="State">
                        </div>
                    </div>

                </td>
                <td>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Local Govt.:</label>
                        <div class="col-sm-8">
                            <input type="text" name="local_govt" class=" form-control" placeholder="Local Government">
                        </div>
                    </div>

                </td>
                <td>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Religion:</label>
                        <div class="col-sm-8">
                            <input type="text" name="religion" class=" form-control" placeholder="Religion">
                        </div>
                    </div>

                </td>
                <td>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Health Status:</label>
                        <div class="col-sm-8">
                            <input type="text" name="health_status" class=" form-control" placeholder="Health Status">
                        </div>
                    </div>

                </td>

            </tr>

            <tr>
                <td>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Guarantor:</label>
                        <div class="col-sm-8">
                            <input type="text" name="guarantor" class=" form-control" placeholder="Guarantor">
                        </div>
                    </div>

                </td>
                <td>

                    <div class="form-group">
                        <label class="col-sm-4 col-md-4 control-label">Staff_type:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8">
                            <select type="number" name="staff_type" class=" form-control" >
                                <option value="Academic">Academic</option>
                                <option value="Non-academic">Non-academic</option>
                            </select>
                        </div>
                    </div>

                </td>
                <td>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Job Type:</label>
                        <div class="col-sm-8">
                            <input type="text" name="job_type" class=" form-control" placeholder="Job Type">
                        </div>
                    </div>

                </td>
                <td>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Position held in school:</label>
                        <div class="col-sm-8">
                            <input type="text" name="position" class=" form-control" placeholder="Position">
                        </div>
                    </div>

                </td>
                <td>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Qualification:</label>
                        <div class="col-sm-8">
                            <input type="text" name="qualification" class=" form-control" placeholder="Qualification">
                        </div>
                    </div>

                </td>

            </tr>

            <tr>
                <td>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Appointment Date:</label>
                        <div class="col-sm-8">
                            <input type="text" name="appointment_date" class="datepicker form-control" placeholder="">
                        </div>
                    </div>

                </td>
                <td>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nationality:</label>
                        <div class="col-sm-8">
                            <input type="text" name="nationality" class=" form-control" placeholder="Nationality">
                        </div>
                    </div>

                </td>

                <td>

                    <div class="form-group">
                        <label class="col-sm-4 col-md-4 control-label">Blood Group:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8">
                            <input type="text" name="blood_group" class="level col-sm-8  form-control" placeholder="Blood Group">
                        </div>
                    </div>

                </td>
                <td>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Blood Type:</label>
                        <div class="col-sm-8">
                            <input type="text" name="blood_type" class="level col-sm-8  form-control" placeholder="Blood Type">
                        </div>
                    </div>

                </td>
                <td>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Phone:</label>
                        <div class="col-sm-8">
                            <input type="text" name="phone" class="col-sm-8  form-control" placeholder="Phone Number">
                        </div>
                    </div>

                </td>

            </tr>
            <tr>

                <td>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Sign:</label>
                        <div class="col-sm-8">
                            <input type="file" name="sign" class="col-sm-8  form-control">
                        </div>
                    </div>

                </td>

            </tr>

            </tbody>
            </table>

            </form>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" onclick="assessment('student_form','add_assessment','<?php echo URL::to('add_staff'); ?>','{{ csrf_token() }}');" class="btn btn-primary">Save</button>
            </div>


        </div>

    </div>
</div>
<!-- ENDING OF ALL MODALS INCLUDING MESSAGE,DELETE CONFIRMATION,EDIT AND ADD MODAL -->

<div class="row grid">
    <div class="col-md-12">
        <!-- *** Responsive Tables *** -->
        <!-- panel -->
        <div class="panel panel-piluku">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Staff
							<span class="panel-options">
								<a href="#" class="panel-refresh">
                                    <i class="icon ti-reload"></i>
                                </a>
								<a href="#" class="panel-minimize">
                                    <i class="icon ti-angle-up"></i>
                                </a>
								<a href="#" class="panel-close">
                                    <i class="icon ti-close"></i>
                                </a>

                                 <a href="javascript:null;" target="_blank" class="btn btn-success" data-toggle="modal" data-target="#user_excel"><i class="fa fa-file-excel-o"></i>Import</a>
                                 <button class="btn btn-gray" onClick ="print_table('all_students');" ><i class="fa fa-print"></i>Print</button>&nbsp;
                                 <button class="btn btn-red" onClick ="print_table('all_students');" ><i class="fa fa-file-pdf-o"></i>Pdf</button>&nbsp;
                                 <button class="btn btn-warning" onClick ="$('#all_students').tableExport({type:'excel',escape:'false'});" ><i class="fa fa-file-excel-o"></i>Excel</button>&nbsp;
                                 <button class="btn btn-green" onClick ="$('#all_students').tableExport({type:'csv',escape:'false'});" ><i class="fa fa-file-o"></i>Csv</button>
                                 <button class="btn btn-info" onClick ="$('#all_students').tableExport({type:'doc',escape:'false'});" ><i class="fa fa-file-word-o"></i>Msword</button>&nbsp;

                                @if($student->count() > 0)
                                <button type="button" onclick="confirm_box('delete_modal','ctrl_buttons','del_message','assessment_checkbox');" class="btn btn-red"><i class="fa fa-trash-o"></i>Delete</button>
                                <button type="button" onclick="status_box('status_modal','status_ctrl_buttons','status_message','assessment_checkbox','1');" class="btn btn-success"><i class="fa fa-check-square-o"></i>Activate</button>
                                <button type="button" onclick="status_box('status_modal','status_ctrl_buttons','status_message','assessment_checkbox','0');" class="btn btn-danger"><i class="fa fa-times"></i>Deactivate</button>
                                @endif

                                <button class="btn btn-green" data-toggle="modal" data-target="#add_assessment"><i class="fa fa-plus"></i>Add</button>

                            </span>
                </h3>
            </div>

            <div class="panel-body">

                <table>

                    <tr class="pull-right">
                        <form id="search_form" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Search:</label>
                            <div class="col-sm-8 ">
                                <input type="text" id="search" name="user" class=" col-sm-8  form-control" placeholder="Search"
                                onkeyup="search_entry('search_form','search','<?php echo URL::to('search_staff'); ?>','refresh_assess','<?php echo URL::to('staff'); ?>')" >
                            </div>
                        </div>
                        </form>
                    </tr><br>
                </table>

                <div class="bs-example" id="refresh_assess">

                    <!-- /.table-responsive -->
                    <div class="table-responsive">
                        <table border="2" class="table table-bordered" id="all_students">

                            <thead>
                            <tr>
                                <th>
                                    <div class="piluku-check">
                                    <input type="checkbox" onclick="toggleme(this,'assessment_checkbox');" id="check_assess"
                                           name="check_all" /></div></th>
                                <th>FullName</th>
                                <th>Reg. Number</th>
                                <th>Date of Birth</th>
                                <th>Staff Type</th>
                                <th>Job Type</th>
                                <th>Qualification</th>
                                <th>Appointment Date</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Guarantor</th>
                                <th>Nationality</th>
                                <th>State</th>
                                <th>Local Govt.</th>
                                <th>Sex</th>
                                <th>Religion</th>
                                <th>Health Status</th>
                                <th>Status</th>
                                <th>Photo</th>
                                <th>Signature</th>
                                <th>Manage</th>
                            </tr>
                            </thead>
                            <tbody >
                            @if($student->count() > 0)
                            @foreach($student as $assess)
                            <tr>
                                <td scope="row"><input value="{{$assess->user_id}}" type="checkbox" id="{{$assess->user_id}}" class="assessment_checkbox" /></td>
                                <td><a href="{{URL::to('mystaff',['id'=>$assess->user_id])}}">
                                      {{$assess->title}}&nbsp; {{ $assess->stud_user->first_name }} &nbsp; {{ $assess->stud_user->other_name }} &nbsp; {{ $assess->stud_user->surname }}
                                    </a></td>
                                <td>{{ $assess->stud_user->username }}</td>
                                <td>{{ date('F d, Y', strtotime($assess->dob)) }}</td>
                                <td>{{ $assess->staff_type }}</td>
                                <td>{{ $assess->job_type }}</td>
                                <td>{{ $assess->qualification }}</td>
                                <td>{{ date('F d, Y', strtotime($assess->appointment_date)) }}</td>
                                <td>{{ $assess->address }}</td>
                                <td>{{ $assess->stud_user->email }}</td>
                                <td>{{ $assess->phone }}</td>
                                <td>{{ $assess->guarantor }}</td>
                                <td>{{ $assess->nationality }}</td>
                                <td>{{ $assess->state }}</td>
                                <td>{{ $assess->local_govt }}</td>
                                <td>{{ $assess->sex }}</td>
                                <td>{{ $assess->religion }}</td>
                                <td>{{ $assess->health_status }}</td>
                                <td>{{$assess->activity_status}}</td>
                                <td>{!! Html::image($assess->sign ,'Signature') !!}</td>
                                <td>{!! Html::image($assess->stud_user->photo ,'Photo') !!}</td>
                                <td><a style="cursor: pointer;" onclick="edit_form('{{$assess->user_id}}','edit_assessment','assess_edit_form','<?php echo URL::to('edit_staff_form') ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a></td>
                                <input type="hidden" name="status" id="activity_status" value="{{$assess->activity}}">
                            </tr>

                            @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                    <div class="real_page paginate pull-right">
                        {!! $student->render() !!}
                    </div>

                </div>
            </div>
            <!-- /panel -->
        </div>
        <!-- /col-md-12 -->
    </div>
    <!-- /row -->

</div>

<!-- REFRESH PAGE ON SUBMIT -->
<script>
    function getpager(id,page){

        $.ajax({
            url:  page
        }).done(function(data){
                $('#'+id).html(data);
            });
    }
</script>

<!-- FETCH SINGLE CLASSES ON GROUP SELECT -->
<script>
    function single_class(value_id,id,page){
        var group = $('#'+value_id).val();

        $.ajax({
            url:  page+'?group='+group
        }).done(function(data){
                $('#'+id).html(data);
            });
    }
</script>

<!-- ADD ENTRY TO DATABASE -->

<script>
        function _(e){
            return document.getElementById(e);
        }

        var ajax = false;
        if (window.XMLHttpRequest){
            ajax= new XMLHttpRequest();
        }else if (window.ActiveXObject){
            ajax = new ActiveXObject("Microsoft.XMLHTTP");
        }

        function assessment(form_id,modal_id,linko,second){

            var form_get = $('#'+form_id);
            var form = document.forms.namedItem(form_id);
            var all_forms = new FormData(form);
            var obj1 = _("se_message");
            all_forms.append('token','{{csrf_token()}}');



            ajax.open("POST", linko, true);
            //ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajax.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
            ajax.onreadystatechange = function(){

               if(ajax.readyState == 4 && ajax.status == 200) {

                   $('#'+modal_id).modal('hide');
                   $('#message_box').modal('show');

                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if(message2 == 'fail'){
                        obj1.innerHTML = '<i style="color:crimson;" class="fa fa-times-circle fa-5x "></i>';
                        var errordiv = '<div class="alert alert-danger text-center alert-dismissable">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><ul>' +
                            '<li style="list-style-type: none">';

                        for(var k in rollback.message) {
                            if(rollback.message.hasOwnProperty(k)) {
                                rollback.message[k].forEach(function(val)  {
                                    errordiv += val+'<br />';
                                });
                            }
                        }
                            errordiv += "</ul></li></div></div>";
                            obj1.innerHTML += errordiv;


                    }else if(message2 == 'saved'){

                        obj1.innerHTML = '<i style="color:green;" class="fa fa-check-circle-o fa-5x "></i>';
                        var success_div = '<div class="alert alert-success">'+
                        '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';

                        success_div += 'Data saved successfully';
                        success_div += '</div>';

                        obj1.innerHTML += success_div;

                    }else{

                        obj1.innerHTML = '<i style="color:dodgerblue" class="fa fa-info-circle fa-5x "></i>';
                        var info_div = '<div class="alert alert-info">'+
                            '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';

                        info_div += message2;
                        info_div += '</div>';

                        obj1.innerHTML += info_div;

                    }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    getpager('refresh_assess','<?= URL::to('staff'); ?>');
                }
            }
            ajax.send(all_forms);
            obj1.innerHTML = '<?php echo Html::image('icons/loading_icon.gif');?>';
        }


    //});

</script>

<script>
    //$(document).ready(function () {

    function _(e){
        return document.getElementById(e);
    }

    var ajax = false;

    if (window.XMLHttpRequest){
        ajax= new XMLHttpRequest();
    }else if (window.ActiveXObject){
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
    }

    function edit_assessment(form_id,linko,second){

        var form_get = $('#'+form_id);
        var form = document.forms.namedItem(form_id);
        var all_forms = new FormData(form);
        var obj1 = _("se_message");
        all_forms.append('token','{{csrf_token()}}');

        ajax.open("POST", linko, true);
        //ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
        ajax.onreadystatechange = function(){

            if(ajax.readyState == 4 && ajax.status == 200) {
                $('#edit_assessment').modal('hide');
                $('#message_box').modal('show');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){
                    obj1.innerHTML = '<i style="color:crimson;" class="fa fa-times-circle fa-5x "></i>';
                    var errordiv = '<div class="alert alert-danger text-center alert-dismissable">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><ul>' +
                        '<li style="list-style-type: none">';

                    for(var k in rollback.message) {
                        if(rollback.message.hasOwnProperty(k)) {
                            rollback.message[k].forEach(function(val)  {
                                errordiv += val+'<br />';
                            });
                        }
                    }
                    errordiv += "</ul></li></div></div>";
                    obj1.innerHTML += errordiv;

                }else if(message2 == 'saved'){

                    obj1.innerHTML = '<i style="color:green;" class="fa fa-check-circle-o fa-5x "></i>';
                    var success_div = '<div class="alert alert-success">'+
                        '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';

                    success_div += 'Data saved successfully';
                    success_div += '</div>';


                    obj1.innerHTML += success_div;

                }else{

                    obj1.innerHTML = '<i style="color:dodgerblue" class="fa fa-info-circle fa-5x "></i>';
                    var info_div = '<div class="alert alert-info">'+
                        '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';

                    info_div += message2;
                    info_div += '</div>';

                    obj1.innerHTML += info_div;

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                getpager('refresh_assess','<?= URL::to('staff'); ?>');
            }
        }
        ajax.send(all_forms);
        obj1.innerHTML = '<?php echo Html::image('icons/loading_icon.gif');?>';
    }

    //});

</script>

<script>
    function status_box(modal_id,ctrl_buttons,confirm_id,klass,stat_type){
        var all_datas = group_val(klass).length;

        $('#'+modal_id).modal('show');
        var show_buttons = document.getElementById(ctrl_buttons);

        if(all_datas >0){
            $('#activity_status').val(stat_type);
            show_buttons.style.display = "block";
            $('#'+confirm_id).html('<div style="color: darkslategrey;">'+'Are you sure you want to change status of the selected '+all_datas+' item(s)'+' in school</div>');
        }else{
            show_buttons.style.display = "none";
            $('#'+confirm_id).html('<div style="color: darkslategrey;">'+'Please select an entry to continue status change'+'</div>');
        }

    }

    //DELETE FUNCTIONALITY
    //entry_delete(input checkbox class,prev confirm modal,modal_id,message_id,refresh_id after delete,refresh url,url for delete)
    function change_status(klass,prev_modal,modal_id,message_id,refresh_id,refresh_url,linko,activity_status){

        var data_string = group_val(klass);
        var all_data = JSON.stringify(data_string);

        var message_area = document.getElementById(message_id);
        var modal_box = $('#'+modal_id);
        var conf_modal = $('#'+prev_modal);
        var status = $('#'+activity_status).val();

        conf_modal.modal('hide');
        modal_box.modal('show');

        ajax.open("POST", linko, true);
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
        ajax.onreadystatechange = function(){

            if(ajax.readyState == 4 && ajax.status == 200){


                message_area.innerHTML = '<i style="color:dodgerblue;" class="fa fa-info-circle-o fa-5x "></i>';
                var success_div = '<div class="alert alert-info">'+
                    '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';

                success_div += ajax.responseText;
                success_div += '</div>';

                message_area.innerHTML += success_div;


                getpager(refresh_id,refresh_url);

            }
        }
        ajax.send("get=rough&all_data="+all_data+'&status='+status);
        obj1.innerHTML = '<?php echo Html::image('icons/loading_icon.gif');?>';
    }


    function search_entry(form_id,search_val,search_url,rep_id,rep_url) {

        var form = $('#'+form_id);
        var search = $('#'+search_val).val();
        var search_form = form.serialize();
        var refresh_id = document.getElementById(rep_id);

        if (search == "" ) {
           getpager(rep_id,rep_url);
        } else {
            ajax.open("POST", search_url, true);
            ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajax.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
            ajax.onreadystatechange = function(){


                if(ajax.readyState == 4 && ajax.status == 200){
                    refresh_id.innerHTML = ajax.responseText;


                }
            }
            ajax.send(search_form);
            refresh_id.innerHTML = '<?php echo Html::image('icons/loading_icon.gif');?>';
        }
    }

</script>

<script>
    /*==================== PAGINATION =========================*/

    $(window).on('hashchange',function(){
        page = window.location.hash.replace('#','');
        getProducts(page);
    });

    $(document).on('click','.real_page a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        // getProducts(page);
        //location.hash = page;
    });

    function getProducts(page){

        $.ajax({
            url: '?page=' + page
        }).done(function(data){
                $('#refresh_assess').html(data);
            });
    }

</script>

<script>
    /*==================== PAGINATION =========================*/


    $(document).on('click','.search_page a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getentry(page);

    });
        var search_val = $('#search').val();
    function getentry(page){

        $.ajax({
            url: '<?php echo URL::to('get_search_staff'); ?>?page='+page+'&user='+search_val
        }).done(function(data){
                $('#refresh_assess').html(data);
            });
    }

</script>

{!! Html::script('load_pages.js'); !!}
@stop