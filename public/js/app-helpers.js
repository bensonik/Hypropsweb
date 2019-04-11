/**
 * Created by snweze on 11/8/2017.
 */

    const LoadingIcon = "public/icons/loading_icon.gif";

    function _(e){
        return document.getElementById(e);
    }

    var ajax = false;

    if (window.XMLHttpRequest){
        ajax= new XMLHttpRequest();
    }else if (window.ActiveXObject){
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
    }

    function sendRequest(linko,token,postVars){
        ajax.open("POST", linko, true);
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.setRequestHeader("X-CSRF-TOKEN", token);
        ajax.send(postVars);
    }

    function sendRequestForm(linko,token,postVars){
        ajax.open("POST", linko, true);
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.setRequestHeader("X-CSRF-TOKEN", token);
        ajax.send(postVars);

    }

    function sendRequestMediaForm(linko,token,postVars){
        ajax.open("POST", linko, true);
        ajax.setRequestHeader("X-CSRF-TOKEN", token);
        ajax.send(postVars);

    }

    function swalFormError(formError){
        var errorMessage = '';
         /*errorMessage += '<div class="alert alert-danger text-center alert-dismissable">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><ul>' +
            '<li style="list-style-type: none">';*/
        errorMessage += formError;
        /*errorMessage += "</ul></li></div></div>";*/
        return errorMessage;

    }

    function swalDefaultError(errorMessage){

        var info_div = '';
         /*info_div += '<div class="alert alert-danger">'+
            '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';*/
        info_div += errorMessage;
       /* info_div += '</div>';*/
        return info_div;

    }

    function swalWarningError(errorMessage){

        var info_div = '';
         /*info_div += '<div class="alert alert-info">'+
            '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';*/
        info_div += errorMessage;
        /*info_div += '</div>';*/
        return info_div;

    }

    function swalSuccess(successMessage){

        var info_div = '';
        /*info_div += '<div class="alert alert-info">'+
            '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';*/
        info_div += successMessage;
        /*info_div += '</div>';*/
        return info_div;

    }

    function phpValidationError(jsonObject){
        var validationErrors = "";
        for(var k in jsonObject) {
            if(jsonObject.hasOwnProperty(k)) {
                jsonObject[k].forEach(function(val)  {
                    validationErrors += val+', ';
                });
            }
        }
        return validationErrors;
    }

    function loopJson(jsonObject,val){
        var data = "";
        for(var k in jsonObject) {
            if(jsonObject.hasOwnProperty(k)) {
                //data += jsonObject[k];
                if (jsonObject[k] == val) {
                    data = val;
                }
            }
        }
        return data;
    }

    function checkArrItem(arr,val){
        var data = "";
        for(var i=0; i < arr.length; i++){
            if(arr[i] == val){
                data = val;
            }
        }

        return data;
    }

    //ADD GROUP OF CHECKED INPUT CHECKBOX INTO AN ARRAY
    function group_val(klass){

        var approve = document.getElementsByClassName(klass);
        var values = [];
        for(var i=0; i < approve.length; i++){
            if(approve[i].checked){
                values.push(approve[i].value);
            }
        }
        return values;
    }

    //toggle to check/uncheck all (this.id,class)
    function toggleme(master,one){
        var all = document.getElementsByClassName(one);
        for(var i=0; i < all.length; i++){
            did = document.getElementById(all[i].id);
            did.checked = master.checked;
        }
    }

    function filter_array(test_array) {
        var index = -1,
            arr_length = test_array ? test_array.length : 0,
            resIndex = -1,
            result = [];

        while (++index < arr_length) {
            var value = test_array[index];

            if (value) {
                result[++resIndex] = value;
            }
        }

        return result;
    }

    //CHECK IF ARRAY EXISTS TWICE
    function double(objects){
        var hold_objects = [];
        for(var i=0; i<objects.length;i++){
            for(var j=i+1; j<objects.length; j++){
                if(objects[j] == objects[i]){
                    hold_objects[i] = objects[j];
                }
            }
        }
        if(hold_objects.length > 0){
            return true;
        }else{
            return false;
        }
    }

    //CHECK IF ARRAY ITEM IS EMPTY
    function arrayItemEmpty(objects){
        var hold_objects = [];
        for(var i=0; i<objects.length;i++){
                if(objects[i] == ''){
                    hold_objects[i] = objects[i];
                }
        }
        if(hold_objects.length > 0){
            return true;
        }else{
            return false;
        }
    }

    //CATCH ALL DATA FROM INPUT WITH CSS CLASS
    function classToArray(getclass ){
        var objects = document.getElementsByClassName(getclass);
        var hold_objects = [];
        for(var i=0; i<objects.length;i++){
            if(objects[i].tagName === 'SELECT' || objects[i].tagName === 'INPUT'|| objects[i].tagName === 'TEXTAREA' )
            hold_objects[i] = objects[i].value;
        }
        return filter_array(hold_objects);
    }

    function classToArray2(getclass ){
        var objects = document.getElementsByClassName(getclass);
        var hold_objects = [];
        for(var i=0; i<objects.length;i++){
                hold_objects[i] = objects[i].value;
        }
        return filter_array(hold_objects);
    }

    function sanitizeData(data){
        var str = classToArray(data);
        var strJson = JSON.stringify(str);
        var newStr = encodeURIComponent(strJson);
        return newStr;
    }

    function hideClassItems(getclass){
        var objects = document.getElementsByClassName(getclass);
        for(var i=0; i<objects.length;i++){
            objects[i].style.visibility = 'hidden';
        }
    }

    function hideAllClassItems(getclass){
        var objects = getclass.split(',');
        for(var i=0; i<objects.length;i++){
           hideClassItems(objects[i]);
        }
    }

    function clearClassInputs(getclass){
        var objects = getclass.split(',');
        for(var i=0; i<objects.length;i++){
            objects[i].value = '';

        }
    }

    function removeClassInputs(getclass){
        var objects = getclass.split(',');
        for(var i=0; i<objects.length;i++){

            $('.' + objects[i]).remove();

        }
    }

    //CATCH ALL SELECTED DATA FROM MUTIPLE SELECT OPTIONS LIST AND PUSH TO AN ARRAY
    function mselectToArray(getid ){
        var objects = document.getElementById(getid);
        var values = [];
        for (var i = 0; i < objects.options.length; i++) {
            if (objects.options[i].selected) {
                values.push(objects.options[i].value);
            }
        }
        return values;
    }

    function reloadContent(id,page){


        $.ajax({
            url: page
        }).done(function(data){
            $('#'+id).html(data);
        });

    }

    function reloadContentId(id,page,dataId){


        $.ajax({
            url: page+'?dataId='+dataId
        }).done(function(data){
            $('#'+id).html(data);
        });

    }

    function submitDefault(formModal,formId,submitUrl,reload_id,reloadUrl,token){
        var inputVars = $('#'+formId).serialize();
        var summerNote = '';
        var htmlClass = document.getElementsByClassName('t-editor');
        if (htmlClass.length > 0) {
           summerNote = $('.summernote').eq(0).summernote('code');;
        }
        var postVars = inputVars+'&editor_input='+summerNote;
        //alert(postVars);
        $('#loading_modal').modal('show');
        $('#'+formModal).modal('hide');
        sendRequestForm(submitUrl,token,postVars)
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
                    swal("Success!", "Data saved successfully!", "success");

                }else if(message2 == 'token_mismatch'){

                    location.reload();

                }else {
                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");
                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContent(reload_id,reloadUrl);
            }
        }

    }

    //SUBMIT FORM WITH A FILE
    function submitMediaForm(formModal,formId,submitUrl,reload_id,reloadUrl,token){
        var form_get = $('#'+formId);
        var form = document.forms.namedItem(formId);
        var postVars = new FormData(form);
        postVars.append('token',token);
        $('#loading_modal').modal('show');
        $('#'+formModal).modal('hide');
        sendRequestMediaForm(submitUrl,token,postVars);
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

                }else if(message2 == 'token_mismatch'){

                    location.reload();

                }else {
                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");
                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContent(reload_id,reloadUrl);
            }
        }

    }

    function searchReport(formId,submitUrl,reload_id,reloadUrl,token){
        var inputVars = $('#'+formId).serialize();
        var summerNote = '';
        var htmlClass = document.getElementsByClassName('t-editor');
        if (htmlClass.length > 0) {
            summerNote = $('.summernote').eq(0).summernote('code');;
        }
        var postVars = inputVars+'&editor_input='+summerNote;
        $('#loading_modal').modal('show');
        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {

                $('#loading_modal').modal('hide');
                var result = ajax.responseText;
                $('#'+reload_id).html(result);

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS

            }
        }

    }

    //SUBMIT FORM TO REMOVE ATTACHED FILE FROM EDIT FORM
    function removeMediaForm(hideId,formId,submitUrl,reload_id,reloadUrl,token){
        var form_get = $('#'+formId);
        var form = document.forms.namedItem(formId);
        var postVars = new FormData(form);
        postVars.append('token',token);
        $('#loading_modal').modal('show');
        sendRequestMediaForm(submitUrl,token,postVars);
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
                    $('#'+hideId).remove();

                }else if(message2 == 'token_mismatch'){

                    location.reload();

                }else {
                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");
                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContent(reload_id,reloadUrl);
            }
        }

    }

    function fillNextInput(value_id,displayId,page,moduleType){
            var pickedVal = $('#'+value_id).val();

            $.ajax({
                url:  page+'?pickedVal='+pickedVal+'&type='+moduleType
            }).done(function(data){
                $('#'+displayId).html(data);
            });
        }

    function fillNextInputParam(value_id,displayId,page,moduleType,param){
        var pickedVal = $('#'+value_id).val();

        $.ajax({
            url:  page+'?pickedVal='+pickedVal+'&type='+moduleType+'&param='+param
        }).done(function(data){
            $('#'+displayId).html(data);
        });
    }

    function searchOptionList(searchId,listId,page,moduleType,hiddenId){
        var pickedValGet = $('#'+searchId);
        var pickedVal = pickedValGet.val();
        var hiddenValGet = $('#'+hiddenId);
        if(pickedVal == ''){
            hiddenValGet.val('');
        }
        $('#'+listId).show();
        $.ajax({
            url:  page+'?pickedVal='+pickedVal+'&type='+moduleType+'&hiddenId='+hiddenId+'&listId='+listId+'&searchId='+searchId
        }).done(function(data){
            $('#'+listId).html(data);
        });
    }

    function dropdownItem(valDisplayId,val,hiddenValId,hiddenVal,dropdownId) {
        $("#"+valDisplayId).val(val);
        $("#"+hiddenValId).val(hiddenVal);
        $("#"+dropdownId).hide();
    }

    function dropdownItemRep(valDisplayId,val,hiddenValId,hiddenVal,dropdownId,newDisplayId,moduleType,page) {
        $("#"+valDisplayId).val(val);
        $("#"+hiddenValId).val(hiddenVal);
        $("#"+dropdownId).hide();
        fillNextInput(hiddenVal,newDisplayId,page,moduleType)
    }

    function addMore(more_id,hide_button,num,page,type,hideButtonId){

        var hide_id = document.getElementById(hide_button);
        //alert(page+'?num='+num+'&type='+type+'&add_id='+addButtonId+'&hide_id='+hideButtonId);
        $.ajax({
            url:  page+'?num='+num+'&type='+type+'&add_id='+more_id+'&hide_id='+hideButtonId
        }).done(function(data){

            hide_id.style.display = 'none';
            $('#'+more_id).append(data);
        });
    }

    function removeInput(show_id,ghost_class,addUrl,type,all_new_fields_class,unique_num,addButtonId,hideButtonId) {
        var get_class = document.getElementsByClassName(all_new_fields_class);
        //var currAddId = _('hide_button'+unique_num);
        //var prevNum = unique_num - 1;
        //var prevAddId = _('hide_button'+prevNum);
        var addButtons = document.getElementsByClassName('addButtons');
        if(addButtons.length < 1 ) {

            if (addButtons.length < 1) {
            prevAddId.style.display = 'block';
            }
        }
        $('.' + ghost_class).remove();
        /*for (var i = 0; i < get_class.length; i++) {
            //get_class[i].parentNode.removeChild(get_class[i]);
        }*/
        //var show_all = document.getElementById(show_id);
        var show_all = document.getElementById(hideButtonId);
        var show_button = '';

        show_button += '<tr><td></td><td></td><td></td><td>';
        show_button += '<div style="cursor: pointer;" onclick="addMore(';

        show_button += "'"+addButtonId+"','"+hideButtonId+"','1','" + addUrl + "','"+type+"','"+hideButtonId+"');";
        show_button += '">';
        show_button += '<i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i></div>';
        show_button += '</tr>';
        if (get_class.length === 0) {

        show_all.innerHTML =show_button;
        show_all.style.display = 'block';
        }
    }

    function hideAddedInputs(getclass,addButtonId,hideButtonId,addUrl,type,hideButtonId){
        var objects = document.getElementsByClassName(getclass);
        for(var i=0; i<objects.length;i++){
            objects[i].style.visibility = 'hidden';
            console.log(objects[i]);
        }
        var show_all = document.getElementById(addButtonId);
        var show_button = '';

        show_button += '<tr><td></td><td></td><td></td><td>';
        show_button += '<div style="cursor: pointer;" onclick="addMore(';

        show_button += "'"+addButtonId+"','"+hideButtonId+"','1','" + addUrl + "','"+type+"','"+hideButtonId+"');";
        show_button += '">';
        show_button += '<i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i></div>';
        show_button += '</tr>';

        show_all.innerHTML =show_button;
        show_all.style.display = 'block';

    }

    function hideAddedInputs2(getclass,addButtonId,hideButtonId,addUrl,type){
        var objects = document.getElementsByClassName(getclass);
        for(var i=0; i<objects.length;i++){
            objects[i].style.display = 'none';
            console.log(objects[i]);
        }
        var show_all = document.getElementById(hideButtonId);
        var show_button = '';

        show_button += '<tr><td></td><td></td><td></td><td>';
        show_button += '<div style="cursor: pointer;" onclick="addMore(';

        show_button += "'"+addButtonId+"','"+hideButtonId+"','1','" + addUrl + "','"+type+"','"+hideButtonId+"');";
        show_button += '">';
        show_button += '<i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i></div>';
        show_button += '</td></tr>';

        //show_all.innerHTML =show_button;
        show_all.style.display = 'block';

    }

    function deleteEntry(klass,reloadId,reloadUrl,submitUrl,token){
        var data_string = group_val(klass);
        var all_data = JSON.stringify(data_string);
        var postVars = "all_data="+all_data;
        $('#loading_modal').modal('show');
        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {
                $('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalDefaultError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'deleted'){

                    var successMessage = swalSuccess(rollback.message);
                    swal("Success!", successMessage, "success");

                }else{

                    var infoMessage = swalWarningError(message2);
                    swal("Success!", infoMessage, "warning");

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContent(reloadId,reloadUrl);
            }
        }


    }

    function deleteEntryFetchId(klass,reloadId,reloadUrl,submitUrl,token,dataId){
        var data_string = group_val(klass);
        var all_data = JSON.stringify(data_string);
        var postVars = "all_data="+all_data;
        $('#loading_modal').modal('show');
        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {
                $('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalDefaultError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'deleted'){

                    var successMessage = swalSuccess(rollback.message);
                    swal("Success!", successMessage, "success");

                }else{

                    var infoMessage = swalWarningError(message2);
                    swal("Success!", infoMessage, "warning");

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContentId(reloadId,reloadUrl,dataId);
            }
        }


    }

    function changeStatusMethod(klass,reloadId,reloadUrl,submitUrl,token,status){
        var data_string = group_val(klass);
        var all_data = JSON.stringify(data_string);
        var postVars = "all_data="+all_data+"&status="+status;
        $('#loading_modal').modal('show');
        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {
                $('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalDefaultError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'deleted'){

                    var successMessage = swalSuccess(rollback.message);
                    swal("Success!", successMessage, "success");

                }else{

                    var infoMessage = swalWarningError(message2);
                    swal("Success!", infoMessage, "warning");

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContent(reloadId,reloadUrl);
            }
        }


    }

    function changeStatusMethodForm(klass,reloadId,reloadUrl,submitUrl,token,status,formId){
        var inputVars = $('#'+formId).serialize();
        var data_string = group_val(klass);
        var all_data = JSON.stringify(data_string);
        var postVars = inputVars+"&all_data="+all_data+"&status="+status;
        //alert(postVars);
        $('#loading_modal').modal('show');
        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {
               //console.log(submitUrl);
                $('#loading_modal').modal('hide');

                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalDefaultError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'deleted' || message2 == 'saved'){

                    var successMessage = swalSuccess(rollback.message);
                    swal("Success!", successMessage, "success");

                }else{

                    var infoMessage = swalWarningError(message2);
                    swal("Success!", infoMessage, "warning");

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContent(reloadId,reloadUrl);
            }
        }


    }

    function changeStatusMethodInput(klass,reloadId,reloadUrl,submitUrl,token,status,input){
        var data_string = group_val(klass);
        var all_data = JSON.stringify(data_string);
        var postVars = "all_data="+all_data+"&status="+status+"&input_text="+input;
        $('#loading_modal').modal('show');
        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {
                $('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalDefaultError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'deleted'){

                    var successMessage = swalSuccess(rollback.message);
                    swal("Success!", successMessage, "success");

                }else{

                    var infoMessage = swalWarningError(message2);
                    swal("Success!", infoMessage, "warning");

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContent(reloadId,reloadUrl);
            }
        }


    }

    function deleteItems(klass,reloadId,reloadUrl,submitUrl,token) {
        var items = group_val(klass);
        if (items.length > 0){
            swal({
                    title: "Are you sure you want to delete?",
                    text: "You will not be able to recover this data entry!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel delete!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        deleteEntry(klass, reloadId, reloadUrl, submitUrl, token);
                        swal("Deleted!", "Your item(s) has been deleted.", "success");
                    } else {
                        swal("Delete Cancelled", "Your data is safe :)", "error");
                    }
                });

            }else{
                alert('Please select an entry to continue');
        }

    }

    function deleteItemsFetchId(klass,reloadId,reloadUrl,submitUrl,token,dataId) {
        var items = group_val(klass);
        if (items.length > 0){
            swal({
                    title: "Are you sure you want to delete?",
                    text: "You will not be able to recover this data entry!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel delete!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        deleteEntryFetchId(klass, reloadId, reloadUrl, submitUrl, token,dataId);
                        swal("Deleted!", "Your item(s) has been deleted.", "success");
                    } else {
                        swal("Delete Cancelled", "Your data is safe :)", "error");
                    }
                });

        }else{
            alert('Please select an entry to continue');
        }

    }

    function changeStatus(klass,reloadId,reloadUrl,submitUrl,token,status) {
        var items = group_val(klass);
        if (items.length > 0){
            swal({
                    title: "Are you sure you want to change status ?",
                    text: "This will enable/disable a user from login!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel change!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        changeStatusMethod(klass, reloadId, reloadUrl, submitUrl, token,status);
                        swal("Deleted!", "Status of selected item(s) have been changed.", "success");
                    } else {
                        swal("Status change Cancelled", "Status remains the same :)", "error");
                    }
                });

        }else{
            alert('Please select an entry to continue');
        }

    }

    function warehousePost(klass,reloadId,reloadUrl,submitUrl,token,status,category) {
        var items = group_val(klass);
        if (items.length > 0){
            swal({
                    title: "Are you sure you want to "+category+" ?",
                    text: "This will permanently "+category+"!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel change!",
                    closeOnConfirm: true,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        changeStatusMethod(klass, reloadId, reloadUrl, submitUrl, token,status);
                        //swal("Processed!", "process complete.", "success");
                    } else {
                        swal(" Cancelled", category, "error");
                    }
                });

        }else{
            alert('Please select an entry to continue');
        }

    }

    function changeItemStatus(klass,reloadId,reloadUrl,submitUrl,token,status) {
        var items = group_val(klass);
        if (items.length > 0){
            swal({
                    title: "Are you sure you want to change status ?",
                    text: "This will enable/disable item!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel change!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        changeStatusMethod(klass, reloadId, reloadUrl, submitUrl, token,status);
                        swal("Deleted!", "Status of selected item(s) have been changed.", "success");
                    } else {
                        swal("Status change Cancelled", "Status remains the same :)", "error");
                    }
                });

        }else{
            alert('Please select an entry to continue');
        }

    }



    function changeCurrencyStatus(klass,reloadId,reloadUrl,submitUrl,token,status) {
            var items = group_val(klass);
            if (items.length > 0){
                swal({
                        title: "Are you sure you want to change status ?",
                        text: "This will enable selected currency active!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, change it!",
                        cancelButtonText: "No, cancel change!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            changeStatusMethod(klass, reloadId, reloadUrl, submitUrl, token,status);
                            swal("Deleted!", "Status of selected item(s) have been changed.", "success");
                        } else {
                            swal("Status change Cancelled", "Status remains the same :)", "error");
                        }
                    });

            }else{
                alert('Please select an entry to continue');
            }

        }

    function changeDataStatus(klass,reloadId,reloadUrl,submitUrl,token,status) {
        var items = group_val(klass);
        if (items.length > 0){
            swal({
                    title: "Are you sure you want to change status ?",
                    text: "This will enable selected data active!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel change!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        changeStatusMethod(klass, reloadId, reloadUrl, submitUrl, token,status);
                        swal("Deleted!", "Status of selected item(s) have been changed.", "success");
                    } else {
                        swal("Status change Cancelled", "Status remains the same :)", "error");
                    }
                });

        }else{
            alert('Please select an entry to continue');
        }

    }

    function changeAppraisalStatus(klass,reloadId,reloadUrl,submitUrl,token,status) {
        var items = group_val(klass);
        if (items.length > 0){
            swal({
                    title: "Are you sure you want to change status ?",
                    text: "This will change appraisal status from ongoing to complete!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel change!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        changeStatusMethod(klass, reloadId, reloadUrl, submitUrl, token,status);
                        swal("Deleted!", "Status of selected item(s) have been changed.", "success");
                    } else {
                        swal("Status change Cancelled", "Status remains the same :)", "error");
                    }
                });

        }else{
            alert('Please select an entry to continue');
        }

    }

    function processPayroll(klass,reloadId,reloadUrl,submitUrl,token,status,formId) {
        var items = group_val(klass);
        if (items.length > 0){
            swal({
                    title: "Are you sure you want to change status ?",
                    text: "This will change status of selected data!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel change!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        changeStatusMethodForm(klass, reloadId, reloadUrl, submitUrl, token,status,formId);
                        swal("Changed!", "Status of selected item(s) have been changed.", "success");
                    } else {
                        swal("Status change Cancelled", "Status remains the same :)", "error");
                    }
                });

        }else{
            alert('Please select an entry to continue');
        }

    }

    function approveFinanceRequest(klass,reloadId,reloadUrl,submitUrl,token,status) {
        var items = group_val(klass);
        if (items.length > 0){
            swal({
                    title: "You are about to complete these request(s) ?",
                    text: "Do you with to continue!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel change!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        changeStatusMethod(klass, reloadId, reloadUrl, submitUrl, token,status);
                        swal("Processed!", "Request(s) have been processed.", "success");
                    } else {
                        swal("Cancelled", "Request processing Cancelled :)", "error");
                    }
                });

        }else{
            alert('Please select an entry to continue');
        }

    }

    function editForm(dataId,displayId,submitUrl,token){

        var postVars = "dataId="+dataId;
        $('#editModal').modal('show');
        sendRequest(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {

                var ajaxData = ajax.responseText;
                $('#'+displayId).html(ajaxData);

            }
        }
        $('#'+displayId).html('LOADING DATA');

    }

    function convertForm(dataId,displayId,submitUrl,token,modalId,hideContent){
        var dataVal = $('#'+dataId).val();
        if(dataVal != ''){
            $('#edit_content').html('');
            if(hideContent != ''){
                $('#'+hideContent).html('');
            }
            var postVars = "dataId="+dataVal;
            $('#'+modalId).modal('show');
            sendRequest(submitUrl,token,postVars)
            ajax.onreadystatechange = function(){
                if(ajax.readyState == 4 && ajax.status == 200) {

                    var ajaxData = ajax.responseText;
                    $('#'+displayId).html(ajaxData);

                }
            }
            $('#'+displayId).html('LOADING DATA');

        }else{
            swal("Warning!", "Ensure to select an item from the dropdown.", "warning");
        }


    }

    function editTransactForm(dataId,displayId,submitUrl,token,currencyClass,vendorCustCurrPage,vendorId,billAddress,currRate,formContent1,formContent2){

        var postVars = "dataId="+dataId;

        if(formContent1 != ''){
            $('#'+formContent1).html('');
        }
        if(formContent2 != ''){
            $('#'+formContent2).html('');
        }
        $('#editModal').modal('show');
        sendRequest(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {

                var ajaxData = ajax.responseText;
                $('#'+displayId).html(ajaxData);
                fetchVendCustCurr(vendorId,currencyClass,vendorCustCurrPage,billAddress,currRate)

            }
        }
        $('#'+displayId).html('LOADING DATA');

    }

    function fetchHtml(dataId,displayId,modalId,submitUrl,token){

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

    function fetchHtml2(dataId,displayId,modalId,submitUrl,token,type){

        var postVars = "dataId="+dataId+"&type="+type;
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

    function searchItem(inputId,displayId,submitUrl,defaultUrl,token){

        var searchInput = $('#'+inputId).val();
        var postVars = "?searchVar="+searchInput;
        //alert(postVars);
        if(searchInput != '') {
            $.ajax({
                url: submitUrl + postVars
            }).done(function (data) {
                $('#' + displayId).html(data);
            });
            $('#' + displayId).html('LOADING DATA');
        }else{
            reloadContent('reload_data',defaultUrl)
        }

    }

    function print_content(el){
        var restorepage = document.body.innerHTML;

        var printcontent = document.getElementById(el).outerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        window.close();
        document.body.innerHTML = restorepage;
        location.reload();
    }

    function print_table(divdata)
    {
        var divToPrint=document.getElementById(divdata);
        newWin= window.open("");

        newWin.document.write(divToPrint.outerHTML);
        newWin.print();
        newWin.close();
    }

    $(function() {
        $( ".datepickers" ).datepicker({
            changeMonth: true,
            changeYear: true
        });
    });

    $(document).ready(function() {
        $('.summernote').summernote();
    });

    var db, isfullscreen = false;
    function toggleFullScreen(){
        db = document.body;
        if(isfullscreen == false){
            if(db.requestFullScreen){
                db.requestFullScreen();
            } else if(db.webkitRequestFullscreen){
                db.webkitRequestFullscreen();
            } else if(db.mozRequestFullScreen){
                db.mozRequestFullScreen();
            } else if(db.msRequestFullscreen){
                db.msRequestFullscreen();
            }
            isfullscreen = true;
            //wrap.style.width = window.screen.width+"px";
            //wrap.style.height = window.screen.height+"px";
        } else {
            if(document.cancelFullScreen){
                document.cancelFullScreen();
            } else if(document.exitFullScreen){
                document.exitFullScreen();
            } else if(document.mozCancelFullScreen){
                document.mozCancelFullScreen();
            } else if(document.webkitCancelFullScreen){
                document.webkitCancelFullScreen();
            } else if(document.msExitFullscreen){
                document.msExitFullscreen();
            }
            isfullscreen = false;
            wrap.style.width = "100%";
            //wrap.style.height = "auto";
            //wrap.style.overflow = "scroll";
        }
    }

    function getCurrency(page,token){

        setInterval(function(){
            $.ajax({
                url: 'http://www.apilayer.net/api/live?access_key=57d1e605533a2efddb58968de322110c'
            }).done(function(data){
                var jsonString = JSON.stringify(data);
                postCurrency(page,jsonString,token);
            });
        },3600000)



    }

    function postCurrency(page,jsonCurrency,token){
        var postVars = 'currency='+jsonCurrency;
        sendRequestForm(page,token,postVars);
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {
                var result = ajax.responseText;
                //alert(result);
                }
            }
    }

    function RequestApproval(klass,reloadId,reloadUrl,submitUrl,token,status) {
        var items = group_val(klass);
        if (items.length > 0) {
            if(status == 1){
            swal({
                    title: "Are you sure you want to approve this request(s) ?",
                    text: "You won't be able to deny after approval!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel change!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        changeStatusMethod(klass, reloadId, reloadUrl, submitUrl, token, status);
                        swal("Approved!", "Selected request(s) have been approved.", "success");
                    } else {
                        swal("Approval Cancelled", "Requests remains unchanged :)", "error");
                    }
                });
            } else{ //END OF IF STATUS IS FOR APPROVAL AND NOT DENIAL

                swal({
                        title: "Are you sure you want to deny this request(s) ?",
                        text: "Reason for denial!",
                        type: "input",
                        inputPlaceholder: "Reason for denial",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, change it!",
                        cancelButtonText: "No, cancel!",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    },
                    function (denyReason) {
                        if (denyReason === false) return false;
                            if (denyReason  != '') {
                            changeStatusMethodInput(klass, reloadId, reloadUrl, submitUrl, token, status, denyReason);
                            swal("Approved!", "Selected request(s) have been denied.", "success");
                        } else {
                            swal.showInputError("Please enter reason for denial");
                                return false
                        }
                    });

            }  //END OF IF STATUS IS FOR DENIAL AND NOT APPROVAL

        }else{
            alert('Please select an entry to continue');
        }

    }

    function deleteChartAccount(klass,reloadId,reloadUrl,submitUrl,token,status) {
    var items = group_val(klass);
    if (items.length > 0) {
        if(status == 1){
            swal({
                    title: "Are you sure you want to delete this account(s) ?",
                    text: "You won't be able to retrieve after approval!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel change!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        changeStatusMethod(klass, reloadId, reloadUrl, submitUrl, token, status);
                        swal("Deleted!", "Selected account(s) have been deleted.", "success");
                    } else {
                        swal("Delete Cancelled", "Account remains unchanged :)", "error");
                    }
                });
        } else{ //END OF IF STATUS IS FOR APPROVAL AND NOT DENIAL

            swal({
                    title: "PLEASE IGNORE PASSWORD IF ACCOUNTS LAST TRANSACTION DATE IS AFTER THAT OF THE CLOSING BOOKS",
                    text: "Password (Enter Password)",
                    type: "input",
                    inputPlaceholder: "Enter Password",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, remove!",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: false,
                    closeOnCancel: true
                },
                function (denyReason) {
                    if (denyReason === false) return false;
                    if (denyReason  != '') {
                        changeStatusMethodInput(klass, reloadId, reloadUrl, submitUrl, token, status, denyReason);
                        swal("Deleted!", "Selected account(s) have been deleted.", "success");
                    } else {
                        changeStatusMethodInput(klass, reloadId, reloadUrl, submitUrl, token, status, denyReason);
                        swal("Deleted!", "Selected account(s) have been deleted.", "success");
                    }
                });

        }  //END OF IF STATUS IS FOR DENIAL AND NOT APPROVAL

    }else{
        alert('Please select an entry to continue');
    }

}

    function sumArray(input){

        if (toString.call(input) !== "[object Array]")
            return false;

        var total =  0;
        for(var i=0;i<input.length;i++)
        {
            if(isNaN(input[i])){
                continue;
            }
            total += Number(input[i]);
        }
        return total;
    }

    function sumArrayItems(input){

        if (toString.call(input) !== "[object Array]")
            return false;

        var total =  0;
        for(var i=0;i<input.length;i++)
        {
            if(isNaN(input[i])){
                continue;
            }
            total += Number(input[i]);
        }
        return total;
    }

    function decPoints(param,decP){
        return parseFloat(param).toFixed(decP);
    }


    function permDelete(bomId,page,bomIdVal){
            var bomVal = $('#'+bomIdVal).val();
                $.ajax({
                    url: page+'?dataId='+bomVal
                }).done(function(data){
                    $('#'+bomId).remove();
                    swal("Warning!", 'Item removed successfully', "success");

                });


        }

    function permDeleteData(bomId,page,dataVal){

        $.ajax({
            url: page+'?dataId='+dataVal
        }).done(function(data){
            $('#'+bomId).remove();
            swal("Warning!", 'Item removed successfully', "success");

        });


    }

        //////////////////////////// ITEM AND ACCOUNT METHODS INVOLVED IN CALCULATION OF VARIOUS INPUT AMOUNT FIELDS ////////////////

