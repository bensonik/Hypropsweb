@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Salary Structure</h4>
                </div>
                <div class="modal-body">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="salary_name" placeholder="Salary Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class="form-control"  name="salary_desc" placeholder="Salary Description"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="gross_pay" placeholder="Gross Pay">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control"  name="net_pay" placeholder="Net Pay">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control"  name="tax_system" >
                                                <option value="">select tax</option>
                                                @foreach($taxSystem as $comp)
                                                    <option value="{{$comp->id}}">{{$comp->tax_name}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control comp_name"  name="salary_comp" >
                                                <option value="">select</option>
                                            @foreach($salaryComp as $comp)
                                                <option value="{{$comp->comp_name}}">{{$comp->comp_name}}</option>
                                            @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control amount" name="amount" placeholder="Amount">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control comp_type"  name="comp_type" >
                                                @foreach(\App\Helpers\Utility::COMPONENT_TYPE as $comp)
                                                    <option value="{{$comp}}">{{$comp}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4" id="hide_button">
                                    <div class="form-group">
                                        <div onclick="addMore('add_more','hide_button','1','<?php echo URL::to('add_more'); ?>','salary_struct','hide_button');">
                                            <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div id="add_more"></div>

                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="saveSalaryStructure('createModal','createMainForm','<?php echo url('create_structure'); ?>','reload_data',
                            '<?php echo url('salary_structure'); ?>','<?php echo csrf_token(); ?>','comp_name','amount','comp_type')" type="button" class="btn btn-link waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" id="edit_content">

                </div>
                <div class="modal-footer">
                    <button onclick="saveSalaryStructure('editModal','editMainForm','<?php echo url('edit_structure'); ?>','reload_data',
                            '<?php echo url('salary_structure'); ?>','<?php echo csrf_token(); ?>','comp_name_edit','amount_edit','comp_type_edit')" type="button" class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Salary Structure
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('salary_structure'); ?>',
                                    '<?php echo url('delete_structure'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>
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
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Name</th>
                            <th>Description</th>
                            <th>Net Pay</th>
                            <th>Gross Pay</th>
                            <th>Tax</th>
                            <th>Components</th>
                            <th>Manage</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)
                        <tr>
                            <td scope="row">
                                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>{{$data->salary_name}}</td>
                            <td>{{$data->desc}}</td>
                            <td>{{$data->net_pay}}</td>
                            <td>{{$data->gross_pay}}</td>
                            <td>
                                @if($data->tax_id != '')
                                    {{$data->tax->tax_name}}
                                @endif
                            </td>
                            <td>
                                @if($data->component != '')
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <th>Component</th>
                                    <th>Amount</th>
                                    <th>Component Type</th>
                                    </thead>
                                    <tbody>
                                    <?php $components = json_decode($data->component,TRUE); ?>
                                    @foreach($components as $comp)
                                        <tr>
                                            <td>{{$comp['component']}}</td>
                                            <td>{{$comp['amount']}}</td>
                                            <td>{{$comp['component_type']}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @endif
                            </td>
                            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_structure_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class=" pagination pull-right">
                        {!! $mainData->render() !!}
                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

<script>

    function saveSalaryStructure(formModal,formId,submitUrl,reload_id,reloadUrl,token,comp,amount,compType) {
        var inputVars = $('#' + formId).serialize();
        var summerNote = '';
        var htmlClass = document.getElementsByClassName('t-editor');
        if (htmlClass.length > 0) {
            summerNote = $('.summernote').eq(0).summernote('code');
            ;
        }

        var compName = classToArray(comp);
        var amount = classToArray(amount);
        var compType1 = classToArray(compType);
        var jcompName = JSON.stringify(compName);
        var jamount = JSON.stringify(amount);
        var jcompType = JSON.stringify(compType1);
        //alert(jcompName);

        if(arrayItemEmpty(compName) == false && arrayItemEmpty(amount) == false){
        var postVars = inputVars + '&editor_input=' + summerNote+'&component='+jcompName+'&amount='+jamount+'&comp_type='+jcompType;
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