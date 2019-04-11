@extends('layouts.app')

@section('content')

    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        My Info
                    </h2>
                    <ul class="header-dropdown m-r--5">

                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a class="btn bg-blue-grey waves-effect" onClick ="print_content('reload_data');" ><i class="fa fa-print"></i>Print</a></li>
                                <li><a class="btn bg-red waves-effect" onClick ="print_content('reload_data');" ><i class="fa fa-file-pdf-o"></i>Pdf</a></li>
                                <li><a class="btn btn-warning" onClick ="$('#reload_data').tableExport({type:'excel',escape:'false'});" ><i class="fa fa-file-excel-o"></i>Excel</a></li>
                                <li><a class="btn  bg-light-green waves-effect" onClick ="$('#reload_data').tableExport({type:'csv',escape:'false'});" ><i class="fa fa-file-o"></i>CSV</a></li>
                                <li><a class="btn btn-info" onClick ="$('#reload_data').tableExport({type:'doc',escape:'false'});" ><i class="fa fa-file-word-o"></i>Msword</a></li>

                            </ul>
                        </li>

                    </ul>
                </div>

                <div class="body ">

                    <div class=" table-responsive" id="reload_data">

                        <div class="image pull-right">
                            <img src="{{ asset('images/'.Auth::user()->photo) }}" class="" width="102" height="90" alt="User" />

                        </div><br>
                        <form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <b>Title*</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" value="{{$edit->title}}" name="title" placeholder="Title" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Email*</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="email" class="form-control" value="{{$edit->email}}" name="email" placeholder="Email" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>First Name*</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control"value="{{$edit->firstname}}" name="firstname" placeholder="First name" required>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <hr/>

                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <b>Last Name*</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control"value="{{$edit->lastname}}" name="lastname" placeholder="Last name" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Other Name</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control"value="{{$edit->othername}}" name="othername" placeholder="Other name" required>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <hr/>

                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <b>Gender*</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control" name="gender"  required>
                                                    <option value="{{$edit->sex}}">{{$edit->sex}}</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="department" value="{{$edit->dept_id}}"/>
                                    <input value="{{$edit->role}}" name="role" type="hidden"/>
                                </div>
                                <hr/>

                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <b>Date of Birth</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control datepicker" value="{{$edit->dob}}" name="birthdate" placeholder="Date of Birth" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Phone</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" class="form-control" value="{{$edit->phone}}" name="phone" placeholder="Phone" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Address</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" value="{{$edit->address}}" name="home_address" placeholder="Home Address" >
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <hr/>

                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <b>Nationality</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" value="{{$edit->nationality}}" name="nationality" placeholder="Nationality">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Discipline</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control " value="{{$edit->discipline}}" name="discipline" placeholder="Discipline" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Rate</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" class="form-control" value="{{$edit->rate}}" name="rate" placeholder="Rate" >
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <hr/>

                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <b>Rate Type</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control" name="rate_type"  >
                                                    <option value="{{$edit->rate_type}}">{{$edit->rate_type}}</option>
                                                    <option value="Rate Per Hour">Rate Per Hour</option>
                                                    <option value="Rate Per Day">Rate Per Day</option>
                                                    <option value="Rate Per Month">Rate Per Month</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Experience</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="experience" value="{{$edit->experience}}" placeholder="Experience">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Certification</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control " name="cert" value="{{$edit->cert}}" placeholder="Certification" >
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <hr/>

                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <b>Certificate Expiry Date</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control datepicker" name="cert_expiry_date" value="{{$edit->cert_expiry_date}}" placeholder="Certificate Expiry Date" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Certificate Issue Date</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control datepicker" name="cert_issue_date" value="{{$edit->cert_issue_date}}" placeholder="Certificate Issue Date" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>BUPA/HMO Expiry Date</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control datepicker" name="bupa_hmo_expiry_date" value="{{$edit->bupa_hmo_expiry_date}}" placeholder="BUPA/HMO Expiry Date">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <hr/>

                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <b>Green Card Expiry Date</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control datepicker" value="{{$edit->green_card_expiry_date}}" name="green_card_expiry_date" placeholder="Green Card Expiry Date" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Qualifications</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" value="{{$edit->qualification}}" name="qualification" placeholder="qualification" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Photo</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="file" class="form-control" name="photo" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr/>

                                <div class="row clearfix">

                                    <div class="col-sm-4">
                                        <b>CV (Curriculum Vitae)</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="file" class="form-control" name="cv" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Password</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="password" class="form-control " value="" name="password" placeholder="Password" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Password Confirm</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="password" class="form-control " value="" name="password_confirmation" placeholder="Confirm Password" >
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <input type="hidden" name="prev_password" value="{{$edit->password}}" >
                            <input type="hidden" name="prev_photo" value="{{$edit->photo}}" >
                            <input type="hidden" name="prev_sign" value="{{$edit->sign}}" >
                            <input type="hidden" name="edit_id" value="{{$edit->id}}" >

                            <button type="button"  onclick="submitMediaForm1('editModal','editMainForm','<?php echo url('edit_temp_user'); ?>','reload_data',
                                    '<?php echo url('temp_user'); ?>','<?php echo csrf_token(); ?>')"
                                    class="pull-right btn btn-success waves-effect">
                                SAVE CHANGES
                            </button>
                        </form>


                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->
    <script>
        //SUBMIT FORM WITH A FILE
        function submitMediaForm1(formModal,formId,submitUrl,reload_id,reloadUrl,token){
            var form_get = $('#'+formId);
            var form = document.forms.namedItem(formId);
            var postVars = new FormData(form);
            postVars.append('token',token);
            $('#loading_modal').modal('show');
            $('#'+formModal).modal('hide');
            sendRequestMediaForm(submitUrl,token,postVars)
            ajax.onreadystatechange = function(){
                if(ajax.readyState == 4 && ajax.status == 200) {
                    $('#loading_modal').modal('hide');
                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if(message2 == 'fail'){

                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(rollback.message);

                        var messageError = swalFormError(serverError);
                        swal("Error",messageError, "error");

                    }else if(message2 == 'saved'){

                        var successMessage = swalSuccess('Data saved successfully');
                        swal("Success!", successMessage, "success");
                        location.reload();

                    }else{

                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");

                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    //reloadContent(reload_id,reloadUrl);
                }
            }

        }
    </script>

@endsection