//SHOW EXCHANGE RATE EQUIVALENT TO DEFAULT CURRENCY AT A PARTICULAR DATE
    function exchangeRate(vendorId,exRateId,postDateId,page){

        setInterval(function(){
            var vendorVal = $('#'+vendorId).val();
            var postDate = $('#'+postDateId).val();
            //alert(vendorVal);
            if(vendorVal != ''){
                $.ajax({
                    url: page+'?post_date=' + postDate+'&search_id='+vendorVal
                }).done(function(data){
                    $('#'+exRateId).val(data.rate);
                });
            }
        },2000)

    }

    function exclTax(totalAmtId,totalTaxId,exclTaxId){
        var totalAmt = $('#'+totalAmtId);
        var totalTax = $('#'+totalTaxId);
        var taxVal = (totalTax.val() == '') ? 0.00 : totalTax.val();
        var newAmt = parseFloat(totalAmt.val())+parseFloat(taxVal);
        $('#'+exclTaxId).val(decPoints(newAmt,2));
    }

    function searchOptionListAcc(searchId,listId,page,moduleType,hiddenId,vendCustId,postDateId){
        var pickedVal = $('#'+searchId).val();
        var vendCustVal = $('#'+vendCustId).val();
        var postDate = $('#'+postDateId).val();
        if(vendCustVal != '' && postDate != ''){

            $('#'+listId).show();
            $.ajax({
                url:  page+'?pickedVal='+pickedVal+'&type='+moduleType+'&hiddenId='+hiddenId+'&listId='+listId+'&searchId='+searchId
            }).done(function(data){
                $('#'+listId).html(data);
            });

        }else{
            swal("Warning!", 'Please Select Vendor/Customer and posting date to continue', "warning");
        }

    }

    function searchOptionListVenCust(searchId,listId,page,moduleType,hiddenId,currencyClass,currPage,overallSumId,contactType,vendCustId,postDateId,billAddress,currRate,foreignOverallSum){
        var pickedVal = $('#'+searchId).val();
        $('#'+listId).show();
        $.ajax({
            url:  page+'?pickedVal='+pickedVal+'&type='+moduleType+'&hiddenId='+hiddenId+'&listId='+listId+'&searchId='+searchId+'&overallSumId='+overallSumId+'&contactType='+contactType+'&currencyClass='+currencyClass+'&vendCustId='+vendCustId+'&postDateId='+postDateId+'&billAddress='+billAddress+'&currRate='+currRate+'&foreignOverallSum='+foreignOverallSum
        }).done(function(data){
            $('#'+listId).html(data);
        });
    }

    function searchOptionListInventory(searchId,listId,page,moduleType,hiddenId,descId,rateId,unitMId,subTotalId,sharedSumClass,overallSumId,foreignCurrId,qtyId,vendCustId,postDateId,totalTaxId,billInvoice){
        var pickedVal = $('#'+searchId).val();
        $('#'+listId).show();
        var vendCustVal = $('#'+vendCustId).val();
        var postDate = $('#'+postDateId).val();
        if(vendCustVal != '' && postDate != ''){
        $.ajax({
            url:  page+'?pickedVal='+pickedVal+'&type='+moduleType+'&hiddenId='+hiddenId+'&listId='+listId+'&searchId='+searchId+'&descId='+descId+'&rateId='+rateId+'&unitMId='+unitMId+'&subTotalId='+subTotalId+'&sharedSubTotal='+sharedSumClass+'&overallSum='+overallSumId+'&foreignOverallSum='+foreignCurrId+'&qtyId='+qtyId+'&vendCustId='+vendCustId+'&postDateId='+postDateId+'&totalTaxId='+totalTaxId+'&billInvoice='+billInvoice
        }).done(function(data){
            $('#'+listId).html(data);

        });

        }else{
            swal("Warning!", 'Please Select Vendor/Customer and posting date to continue', "warning");
        }
    }

    function fetchVendCustCurr(searchId,currencyClass,page,billAddress,currRate) {
        var pickedVal = $('#'+searchId).val();
        $.ajax({
            url:  page+'?search_id='+pickedVal
        }).done(function(data){
            var all = document.getElementsByClassName(currencyClass);
            for(var i=0; i < all.length; i++){
                var column = all[i];
                column.innerHTML = data.currency;
            }
            $('#'+billAddress).val(data.billing_address);
            $('#'+currRate).val(data.rate);
            //console.log(billAddress+'curr='+data.billing_address);

        });

    }

    function fetchInventory(searchId,bill_invoice,page,descId,rateId,unitMId,subTotalId,sharedSumClass,overallSumId,foreignCurrId,defaultCurrPage,qtyId,vendorCustId,postDateId,totalTaxId) {
        var pickedVal = $('#'+searchId).val();


            $.ajax({
                url:  page+'?search_id='+pickedVal+'&bill_invoice'+bill_invoice
            }).done(function(data){

                $('#'+descId).val(data.item_desc);
                $('#'+rateId).val(decPoints(data.rate,2));
                $('#'+unitMId).val(data.unit_measure);
                $('#'+subTotalId).val(decPoints(data.rate,2));
                $('#'+qtyId).val('1');

                var sumToArray = classToArray2(sharedSumClass);
                var sumArray = sumArrayItems(sumToArray);

                $('#'+overallSumId).val(decPoints(sumArray,2));
                exclTax(overallSumId,totalTaxId,'excl_'+overallSumId);

                convertToDefaultCurr(foreignCurrId,overallSumId,defaultCurrPage,vendorCustId,postDateId)

            });

    }

    function getItemRate(itemId,page,qtyId,rateId){
        var pickedVal = $('#'+itemId).val();
        var qtyVal = $('#'+qtyId).val();
        var rate = $('#'+rateId);
        if(pickedVal != ''){
            $.ajax({
                url:  page+'?itemId='+pickedVal
            }).done(function(data){
                var result = data.rate;
                rate.val(decPoints(result*qtyVal,2));
            });
        }
    }

    function itemSum(amountId,rateId,itemId,qtyId,discountAmountId,taxAmountId,sharedSumClass,overallSumId,foreignCurrId,defaultCurrPage,ratePage,taxSharedClass,discountSharedClass,totalTax,totalDiscount,vendorCustId,postDateId,taxPerctId,discountPerctId){

        if(event.target.id == qtyId){

            //BEGINING
            var pickedVal = $('#'+itemId).val();


            if(pickedVal != ''){
                $.ajax({
                    url:  ratePage+'?itemId='+pickedVal
                }).done(function(data){
                    var result = data.rate;
                    var qty = $('#'+qtyId);
                    var qtyVal = qty.val();
                    var rateGet = $('#'+rateId);

                    //rateGet.val(result*qtyVal);

                    var amount = $('#'+amountId);
                    //var rate = data.rate;
                    var rate = rateGet.val();

                    var item = $('#'+itemId).val();
                    var discount = $('#'+discountAmountId);
                    var tax = $('#'+taxAmountId);
                    var discountPerct = $('#'+discountPerctId);
                    var taxPerct = $('#'+taxPerctId);

                    var qtyVal = (qty.val() != '') ? qty.val() : 0;
                    var real_amount = qtyVal*rate;

                    var discountVal = (discount != '') ? discount.val() : 0;
                    var discountPerctVal = (discountPerct.val()/100)*real_amount;
                    var discountA = (discountPerct.val() == '') ? discountVal: discountPerctVal ;
                    var taxVal = (tax.val() != '') ? tax.val() : 0;
                    var taxPerctVal = (taxPerct.val()/100)*real_amount;
                    var taxA = (taxPerct.val() == '') ? taxVal: taxPerctVal ;
                    discount.val(decPoints(discountA,2));
                    tax.val(decPoints(taxA,2));



                    var new_amount = (real_amount-discountA) - taxA;
                    amount.val(decPoints(new_amount,2));
                    var sumToArray = classToArray(sharedSumClass);
                    var sumArray = sumArrayItems(sumToArray);
                    $('#'+overallSumId).val(decPoints(sumArray,2));

                    //ALWAYS GET SUM OF ALL TAXES AND ALLOWANCES AND DISPLAY THEIR AMOUNTS IN TOTAL DISCOUNTS AND TAXES
                    var totalDiscountGet = $('#'+totalDiscount);
                    var totalTaxGet = $('#'+totalTax);
                    var sumToArrayTax = classToArray(taxSharedClass);
                    var sumArrayTax = sumArrayItems(sumToArrayTax);
                    var sumToArrayDiscount = classToArray(discountSharedClass);
                    var sumArrayDiscount = sumArrayItems(sumToArrayDiscount);
                    totalDiscountGet.val(decPoints(sumArrayDiscount,2));
                    totalTaxGet.val(decPoints(sumArrayTax,2));
                    exclTax(overallSumId,totalTax,'excl_'+overallSumId);
                    convertToDefaultCurr(foreignCurrId,overallSumId,defaultCurrPage,vendorCustId,postDateId)

                });
            }else{
                swal("Warning!", 'Please Select an item and enter quantity to continue', "warning");
            }
            //getItemRate(itemId,ratePage,qtyId,rateId);

            //END

        }else{

            //BEGINING
            var amount = $('#'+amountId);
            var rateGet = $('#'+rateId);
            var rate = rateGet.val();
            var item = $('#'+itemId).val();
            var discount = $('#'+discountAmountId);
            var discountPerct = $('#'+discountPerctId);
            var tax = $('#'+taxAmountId);
            var taxPerct = $('#'+taxPerctId);
            var qty = $('#'+qtyId);

            var qtyVal = (qty.val() != '') ? qty.val() : 0;
            var real_amount = qtyVal*rate;

            var discountVal = (discount != '') ? discount.val() : 0;
            var discountPerctVal = (discountPerct.val()/100)*real_amount;
            var discountA = (discountPerct.val() == '') ? discountVal: discountPerctVal ;
            var taxVal = (tax.val() != '') ? tax.val() : 0;
            var taxPerctVal = (taxPerct.val()/100)*real_amount;
            var taxA = (taxPerct.val() == '') ? taxVal: taxPerctVal ;
            discount.val(decPoints(discountA,2));
            tax.val(decPoints(taxA,2));
            console.log(taxPerct.val());

            if(rate != '' && item != ''){
                //var real_amount = (event.target.id == qtyId) ? rate : qtyVal*rate;
                var new_amount = (real_amount-discountA) - taxA;
                amount.val(decPoints(new_amount,2));
                var sumToArray = classToArray(sharedSumClass);
                var sumArray = sumArrayItems(sumToArray);
                $('#'+overallSumId).val(decPoints(sumArray,2));

                //ALWAYS GET SUM OF ALL TAXES AND ALLOWANCES AND DISPLAY THEIR AMOUNTS IN TOTAL DISCOUNTS AND TAXES
                var totalDiscountGet = $('#'+totalDiscount);
                var totalTaxGet = $('#'+totalTax);
                var sumToArrayTax = classToArray(taxSharedClass);
                var sumArrayTax = sumArrayItems(sumToArrayTax);
                var sumToArrayDiscount = classToArray(discountSharedClass);
                var sumArrayDiscount = sumArrayItems(sumToArrayDiscount);
                totalDiscountGet.val(decPoints(sumArrayDiscount,2));
                totalTaxGet.val(decPoints(sumArrayTax,2));
                exclTax(overallSumId,totalTax,'excl_'+overallSumId);
                convertToDefaultCurr(foreignCurrId,overallSumId,defaultCurrPage,vendorCustId,postDateId);

            }else{
                swal("Warning!", 'Please Select an item and enter quantity to continue', "warning");
            }
            // END

        }

    }

    function accountSum(amountId,accountId,rateId,discountAmountId,taxAmountId,sharedSumClass,overallSumId,foreignCurrId,defaultCurrPage,taxSharedClass,discountSharedClass,totalTax,totalDiscount,vendorCustId,postDateId,taxPerctId,discountPerctId){
        var amount = $('#'+amountId);
        var rate = $('#'+rateId).val();
        var account = $('#'+accountId);
        var discount = $('#'+discountAmountId);
        var discountPerct = $('#'+discountPerctId);
        var taxPerct = $('#'+taxPerctId);

        var tax = $('#'+taxAmountId);


        var discountPerctVal = (discountPerct.val()/100)*rate;
        var discountVal = (discount != '') ? discount.val() : 0;
        var discountA = (discountPerct.val() == '') ? discountVal: discountPerctVal ;
        var taxVal = (tax.val() != '') ? tax.val() : 0;
        var taxPerctVal = (taxPerct.val()/100)*rate;
        var taxA = (taxPerct.val() == '') ? taxVal: taxPerctVal ;
        discount.val(decPoints(discountA,2));
        tax.val(decPoints(taxA,2));

        if(account.val() != '' && $('#'+postDateId).val() != ''){
            var new_amount = (rate-discountA) - taxA;
            amount.val(decPoints(new_amount,2));
            var sumToArray = classToArray(sharedSumClass);
            var sumArray = sumArrayItems(sumToArray);
            $('#'+overallSumId).val(decPoints(sumArray,2));

            //ALWAYS GET SUM OF ALL TAXES AND ALLOWANCES AND DISPLAY THEIR AMOUNTS IN TOTAL DISCOUNTS AND TAXES
            var totalDiscountGet = $('#'+totalDiscount);
            var totalTaxGet = $('#'+totalTax);
            var sumToArrayTax = classToArray(taxSharedClass);
            var sumArrayTax = sumArrayItems(sumToArrayTax);
            var sumToArrayDiscount = classToArray(discountSharedClass);
            var sumArrayDiscount = sumArrayItems(sumToArrayDiscount);
            totalDiscountGet.val(decPoints(sumArrayDiscount,2));
            totalTaxGet.val(decPoints(sumArrayTax,2));
            exclTax(overallSumId,totalTax,'excl_'+overallSumId);
            convertToDefaultCurr(foreignCurrId,overallSumId,defaultCurrPage,vendorCustId,postDateId)

        }else{
            alert('Please select an posting date, account and enter rate/amount');
        }
    }

    function percentToAmount(percentId,perctAmountId,amountId,rateId,itemId,qtyId,discountAmountId,taxAmountId,sharedSumClass,overallSumId,foreignCurrId,defaultCurrPage,taxSharedClass,discountSharedClass,totalTax,totalDiscount,vendorCustId,postDateId){
        var percent = $('#'+percentId).val();
        var perctAmount = $('#'+perctAmountId);
        var amount = $('#'+amountId);
        var rate = $('#'+rateId).val();
        var item = $('#'+itemId).val();
        var discount = $('#'+discountAmountId);
        var tax = $('#'+taxAmountId);
        var qtyVal = '';
        if(qtyId != ''){
            var qty = $('#'+qtyId);
             qtyVal = (qty.val() != '') ? qty.val() : 0;
        }

        if(rate != '' && item != ''){
            var real_amount = (qtyId == '') ? rate : rate*qtyVal;
            var percentage = (percent/100)*real_amount;
            perctAmount.val(decPoints(percentage,2));
            var discountA = (discount.val() != '') ? discount.val() : 0;
            var taxA = (tax.val() != '') ? tax.val() : 0;
            var new_amount = (real_amount-discountA) - taxA;

            amount.val(decPoints(new_amount,2));

            //DISPLAY SUM TOTAL OF SUB TOTALS IN THE TOTAL SUM FIELD
            var sumToArray = classToArray(sharedSumClass);
            var sumArray = sumArrayItems(sumToArray);
            $('#'+overallSumId).val(decPoints(sumArray,2));

            //ALWAYS GET SUM OF ALL TAXES AND ALLOWANCES AND DISPLAY THEIR AMOUNTS IN TOTAL DISCOUNTS AND TAXES
            var totalDiscountGet = $('#'+totalDiscount);
            var totalTaxGet = $('#'+totalTax);
            var sumToArrayTax = classToArray(taxSharedClass);
            var sumArrayTax = sumArrayItems(sumToArrayTax);
            var sumToArrayDiscount = classToArray(discountSharedClass);
            var sumArrayDiscount = sumArrayItems(sumToArrayDiscount);
            totalDiscountGet.val(decPoints(sumArrayDiscount,2));
            totalTaxGet.val(decPoints(sumArrayTax,2));
            exclTax(overallSumId,totalTax,'excl_'+overallSumId);

            convertToDefaultCurr(foreignCurrId,overallSumId,defaultCurrPage,vendorCustId,postDateId)
        }else{
            swal("Warning!", 'Please Select an item/account and enter quantity if necessary to continue', "warning");
        }

    }

    function fillNextInputTax(value_id,displayId,page,moduleType,amountId,rateId,itemId,qtyId,discountAmountId,taxAmountId,sharedSumClass,overallSumId,foreignCurrId,defaultCurrPage,taxSharedClass,discountSharedClass,totalTax,totalDiscount,vendorCustId,postDateId,taxPerctId,discountPerctId){
        var pickedVal = $('#'+value_id).val();

        if(pickedVal != ''){
            $.ajax({
                url:  page+'?pickedVal='+pickedVal+'&type='+moduleType
            }).done(function(data){
                $('#'+displayId).val(data);
                var rate = $('#'+rateId);
                var qtyVal = $('#'+qtyId);

                $('#'+taxAmountId).val(decPoints((data*rate.val()*qtyVal.val()*data)/100,2));
                itemSum(amountId,rateId,itemId,qtyId,discountAmountId,taxAmountId,sharedSumClass,overallSumId,foreignCurrId,defaultCurrPage,'',taxSharedClass,discountSharedClass,totalTax,totalDiscount,vendorCustId,postDateId,taxPerctId,discountPerctId)
            });
        }

    }

    function fillNextInputTaxAcc(value_id,displayId,page,moduleType,amountId,rateId,accountId,discountAmountId,taxAmountId,sharedSumClass,overallSumId,foreignCurrId,defaultCurrPage,taxSharedClass,discountSharedClass,totalTax,totalDiscount,vendorCustId,postDateId,taxPerctId,discountPerctId){
        var pickedVal = $('#'+value_id).val();

        if(pickedVal != ''){
            $.ajax({
                url:  page+'?pickedVal='+pickedVal+'&type='+moduleType
            }).done(function(data){
                $('#'+displayId).val(data);
                var rate = $('#'+rateId);
                $('#'+taxAmountId).val(decPoints((data*rate.val())/100,2));
                accountSum(amountId,accountId,rateId,discountAmountId,taxAmountId,sharedSumClass,overallSumId,foreignCurrId,defaultCurrPage,taxSharedClass,discountSharedClass,totalTax,totalDiscount,vendorCustId,postDateId,taxPerctId,discountPerctId);

            });
        }

    }

    function convertToDefaultCurr(repId,amountId,page,vendorCustId,postDateId){
        var amount = $('#'+amountId).val();
        var vendorCust = $('#'+vendorCustId).val();
        var postDateVal = $('#'+postDateId);
        var postDate = (postDateVal.length >0) ? postDateVal.val() : '';

        $.ajax({
            url: page+'?amount=' + amount+'&vendorCust='+vendorCust+'&postDate='+postDate
        }).done(function(data){
            $('#'+repId).val(decPoints(data.overall_sum,2));
        });
    }

    function dropdownItemTransact(valDisplayId,val,hiddenValId,hiddenVal,dropdownId,amountId,currPage,currencyClass,vendorCustId,postDateId,convertToDefaultCurrPage,billAddress,currRate,foreignOverallSum) {
        $("#"+valDisplayId).val(val);
        $("#"+hiddenValId).val(hiddenVal);
        $("#"+dropdownId).hide();
        var amount = $("#"+amountId).val();
        fetchVendCustCurr(hiddenValId,currencyClass,currPage,billAddress,currRate);

        //CONVERT SELECTED VENDOR CURRENCY TO DEFAULT CURRENCY IN CASE THERE IS EXISTING TOTAL SUM
        if(amount != 0 && amount != ''){
            convertToDefaultCurr(foreignOverallSum,amountId,convertToDefaultCurrPage,vendorCustId,postDateId)
        }

    }

    function dropdownItemInv(valDisplayId,val,hiddenValId,hiddenVal,dropdownId,bill_invoice,invPage,descId,rateId,unitMId,subTotalId,sharedSumClass,overallSumId,foreignCurrId,defaultCurrPage,qtyId,vendorCustId,postDateId,totalTaxId) {
        $("#"+valDisplayId).val(val);
        $("#"+hiddenValId).val(hiddenVal);
        $("#"+dropdownId).hide();

        fetchInventory(hiddenValId,bill_invoice,invPage,descId,rateId,unitMId,subTotalId,sharedSumClass,overallSumId,foreignCurrId,defaultCurrPage,qtyId,vendorCustId,postDateId,totalTaxId);

    }

    function removeInputCalc(show_id,ghost_class,addUrl,type,all_new_fields_class,unique_num,addButtonId,hideButtonId,amtId,sumTotalId,currRep,currPage,taxSharedClass,discountSharedClass,totalTax,totalDiscount,vendorCustId,postDateId) {

        var amt = $('#'+amtId).val();

        //MINUS SINGLE LINE AMOUNT FROM SUM TOTAL AMOUNT TO BE REMOVED

        if(amt != ''){
            var newAmt = $('#'+sumTotalId).val() - amt;

            $('#'+sumTotalId).val(decPoints(newAmt,2));
        }else{
            //$('#'+sumTotalId).val(0);
        }

        var get_class = document.getElementsByClassName(all_new_fields_class);
        var addButtons = document.getElementsByClassName('addButtons');
        if(addButtons.length < 1 ) {

            if (addButtons.length < 1) {
                prevAddId.style.display = 'block';
            }
        }
        $('.' + ghost_class).remove();
        var show_all = document.getElementById(hideButtonId);
        var show_button = '';

        show_button += '<tr><td></td><td></td><td></td><td>';
        show_button += '<div style="cursor: pointer;" onclick="addMore(';

        show_button += "'"+addButtonId+"','"+hideButtonId+"','1','" + addUrl + "','"+type+"','"+hideButtonId+"');";
        show_button += '">';
        show_button += '<i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i></div>';
        show_button += '</tr>';
        if (get_class.length === 0) {

            show_all.innerHTML =show_button;
            show_all.style.display = 'block';
        }

        //ALWAYS GET SUM OF ALL TAXES AND ALLOWANCES AND DISPLAY THEIR AMOUNTS IN TOTAL DISCOUNTS AND TAXES
        var totalDiscountGet = $('#'+totalDiscount);
        var totalTaxGet = $('#'+totalTax);
        var sumToArrayTax = classToArray(taxSharedClass);
        var sumArrayTax = sumArrayItems(sumToArrayTax);
        var sumToArrayDiscount = classToArray(discountSharedClass);
        var sumArrayDiscount = sumArrayItems(sumToArrayDiscount);
        totalDiscountGet.val(decPoints(sumArrayDiscount,2));
        totalTaxGet.val(decPoints(sumArrayTax,2));
        exclTax(sumTotalId,totalTax,'excl_'+sumTotalId);

        convertToDefaultCurr(currRep,sumTotalId,currPage,vendorCustId,postDateId);

    }

    function genPercentage(perctId,perctAmountId,overallSumId,sharedSumClass,vendCustId,odaPerctAmountId,foreignSumId,currPage,vendorCustId,postDateId,discountSharedClass){
        var perct = $('#'+perctId);
        var overallSum = $('#'+overallSumId);
        var overallSumExcl = $('#excl_'+overallSumId);
        var perctAmount = $('#'+perctAmountId);
        var odaperctAmount = $('#'+odaPerctAmountId);
        var sumToArrayDiscount = classToArray(discountSharedClass);
        var sumArrayDiscount = sumArrayItems(sumToArrayDiscount);

        var sumToArray = classToArray(sharedSumClass);
        var sumArrayInclTax = sumArrayItems(sumToArray);

        var vendCustVal = $('#'+vendCustId).val();
        if(vendCustVal != '' && overallSum.val() != ''){
            //GET OVERALL SUM WITHOUT TAX AND DISCOUNT INCLUSIVE
            var overallSumVal = parseInt(sumArrayInclTax)+parseInt(odaperctAmount.val())+sumArrayDiscount;

            //GET PERCENTAGE DISCOUNT AMOUNT
            var percentage = (perct.val()*overallSumVal)/100;
            perctAmount.val(decPoints(percentage,2));   // DISPLAY PERCENTAGE AMOUNT
            overallSum.val(decPoints((overallSumVal-percentage)-odaperctAmount.val(),2)); //DISPLAY OVERALL SUM INCLUDING TAX AND DISCOUNT AMOUNT
            overallSumExcl.val(decPoints((overallSumVal-percentage),2)); //DISPLAY OVERALL SUM WITHOUT TAX


            convertToDefaultCurr(foreignSumId,overallSumId,currPage,vendorCustId,postDateId);

        }else{
            swal("Warning!", 'Please Select Vendor/Customer, posting date and ensure there is Grand Total', "warning");
        }

    }

    function genPercentageTax(perctId,perctAmountId,overallSumId,sharedSumClass,vendCustId,odaPerctAmountId,foreignSumId,currPage,vendorCustId,postDateId){
        var perct = $('#'+perctId);
        var overallSum = $('#'+overallSumId);
        var overallSumExcl = $('#excl_'+overallSumId);
        var perctAmount = $('#'+perctAmountId);
        var odaperctAmount = $('#'+odaPerctAmountId);
        var vendCustVal = $('#'+vendCustId).val();
        console.log(vendorCustId);
        if(vendCustVal != '' && overallSum.val() != ''){
            var overallSumVal = overallSumExcl.val();
            var percentage = (perct.val()*overallSumVal)/100;
            perctAmount.val(decPoints(percentage,2));
            overallSum.val(decPoints(((overallSumVal)-percentage),2));
            var newTotal = (overallSumVal-percentage);
            //exclTax(overallSumId,perctAmountId,'excl_'+overallSumId);
            convertToDefaultCurr(foreignSumId,overallSumId,currPage,vendorCustId,postDateId);

        }else{
            swal("Warning!", 'Please Select Vendor/Customer, posting date and ensure there is Grand Total', "warning");
        }

    }

    function permItemDelete(dataId,page,dataIdVal,amtVal,totalValId,currRep,currPage,taxAmountId,discountAmountId,totalTax,totalDiscount,vendorCustId,postDateId,parentDataId,updateSumPage,reloadId,reloadUrl,dbTable){
        var totalVal = $('#'+totalValId).val();
        var discountVal = $('#'+discountAmountId).val();
        var taxVal = $('#'+taxAmountId).val();
        var totalDiscountGet = $('#'+totalDiscount);
        var totalTaxGet = $('#'+totalTax);

        $.ajax({
            url: page+'?dataId='+dataIdVal
        }).done(function(data){
            $('#'+dataId).remove();
            var newTotal = totalVal - amtVal;
            $('#'+totalValId).val(decPoints(newTotal,2));

            //ALWAYS GET SUM OF ALL TAXES AND ALLOWANCES AND DISPLAY THEIR AMOUNTS IN TOTAL DISCOUNTS AND TAXES
           var newTotalTax = totalTaxGet.val() - taxVal;
            var newTotalDiscount = totalDiscountGet.val() - discountVal;
            totalDiscountGet.val(decPoints(newTotalDiscount,2));
            totalTaxGet.val(decPoints(newTotalTax,2));
            exclTax(totalValId,totalTax,'excl_'+totalValId);

            convertToDefaultCurr(currRep,totalValId,currPage,vendorCustId,postDateId);
            updateDbSum(parentDataId,updateSumPage,newTotal,totalTaxGet.val(),totalDiscountGet.val(),vendorCustId,postDateId,reloadId,reloadUrl,dbTable);
            swal("Warning!", 'Item removed successfully', "success");

        });


    }

    function updateDbSum(dataId,page,totalVal,totalTax,totalDiscount,vendorCustId,postDateId,reloadId,reloadUrl,dbTable){

        var postDate = $('#'+postDateId).val();
        var vendorCust = $('#'+vendorCustId).val();
        alert( page+'?dataId='+dataId+'&grandTotal='+totalVal+'&totalTax='+totalTax+'&totalDiscount='+totalDiscount+'&postDate='+postDate+'&vendorCust='+vendorCust+'&dbTable='+dbTable
    );

       $.ajax({
            url: page+'?dataId='+dataId+'&grandTotal='+totalVal+'&totalTax='+totalTax+'&totalDiscount='+totalDiscount+'&postDate='+postDate+'&vendorCust='+vendorCust+'&dbTable='+dbTable
        }).done(function(data){
            //console.log(data);
            reloadContent(reloadId,reloadUrl);

        });


    }

        ///////////////////////////  END OF ITEM AND ACCOUNT METHODS CALCULATION METHODS  //////////////////////

        ///////////////     BEGIN OF TABS WITH NEXT AND PREVIOUS        //////////////////

        $(document).ready(function () {
            //Initialize tooltips
            $('.nav-tabs > li a[title]').tooltip();

            //Wizard
            $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

                var $target = $(e.target);

                if ($target.parent().hasClass('disabled')) {
                    return false;
                }
            });

            $(".next-step").click(function (e) {

                var $active = $('.wizard .nav-tabs li.active');
                $active.next().removeClass('disabled');
                nextTab($active);

            });
            $(".prev-step").click(function (e) {

                var $active = $('.wizard .nav-tabs li.active');
                prevTab($active);

            });
        });

        function nextTab(elem) {
            $(elem).next().find('a[data-toggle="tab"]').click();
        }
        function prevTab(elem) {
            $(elem).prev().find('a[data-toggle="tab"]').click();
        }

        ////////////////    END OF TABS WITH NEXT AND PREVIOUS      //////////////////////

    function numONLY (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    }