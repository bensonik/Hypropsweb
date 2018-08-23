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


    function fillNextInput(value_id,displayId,page,moduleType){
            var pickedVal = $('#'+value_id).val();

            $.ajax({
                url:  page+'?pickedVal='+pickedVal+'&type='+moduleType
            }).done(function(data){
                $('#'+displayId).html(data);
            });
        }

    function searchOptionList(searchId,listId,page,moduleType,hiddenId){
        var pickedVal = $('#'+searchId).val();
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