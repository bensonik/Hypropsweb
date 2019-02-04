@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Purchase Order</h4>

                    <li class="dropdown pull-right">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a class="btn bg-blue-grey waves-effect" onClick ="print_content('createMainForm');" ><i class="fa fa-print"></i>Print</a></li>
                            <li><a class="btn bg-red waves-effect" onClick ="print_content('createMainForm');" ><i class="fa fa-file-pdf-o"></i>Pdf</a></li>
                            <li><a class="btn btn-warning" onClick ="$('#createMainForm').tableExport({type:'excel',escape:'false'});" ><i class="fa fa-file-excel-o"></i>Excel</a></li>
                            <li><a class="btn  bg-light-green waves-effect" onClick ="$('#createMainForm').tableExport({type:'csv',escape:'false'});" ><i class="fa fa-file-o"></i>CSV</a></li>
                            <li><a class="btn btn-info" onClick ="$('#createMainForm').tableExport({type:'doc',escape:'false'});" ><i class="fa fa-file-word-o"></i>Msword</a></li>

                        </ul>
                    </li>

                </div>
                <div class="modal-body" style="height:500px; overflow:scroll;" id="po_main_table">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    Preferred Vendor
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_vendor" onkeyup="searchOptionListVenCust('select_vendor','myUL1','{{url('default_select')}}','search_vendor_transact','vendorCust','foreign_amount','<?php echo url('vendor_customer_currency') ?>','overall_sum');" name="select_user" placeholder="Select Vendor">

                                            <input type="hidden" class="user_class" name="pref_vendor" id="vendorCust" />
                                        </div>
                                    </div>
                                    <ul id="myUL1" class="myUL"></ul>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Vendor Invoice Number
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="vendor_invoice_no" placeholder="Vendor Invoice Number">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        PO Number
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="po_number" placeholder="Purchase Order Number">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Assign User
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user','myUL2','{{url('default_select')}}','default_search','user');" name="select_user" placeholder="Select User">

                                            <input type="hidden" class="user_class" name="user" id="user" />
                                        </div>
                                    </div>
                                    <ul id="myUL2" class="myUL"></ul>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Posting Date
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" id="posting_date" onkeyup="exchangeRate('vendor','curr_rate','posting_date','<?php echo url('exchange_rate'); ?>')" name="posting_date" placeholder="Posting Date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Due Date
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" id="due_date" name="due_date" placeholder="Due Date">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>
                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        RFQ Number
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="rfq_no" placeholder="RFQ Number">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        1 {{\App\Helpers\Utility::defaultCurrency()}} =
                                        <div class="form-line ">
                                            <input type="text" class="form-control" name="curr_rate" id="curr_rate" readonly placeholder="Currency Rate">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Billing Address
                                        <div class="form-line">
                                            <textarea class="form-control"  id="billing_address" name="billing_address" placeholder="Billing Address"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control ship_status" name="po_status" >
                                                <option value="">Select PO status</option>
                                                @foreach(\App\Helpers\Utility::SHIP_STATUS as $key => $val)
                                                    <option value="{{$val}}">{{$val}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <h4>Shipping Details</h4>
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Ship to country
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="ship_country" placeholder="Ship to country">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Ship to city
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="ship_city" placeholder="Ship to city">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Ship to contact
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="ship_contact" placeholder="Shipping Contact">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Shipping Agent
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="ship_agent" placeholder="Ship Agent">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Ship method
                                        <div class="form-line">
                                            <select class="form-control" name="ship_method" >
                                                <option value="None">None</option>
                                                <option value="USPS First Class">USPS First Class</option>
                                                <option value="USPS First Class International">USPS First Class International</option>
                                                <option value="USPS Priority">USPS Priority</option>
                                                <option value="USPS MediaMail">USPS MediaMail</option>
                                                <option value="UPS Two-Day">UPS Two-Day</option>
                                                <option value="UPS Ground">UPS Ground</option>
                                                <option value="Fedex Overnight">Fedex Overnight</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Ship to address
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="ship_address" placeholder="Ship address">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="row clearfix">
                                <h4>Account Section</h4>
                                @include('includes.account_part')
                            </div>
                            <hr/>
                            <div class="row clearfix">
                                <h4>Item Section</h4>
                                @include('includes.purchase_order')
                            </div>
                            <hr/>
                            <div class="row clearfix">
                                @include('includes.discount_part')
                            </div>
                            <hr/>
                            <div class="row clearfix">
                                @include('includes.tax_part')
                            </div>
                            <hr/>
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Grand Total(Default Curr(Incl. Tax)) {{\App\Helpers\Utility::defaultCurrency()}}
                                        <div class="form-line">
                                            <input type="text" class="form-control" readonly id="foreign_overall_sum" name="grand_total" placeholder="Grand Total Default Currency">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                        Grand Total(Incl. Tax) <span class="foreign_amount"></span>
                                    <div class="form-group ">

                                        <div class="form-line">
                                            <input type="text" class="form-control" id="overall_sum" readonly name="grand_total_vendor_curr" placeholder="Grand Total Vendor Currency">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    Grand Total(Excl. Tax) <span class="foreign_amount"></span>
                                    <div class="form-group ">

                                        <div class="form-line">
                                            <input type="text" class="form-control" id="excl_overall_sum" readonly name="" placeholder="Grand Total(Excl. Tax) Vendor Currency">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="row clearfix">
                                @include('includes.message_part')

                            </div>

                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaFormClass('createModal','createMainForm','<?php echo url('create_po'); ?>','reload_data',
                            '<?php echo url('purchase_order'); ?>','<?php echo csrf_token(); ?>',[
                            'inv_class','item_desc','warehouse','quantity','unit_cost','unit_measure',
                            'quantity_reserved','quantity_received','planned','expected','promised','b_order_no',
                            'b_order_line_no','ship_status','status_comment','tax','tax_perct','tax_amount',
                            'discount_perct','discount_amount','sub_total','acc_class','acc_desc','acct_rate',
                            'acc_tax','acc_tax_perct','acc_tax_amount','acc_discount_perct','acc_discount_amount',
                            'acc_sub_total'
                            ],'mail_message')" type="button" class="btn btn-link waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" id="edit_content" style="height:500px; overflow:scroll;">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaFormClass('editModal','editMainForm','<?php echo url('edit_po'); ?>','reload_data',
                            '<?php echo url('purchase_order'); ?>','<?php echo csrf_token(); ?>',[
                                    'inv_class_edit','item_desc_edit','warehouse_edit','quantity_edit','unit_cost_edit','unit_measure_edit',
                            'quantity_reserved_edit','quantity_received_edit','planned_edit','expected_edit','promised_edit','b_order_no_edit',
                            'b_order_line_no_edit','ship_status_edit','status_comment_edit','tax_edit','tax_perct_edit','tax_amount_edit',
                            'discount_perct_edit','discount_amount_edit','sub_total_edit','acc_class_edit','acc_desc_edit','acc_rate_edit',
                            'acc_tax_edit','acc_tax_perct_edit','acc_tax_amount_edit','acc_discount_perct_edit','acc_discount_amount_edit',
                            'acc_sub_total_edit'
                            ],'mail_message_edit')"
                            class="btn btn-link waves-effect">
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
                        Purchase Order
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('purchase_order'); ?>',
                                    '<?php echo url('delete_po'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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

                <div class="body">
                <div class="row">
                    <div class="col-sm-12 ">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="search_po" class="form-control"
                                       onkeyup="searchItem('search_po','reload_data','<?php echo url('search_po') ?>','{{url('purchase_order')}}','<?php echo csrf_token(); ?>')"
                                       name="search_po" placeholder="Search Purchase Order" >
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="row clearfix">



                    </div>

                <div class="body table-responsive" id="reload_data">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>
                            <th>Manage</th>
                            <th>PO Number</th>
                            <th>Vendor Invoice Number</th>
                            <th>Vendor</th>
                            <th>Post Date</th>
                            <th>Due date</th>
                            <th>Ship to Contact</th>
                            <th>PO Status</th>
                            <th>Assigned User</th>
                            <th>Sum Total</th>
                            <th>Sum Total {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>Created by</th>
                            <th>Updated by</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)
                        <tr>
                            <td scope="row">
                                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                            </td>
                            <td>
                                <a style="cursor: pointer;" onclick="editTransactForm('{{$data->id}}','edit_content','<?php echo url('edit_po_form') ?>','<?php echo csrf_token(); ?>','foreign_amount_edit','<?php echo url('vendor_customer_currency') ?>','vendorDisplay')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>{{$data->po_number}}</td>
                            <td>{{$data->vendor_invoice_no}}</td>
                            <td>{{$data->vendorCon->name}}</td>
                            <td>{{$data->post_date}}</td>
                            <td>{{$data->due_date}}</td>
                            <td>{{$data->ship_to_contact}}</td>
                            <td>{{$data->purchase_status}}</td>
                            <td>{{$data->UserDetail->firstname}} &nbsp; {{$data->userDetail->lastname}}</td>
                            <td>({{$data->currency->code}}){{$data->currency->symbol}}&nbsp;{{$data->sum_total}}</td>
                            <td>{{$data->trans_total}}</td>
                            <td>{{$data->user_c->firstname}} &nbsp;{{$data->user_c->lastname}} </td>
                            <td>{{$data->user_u->firstname}} &nbsp;{{$data->user_u->lastname}}</td>
                            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <input type="hidden" id="vendorDisplay" value="{{$data->vendor}}">

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
    </div>

    <!-- #END# Bordered Table -->

    <script>
        //SUBMIT FORM WITH A FILE
        function submitMediaFormClass(formModal,formId,submitUrl,reload_id,reloadUrl,token,classList,ckInputId){
            var form_get = $('#'+formId);
            var form = document.forms.namedItem(formId);
            var ckInput = CKEDITOR.instances[ckInputId].getData();

            var postVars = new FormData(form);
            postVars.append('token',token);
            postVars.append('mail_message',ckInput);
            appendClassToPost(classList,postVars);
            console.log(JSON.stringify(postVars));
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
                        //location.reload();

                    }else{

                        //alert(message2);
                        console.log(message2)
                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");

                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    reloadContent(reload_id,reloadUrl);
                }
            }

        }

        function appendClassToPost(classList,PostVar){
            for(var i=0; i<classList.length;i++){
                var classValue = sanitizeData(classList[i]);
                PostVar.append(classList[i],classValue);
            }
        }

    </script>

<script>

    /*==================== PAGINATION =========================*/

    $(window).on('hashchange',function(){
        page = window.location.hash.replace('#','');
        getData(page);
    });

    $(document).on('click','.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getData(page);
        location.hash = page;
    });

    function getData(page){
        var searchVal = $('#search_inventory').val();
        var pageData = '';
        if(searchVal == ''){
            pageData = '?page=' + page;
        }else{
            pageData = '<?php echo url('search_po') ?>?page=' + page+'&searchVar='+searchVal;
        }

        $.ajax({
            url: pageData
        }).done(function(data){
            $('#reload_data').html(data);
        });
    }

    //exchangeRate('vendorCust','curr_rate','posting_date','<?php echo url('exchange_rate'); ?>')

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