@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Create Inventory Item</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;">

                    <form name="createMainForm" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">

                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Warehouse
                                        <div class="form-line" >
                                            <select class=" warehouse" name="warehouse" id="warehouse_id" onchange="fillNextInput('warehouse_id','zone_display_id','<?php echo url('default_select'); ?>','w_zones')" >
                                                <option value="">Select Receipt Warehouse</option>
                                                @foreach($warehouse as $inv)
                                                    @if($edit->whse_id == $inv->id)
                                                        <option selected value="{{$inv->id}}">{{$inv->name}} ({{$inv->code}})</option>
                                                    @endif
                                                    <option value="{{$inv->id}}">{{$inv->name}} ({{$inv->code}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <b>Zone</b>
                                        <div class="form-line" id="zone_display_id">
                                            <select class=" " id="zone_id" name="zone" onchange="fillNextInput('zone_id','bin_id','<?php echo url('default_select'); ?>','z_bins')">
                                                <option value="{{$edit->zone_id}}">{{$edit->zone->name}}</option>
                                                @foreach($zones as $z)
                                                    <option value="{{$z->id}}">{{$z->zone->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <b>Receipt Bin</b>
                                        <div class="form-line" id="bin_id">
                                            <select class=" " name="bin"  >
                                                <option value="{{$edit->bin_id}}">{{$edit->bin->code}}</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div id="bom_items" >
                                <div class="row clearfix"  >

                                    <div class="col-sm-4">
                                        Inventory Item
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" autocomplete="off" id="select_inv" onkeyup="searchOptionList('select_inv','myUL500','{{url('default_select')}}','search_inventory','inv500');" name="select_user" placeholder="Select Inventory Item">

                                                <input type="hidden" class="inv_class" value="" name="user" id="inv500" />
                                            </div>
                                        </div>
                                        <ul id="myUL500" class="myUL"></ul>
                                    </div>

                                    <div class="col-sm-4">
                                        <b>Quantity</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" class="form-control bom_qty bom_qty_class" name="bom_qty" id="bom_qty" placeholder="Quantity" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4" id="hide_button_inv">
                                        <div class="form-group">
                                            <div onclick="addMore('add_more_inv','hide_button_inv','1','<?php echo URL::to('add_more'); ?>','warehouse_items','hide_button_inv');">
                                                <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div id="add_more_inv">

                                </div>
                            </div>

                     </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="saveInventory('createModal','createMainForm','<?php echo url('create_inventory'); ?>','reload_data',
                            '<?php echo url('inventory'); ?>','<?php echo csrf_token(); ?>','inv_class','bom_qty','bom_amount')" type="button" class="btn btn-link waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Manage Warehouse Inventory Items Content -->
    <div class="modal fade" id="manageWhseModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header">
                    <h4 class="modal-title" id="defaultModalLabel">Warehouse Inventory Items</h4>
                    <ul class="header-dropdown m-r--5 pull-right" style="display:inline;">

                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>Export
                            </a>
                            <ul class="dropdown-menu pull-right">
                                @include('includes/export',[$exportId = 'main_table', $exportDocId = 'reload_data'])
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="modal-body" style="height:500px; overflow:scroll;" id="manageWhse">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Manage Warehouse Zones Content -->
    <div class="modal fade" id="manageZoneModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header">
                    <h4 class="modal-title" id="defaultModalLabel">Manage Warehouse Zone(s)</h4>
                    <ul class="header-dropdown m-r--5 pull-right" style="display:inline;">

                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>Export
                            </a>
                            <ul class="dropdown-menu pull-right">
                                @include('includes/export',[$exportId = 'main_table', $exportDocId = 'reload_data'])
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;" id="manageZone">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Manage Warehouse Bin Content -->
    <div class="modal fade" id="manageBinModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Manage Bin</h4>

                    <li class="dropdown pull-right">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>Export
                        </a>
                        <ul class="dropdown-menu pull-right">
                            @include('includes/export',[$exportId = 'main_table_', $exportDocId = 'reload_data'])
                        </ul>
                    </li>

                </div>
                <div class="modal-body" style="height:500px; overflow:scroll;" id="manageBin">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!--Warehouse Bin Inventory Content -->
    <div class="modal fade" id="addBinModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add Bin to Zone</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;" id="addBin">

                </div>
                <div class="modal-footer">
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
                        Warehouse Inventory
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('inventory'); ?>',
                                    '<?php echo url('delete_inventory'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="changeItemStatus('kid_checkbox','reload_data','<?php echo url('inventory'); ?>',
                                    '<?php echo url('change_inventory_status'); ?>','<?php echo csrf_token(); ?>','1');" class="btn btn-success">
                                <i class="fa fa-check-square-o"></i>Enable Inventory Item
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="changeItemStatus('kid_checkbox','reload_data','<?php echo url('inventory'); ?>',
                                    '<?php echo url('change_inventory_status'); ?>','<?php echo csrf_token(); ?>','0');" class="btn btn-danger">
                                <i class="fa fa-close"></i>Disable Inventory Item
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

                <div class="body ">
                    <div class="row">
                        <div class="col-sm-4">
                            Inventory Item
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" autocomplete="off" id="select_inventory" onkeyup="searchOptionList('select_inventory','myUL','{{url('default_select')}}','search_inventory','inventory_item');" name="select_user" placeholder="Select Inventory Item">

                                    <input type="hidden" class="inv_class" value="" name="user" id="inventory_item" />
                                </div>
                            </div>
                            <ul id="myUL" class="myUL"></ul>
                        </div>

                        <div class="col-sm-4 ">
                            <div class="form-group">
                                <div class="form-line">
                                    <button type="text" id="" class="form-control"
                                           onclick="searchItem('inventory_item','reload_data','<?php echo url('search_warehouse_items') ?>','{{url('user')}}','<?php echo csrf_token(); ?>')"
                                           name="search_button">Search Item</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row clearfix">
                        <form name="warehouseSearchForm" id="warehouseSearchForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="col-sm-4">
                                <div class="form-group">
                                    Warehouse
                                    <div class="form-line" >
                                        <select class=" warehouse" name="warehouse" id="warehouse_id_search" onchange="fillNextInput('warehouse_id_search','zone_display_id_search','<?php echo url('default_select'); ?>','w_zones')" >
                                            <option value="">Select Receipt Warehouse</option>
                                            @foreach($warehouse as $inv)
                                                @if($edit->whse_id == $inv->id)
                                                    <option selected value="{{$inv->id}}">{{$inv->name}} ({{$inv->code}})</option>
                                                @endif
                                                <option value="{{$inv->id}}">{{$inv->name}} ({{$inv->code}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <b>Zone</b>
                                    <div class="form-line" id="zone_display_id_search">
                                        <select class=" " id="zone_id_search" name="zone" onchange="fillNextInput('zone_id_search','bin_id_search','<?php echo url('default_select'); ?>','z_bins')">
                                            <option value="{{$edit->zone_id}}">{{$edit->zone->name}}</option>
                                            @foreach($zones as $z)
                                                <option value="{{$z->id}}">{{$z->zone->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <b>Receipt Bin</b>
                                    <div class="form-line" id="bin_id_search">
                                        <select class=" " name="bin"  >
                                            <option value="{{$edit->bin_id}}">{{$edit->bin->code}}</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>

                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-4 ">
                                <div class="form-group">
                                    <div class="form-line">
                                        <button onclick="searchReport('warehouseSearchForm','<?php echo url('search_warehouse_inventory'); ?>','reload_data',
                                                '','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
                                            SAVE
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>

                <div class=" table-responsive tbl_scroll" id="reload_data" style="height:500px; overflow:scroll;">

                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>
                            <th>Manage Zones</th>
                            <th>Name</th>

                            <th>Code</th>
                            <th>Address</th>
                            <th>Country</th>
                            <th>Contact</th>
                            <th>Contact Phone</th>
                            <th>Created by</th>
                            <th>Updated by</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)
                            <tr>
                                <td scope="row">
                                    <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                </td>
                                <td>
                                    <a style="cursor: pointer;" onclick="newWindow('{{$data->id}}','manageZone','<?php echo url('warehouse_inventory_zone') ?>','<?php echo csrf_token(); ?>','manageZoneModal')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                </td>
                                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->

                                <td>{{$data->name}}</td>
                                <td>{{$data->code}}</td>
                                <td>{{$data->address}}</td>
                                <td>{{$data->country}}</td>
                                <td>{{$data->contact}}</td>
                                <td>{{$data->phone}}</td>
                                <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

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
        var li_class = document.getElementsByClassName("myUL");
        $(window).click(function() {
            for (var i = 0; i < li_class.length; i++){
                li_class[i].style.display = 'none';
            }

        });

        function newWindow(dataId,displayId,submitUrl,token,modalId){
            //alert(dataId);
            var postVars = "dataId="+dataId;
            $('#'+modalId).modal('show');
            sendRequest(submitUrl,token,postVars)
            ajax.onreadystatechange = function(){
                if(ajax.readyState == 4 && ajax.status == 200) {

                    var ajaxData = ajax.responseText;
                    $('#'+displayId).html(ajaxData);

                }
            }
            $('#'+displayId).html('LOADING DATA');

        }

    </script>


    <script>
        /*==================== PAGINATION =========================*/

        $(window).on('hashchange',function(){
            //page = window.location.hash.replace('#','');
            //getData(page);
        });

        $(document).on('click','.pagination a', function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getData(page);
            //location.hash = page;
        });

        $(document).on('click','.warehouse_pagination a', function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getDataWarehouseItems(page);
            //location.hash = page;
        });

        $(document).on('click','.stock_pagination a', function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getDataStockItems(page);
            //location.hash = page;
        });

        function getData(page){
           var searchVal = $('#search_inventory').val();
            var pageData = '';
            if(searchVal == ''){
                pageData = '?page=' + page;
            }else{
                pageData = '<?php echo url('search_inventory') ?>?page=' + page+'&searchVar='+searchVal;
            }

            $.ajax({
                url: pageData
            }).done(function(data){
                $('#reload_data').html(data);
            });
        }

        function getDataWarehouseItems(page){
            var whseId = $('whseId').val();
            $.ajax({
                url: '<?php echo url('warehouse_inventory') ?>?page=' + page +'&dataId='+whseId
            }).done(function(data){
                $('#reload_data').html(data);
            });
        }

        function getDataStockItems(page){
            var stockId = $('stockId').val();
            $.ajax({
                url: '<?php echo url('stock_inventory') ?>?page=' + page +'&dataId='+stockId
            }).done(function(data){
                $('#reload_data').html(data);
            });
        }

    </script>


    <script>
        //SUBMIT FORM WITH A FILE
        function saveInventory(formModal,formId,submitUrl,reload_id,reloadUrl,token,itemId,Qty,Amt){
            var form_get = $('#'+formId);
            var form = document.forms.namedItem(formId);
            var postVars = new FormData(form);
            postVars.append('token',token);

            var itemId1 = classToArray(itemId);
            var Qty1 = classToArray(Qty);
            var Amt1 = classToArray(Amt);
            var jItem = JSON.stringify(itemId1);
            var jQty = JSON.stringify(Qty1);
            var jAmt = JSON.stringify(Amt1);

            postVars.append('item_id',jItem);
            postVars.append('bom_qty',jQty);
            postVars.append('bom_amt',jAmt);
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

                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");

                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    reloadContent(reload_id,reloadUrl);
                }
            }

        }

    </script>

    <script>

        function saveMethod(formModal,formId,submitUrl,reload_id,reloadUrl,token,itemId,Qty,Amt) {
            var inputVars = $('#' + formId).serialize();
            var summerNote = '';
            var htmlClass = document.getElementsByClassName('t-editor');
            if (htmlClass.length > 0) {
                summerNote = $('.summernote').eq(0).summernote('code');

            }

            var itemId1 = classToArray2(itemId);
            var jItem = sanitizeData(itemId);
            var jQty = sanitizeData(Qty);
            var jAmt = sanitizeData(Amt);
            //alert(jinputClass);
            if(arrayItemEmpty(itemId1) == false){
                var postVars = inputVars + '&editor_input=' + summerNote+'&item_id='+jItem+'&bom_qty='+jQty+'&bom_amt='+jAmt;
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
                            //location.reload();

                        } else {

                            var infoMessage = swalWarningError(message2);
                            swal("Warning!", infoMessage, "warning");

                        }

                        //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                        reloadContent(reload_id,reloadUrl);
                    }
                }
                //END OF OTHER VALIDATION CONTINUES HERE
            }else{
                swal("Warning!","Please, fill in all required fields to continue","warning");
            }

        }


        function newWindow(dataId,displayId,submitUrl,token,modalId){
            //alert(dataId);
            var postVars = "dataId="+dataId;
            $('#'+modalId).modal('show');
            sendRequest(submitUrl,token,postVars)
            ajax.onreadystatechange = function(){
                if(ajax.readyState == 4 && ajax.status == 200) {

                    var ajaxData = ajax.responseText;
                    $('#'+displayId).html(ajaxData);

                }
            }
            $('#'+displayId).html('LOADING DATA');

        }

        function reloadContentId(id,intId,page){


            $.ajax({
                url: page+'?dataId='+intId
            }).done(function(data){
                $('#'+id).html(data);
            });

        }

    </script>

@endsection