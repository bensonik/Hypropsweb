

<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Print Preview</h4>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown pull-right">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a class="btn bg-blue-grey waves-effect" onClick ="print_content('print_preview');" ><i class="fa fa-print"></i>Print</a></li>
                            <li><a class="btn bg-red waves-effect" onClick ="print_content('print_preview');" ><i class="fa fa-file-pdf-o"></i>Pdf</a></li>
                            <li><a class="btn btn-warning" onClick ="$('#print_preview').tableExport({type:'excel',escape:'false'});" ><i class="fa fa-file-excel-o"></i>Excel</a></li>
                            <li><a class="btn  bg-light-green waves-effect" onClick ="$('#print_preview').tableExport({type:'csv',escape:'false'});" ><i class="fa fa-file-o"></i>CSV</a></li>
                            <li><a class="btn btn-info" onClick ="$('#print_preview').tableExport({type:'doc',escape:'false'});" ><i class="fa fa-file-word-o"></i>Msword</a></li>

                        </ul>
                    </li>
                </ul>
            </div>
            <div class="modal-body" id="print_preview">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>