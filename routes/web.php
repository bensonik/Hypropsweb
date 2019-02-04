<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

//Auth::routes();

//------HOME AND LOGIN MODULE----------
Route::get('/', 'HomeController@signin')->name('login');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@index')->name('dashboard')->middleware('auth');
Route::post('/login', 'Auth\LoginController@login')->name('login_user');
Route::any('/logout', 'Auth\LoginController@signout')->name('logout');

// -------------USER MODULE-----------
Route::post('/create_user', 'UsersController@createUser')->name('create_user');

// -------------DEPARTMENT MODULE-----------
Route::any('/department', 'DepartmentController@index')->name('department')->middleware('auth.admin');
Route::post('/create_dept', 'DepartmentController@create')->name('create_dept');
Route::post('/edit_dept_form', 'DepartmentController@editForm')->name('edit_dept_form');
Route::post('/edit_dept', 'DepartmentController@edit')->name('edit_dept');
Route::post('/delete_dept', 'DepartmentController@destroy')->name('delete_dept');

// -------------POSITION MODULE-----------
Route::any('/position', 'PositionController@index')->name('position')->middleware('auth.admin');
Route::post('/create_position', 'PositionController@create')->name('create_position');
Route::post('/edit_position_form', 'PositionController@editForm')->name('edit_position_form');
Route::post('/edit_position', 'PositionController@edit')->name('edit_position');
Route::post('/delete_position', 'PositionController@destroy')->name('delete_position');

// -------------SALARY COMPONENT MODULE-----------
Route::any('/salary_component', 'SalaryComponentController@index')->name('salary_component')->middleware('auth.admin');
Route::post('/create_component', 'SalaryComponentController@create')->name('create_component');
Route::post('/edit_component_form', 'SalaryComponentController@editForm')->name('edit_component_form');
Route::post('/edit_component', 'SalaryComponentController@edit')->name('edit_component');
Route::post('/delete_component', 'SalaryComponentController@destroy')->name('delete_component');

// -------------SALARY STRUCTURE MODULE-----------
Route::any('/salary_structure', 'SalaryStructureController@index')->name('salary_structure')->middleware('auth.admin');
Route::post('/create_structure', 'SalaryStructureController@create')->name('create_structure');
Route::post('/edit_structure_form', 'SalaryStructureController@editForm')->name('edit_structure_form');
Route::post('/edit_structure', 'SalaryStructureController@edit')->name('edit_structure');
Route::post('/delete_structure', 'SalaryStructureController@destroy')->name('delete_structure');

// -------------APPROVAL SYSTEM MODULE-----------
Route::any('/approval_system', 'ApprovalSysController@index')->name('approval_system')->middleware('auth.admin');
Route::post('/create_approval', 'ApprovalSysController@create')->name('create_approval');
Route::post('/edit_approval_form', 'ApprovalSysController@editForm')->name('edit_approval_form');
Route::post('/edit_approval', 'ApprovalSysController@edit')->name('edit_approval');
Route::post('/delete_approval', 'ApprovalSysController@destroy')->name('delete_approval');

// -------------DEPARTMENTAL APPROVAL MODULE-----------
Route::any('/approval_dept', 'ApprovalDeptController@index')->name('approval_dept')->middleware('auth.admin');
Route::post('/create_approval_dept', 'ApprovalDeptController@create')->name('create_approval_dept');
Route::post('/edit_approval_dept_form', 'ApprovalDeptController@editForm')->name('edit_approval_dept_form');
Route::post('/edit_approval_dept', 'ApprovalDeptController@edit')->name('edit_approval_dept');
Route::post('/delete_approval_dept', 'ApprovalDeptController@destroy')->name('delete_approval_dept');

// -------------TAX MODULE-----------
Route::any('/tax_system', 'TaxController@index')->name('tax_system')->middleware('auth.admin');
Route::post('/create_tax', 'TaxController@create')->name('create_tax');
Route::post('/edit_tax_form', 'TaxController@editForm')->name('edit_tax_form');
Route::post('/edit_tax', 'TaxController@edit')->name('edit_tax');
Route::post('/delete_tax', 'TaxController@destroy')->name('delete_tax');

// -------------USER MODULE-----------
Route::any('/user', 'UsersController@index')->name('user')->middleware('auth.admin');
Route::post('/create_user', 'UsersController@create')->name('create_user');
Route::post('/edit_user_form', 'UsersController@editForm')->name('edit_user_form');
Route::post('/edit_user', 'UsersController@edit')->name('edit_user');
Route::get('/user_profile/{uid}', 'UsersController@userProfile')->name('profile');
Route::any('/search_user', 'UsersController@searchUser')->name('user_search');
Route::post('/delete_user', 'UsersController@destroy')->name('delete_user');
Route::post('/change_user_status', 'UsersController@changeStatus')->name('change_user_status');

// -------------CURRENCY UNIT ROUTES FOR FUNCTIONS-----------
Route::any('/currencies', 'CurrencyController@index')->name('currencies')->middleware('auth');
Route::any('/currency_status', 'CurrencyController@currencyStatus')->name('currency_status');

// -------------GENERAL UNIT ROUTES FOR FUNCTIONS-----------
Route::any('/add_more', 'GeneralController@addMore')->name('add_more');
Route::any('/default_select', 'GeneralController@selectOptions')->name('select_options');
Route::any('/get_currency', 'GeneralController@get_currency')->name('get_currency');
Route::any('/exchange_rate', 'GeneralController@exchangeRate')->name('exchange_rate');
Route::any('/vendor_customer_currency', 'GeneralController@vendorCustomerCurrency')->name('vendor_customer_currency');
Route::any('/inventory_details', 'GeneralController@inventoryDetails')->name('inventory_details');
Route::any('/amount_to_default_curr', 'GeneralController@convertToDefault')->name('amount_to_default_curr');
Route::any('/get_rate', 'GeneralController@getRate')->name('get_rate');
Route::any('/update_sum', 'GeneralController@updateSum')->name('update_sum');

// -------------COMPANY INFO MODULE-----------
Route::any('/company', 'CompanyController@index')->name('user')->middleware('auth.admin');
Route::post('/create_company', 'CompanyController@create')->name('create_company');
Route::post('/edit_company_form', 'CompanyController@editForm')->name('edit_company_form');
Route::post('/edit_company', 'CompanyController@edit')->name('edit_company');
Route::post('/delete_company', 'CompanyController@destroy')->name('delete_company');
Route::post('/change_company_status', 'CompanyController@changeStatus')->name('change_company_status');

// -------------DEPARTMENTAL HEAD MODULE-----------
Route::any('/dept_approval', 'ApprovalDeptController@index')->name('dept_approval')->middleware('auth.admin');
Route::post('/create_dept_approval', 'ApprovalDeptController@create')->name('create_dept_approval');
Route::post('/edit_dept_approval_form', 'ApprovalDeptController@editForm')->name('edit_dept_approval_form');
Route::post('/edit_dept_approval', 'ApprovalDeptController@edit')->name('edit_dept_approval');
Route::post('/delete_dept_approval', 'ApprovalDeptController@destroy')->name('delete_dept_approval');

// -------------REQUISITION MODULE-----------
Route::any('/requisition', 'RequisitionController@index')->name('requisition')->middleware('auth');
Route::any('/my_requests', 'RequisitionController@myRequests')->name('my_request')->middleware('auth');
Route::any('/salary_advance_requests', 'RequisitionController@salaryAdvanceRequests')->name('salary_advance_requests')->middleware('auth');
Route::any('/loan_requests', 'RequisitionController@loanRequests')->name('loan_requests')->middleware('auth');
Route::post('/create_requisition', 'RequisitionController@create')->name('create_requisition');
Route::post('/approve_requisition', 'RequisitionController@approval')->name('approve_requisition');
Route::post('/edit_requisition_form', 'RequisitionController@editForm')->name('edit_requisition_form');
Route::post('/edit_attachment_form', 'RequisitionController@attachmentForm')->name('edit_attachment_form');
Route::post('/edit_requisition', 'RequisitionController@edit')->name('edit_requisition');
Route::post('/edit_attachment', 'RequisitionController@editAttachment')->name('edit_attachment');
Route::post('/remove_attachment', 'RequisitionController@removeAttachment')->name('remove_attachment');
Route::any('/download_attachment', 'RequisitionController@downloadAttachment')->name('download_attachment');
Route::post('/delete_requisition', 'RequisitionController@destroy')->name('delete_requisition');

// -------------PROJECT MODULE-----------
Route::any('/project', 'ProjectController@index')->name('project')->middleware('auth');
Route::post('/create_project', 'ProjectController@create')->name('create_project');
Route::post('/edit_project_form', 'ProjectController@editForm')->name('edit_project_form');
Route::post('/edit_project', 'ProjectController@edit')->name('edit_project');
Route::post('/delete_project', 'ProjectController@destroy')->name('delete_project');

// -------------REQUEST CATEGORY MODULE-----------
Route::any('/request_category', 'RequestCategoryController@index')->name('request_category')->middleware('auth');
Route::post('/create_request_cat', 'RequestCategoryController@create')->name('create_request_cat');
Route::post('/edit_request_cat_form', 'RequestCategoryController@editForm')->name('edit_request_cat_form');
Route::post('/edit_request_cat', 'RequestCategoryController@edit')->name('edit_request_cat');
Route::post('/delete_request_cat', 'RequestCategoryController@destroy')->name('delete_request_cat');

// -------------COMPETENCY CATEGORY MODULE-----------
Route::any('/competency_category', 'SkillCompCatController@index')->name('competency_category')->middleware('auth');
Route::post('/create_comp_cat', 'SkillCompCatController@create')->name('create_comp_cat');
Route::post('/edit_comp_cat_form', 'SkillCompCatController@editForm')->name('edit_comp_cat_form');
Route::post('/edit_comp_cat', 'SkillCompCatController@edit')->name('edit_comp_cat');
Route::post('/delete_comp_cat', 'SkillCompCatController@destroy')->name('delete_comp_cat');

// -------------COMPETENCY FRAMEWORK MODULE-----------
Route::any('/competency_framework', 'CompetencyFrameworkController@index')->name('competency_framework')->middleware('auth');
Route::post('/create_comp_frame', 'CompetencyFrameworkController@create')->name('create_comp_frame');
Route::post('/edit_comp_frame_form', 'CompetencyFrameworkController@editForm')->name('edit_comp_frame_form');
Route::any('/search_frame', 'CompetencyFrameworkController@searchFrame')->name('search_frame');
Route::post('/edit_comp_frame', 'CompetencyFrameworkController@edit')->name('edit_comp_frame');
Route::post('/delete_comp_frame', 'CompetencyFrameworkController@destroy')->name('delete_comp_frame');

// -------------COMPETENCY MAP MODULE-----------
Route::any('/competency_map', 'CompetencyMapController@index')->name('competency_map')->middleware('auth');
Route::post('/create_comp_map', 'CompetencyMapController@create')->name('create_comp_map');
Route::post('/edit_comp_map_form', 'CompetencyMapController@editForm')->name('edit_comp_map_form');
Route::any('/search_map', 'CompetencyMapController@searchFrame')->name('search_map');
Route::post('/edit_comp_map', 'CompetencyMapController@edit')->name('edit_comp_map');
Route::post('/delete_comp_map', 'CompetencyMapController@destroy')->name('delete_comp_map');


// -------------APPRAISAL SUPERVISION MODULE-----------
Route::any('/appraisal_supervision', 'AppraisalSupervisionController@index')->name('appraisal_supervision')->middleware('auth.admin');
Route::post('/create_appraisal_sup', 'AppraisalSupervisionController@create')->name('create_appraisal_sup');
Route::post('/edit_appraisal_sup_form', 'AppraisalSupervisionController@editForm')->name('edit_appraisal_sup_form');
Route::post('/edit_appraisal_sup', 'AppraisalSupervisionController@edit')->name('edit_appraisal_sup');
Route::post('/delete_appraisal_sup', 'AppraisalSupervisionController@destroy')->name('delete_appraisal_sup');

// -------------UNIT GOAL SET MODULE-----------
Route::any('/appraisal_goal_set', 'UnitGoalSeriesController@index')->name('appraisal_goal_set')->middleware('auth');
Route::post('/create_ug_series', 'UnitGoalSeriesController@create')->name('create_ug_series');
Route::post('/edit_ug_series_form', 'UnitGoalSeriesController@editForm')->name('edit_ug_series_form');
Route::post('/edit_ug_series', 'UnitGoalSeriesController@edit')->name('edit_ug_series');
Route::post('/delete_ug_series', 'UnitGoalSeriesController@destroy')->name('delete_ug_series');

// -------------UNIT GOAL MODULE-----------
Route::any('/unit_goal', 'UnitGoalController@index')->name('unit_goal')->middleware('auth');
Route::post('/create_unit_goal', 'UnitGoalController@create')->name('create_unit_goal');
Route::post('/edit_unit_goal_form', 'UnitGoalController@editForm')->name('edit_unit_goal_form');
Route::post('/edit_unit_goal', 'UnitGoalController@edit')->name('edit_unit_goal');
Route::post('/search_unit_goal', 'UnitGoalController@searchUnitGoal')->name('search_unit_goal');
Route::post('/delete_unit_goal', 'UnitGoalController@destroy')->name('delete_unit_goal');
Route::post('/status_indi_goal', 'UnitGoalController@statusChange')->name('status_indi_goal');

// -------------INDIVIDUAL GOAL MODULE-----------
Route::any('/individual_goal', 'IndiGoalController@index')->name('individual_goal')->middleware('auth');
Route::any('/mark_indi_goal', 'IndiGoalController@markIndiGoal')->name('mark_indi_goal')->middleware('auth');
Route::post('/create_indi_goal', 'IndiGoalController@create')->name('create_indi_goal');
Route::post('/edit_indi_goal_form', 'IndiGoalController@editForm')->name('edit_indi_goal_form');
Route::post('/edit_indi_goal', 'IndiGoalController@edit')->name('edit_indi_goal');
Route::post('/search_indi_goal', 'IndiGoalController@searchIndiGoal')->name('search_indi_goal');
Route::post('/delete_indi_goal', 'IndiGoalController@destroy')->name('delete_indi_goal');
Route::post('/status_indi_goal', 'IndiGoalController@statusChange')->name('status_indi_goal');

// -------------REQUEST ACCESS MODULE-----------
Route::any('/request_access', 'RequestAccessController@index')->name('request_access')->middleware('auth.admin');
Route::post('/create_request_access', 'RequestAccessController@create')->name('create_request_access');
Route::post('/edit_request_access_form', 'RequestAccessController@editForm')->name('edit_request_access_form');
Route::post('/edit_request_access', 'RequestAccessController@edit')->name('edit_request_access');
Route::post('/delete_request_access', 'RequestAccessController@destroy')->name('delete_request_access');

// -------------DEPARTMENTAL LEAVE MODULE-----------
Route::any('/leave_approval', 'LeaveApprovalController@index')->name('leave_approval')->middleware('auth.admin');
Route::post('/create_leave_approval', 'LeaveApprovalController@create')->name('create_leave_approval');
Route::post('/edit_leave_approval_form', 'LeaveApprovalController@editForm')->name('edit_leave_approval_form');
Route::post('/edit_leave_approval', 'LeaveApprovalController@edit')->name('edit_leave_approval');
Route::post('/delete_leave_approval', 'LeaveApprovalController@destroy')->name('delete_leave_approval');

// -------------HRIS APPROVAL SYSTEM MODULE-----------
Route::any('/leave_approval_system', 'HrisApprovalSysController@index')->name('leave_approval_system')->middleware('auth.admin');
Route::post('/create_hris_approval', 'HrisApprovalSysController@create')->name('create_hris_approval');
Route::post('/edit_hris_approval_form', 'HrisApprovalSysController@editForm')->name('edit_hris_approval_form');
Route::post('/edit_hris_approval', 'HrisApprovalSysController@edit')->name('edit_hris_approval');
Route::post('/delete_hris_approval', 'HrisApprovalSysController@destroy')->name('delete_hris_approval');

// -------------LEAVE TYPE MODULE-----------
Route::any('/leave_type', 'LeaveTypeController@index')->name('leave_type')->middleware('auth');
Route::post('/create_leave_type', 'LeaveTypeController@create')->name('create_leave_type');
Route::post('/edit_leave_type_form', 'LeaveTypeController@editForm')->name('edit_leave_type_form');
Route::post('/edit_leave_type', 'LeaveTypeController@edit')->name('edit_leave_type');
Route::post('/delete_leave_type', 'LeaveTypeController@destroy')->name('delete_leave_type');

// -------------LEAVE REQUEST MODULE-----------
Route::any('/leave_log', 'LeaveLogController@index')->name('leave_log')->middleware('auth');
Route::any('/leave_history', 'LeaveLogController@leaveHistory')->name('leave_history')->middleware('auth');
Route::any('/my_leave_requests', 'LeaveLogController@myRequests')->name('my_leave_request')->middleware('auth');
Route::post('/create_leave', 'LeaveLogController@create')->name('create_leave');
Route::post('/approve_leave', 'LeaveLogController@approval')->name('approve_leave');
Route::post('/edit_leave_form', 'LeaveLogController@editForm')->name('edit_leave_form');
Route::post('/edit_user_leave_form', 'LeaveLogController@editUserLeaveForm')->name('edit_user_leave_form');
Route::post('/edit_leave_attachment_form', 'LeaveLogController@attachmentForm')->name('edit_leave_attachment_form');
Route::post('/edit_leave', 'LeaveLogController@edit')->name('edit_leave');
Route::post('/edit_user_leave', 'LeaveLogController@editUserLeave')->name('edit_user_leave');
Route::post('/edit_leave_attachment', 'LeaveLogController@editAttachment')->name('edit_leave_attachment');
Route::post('/remove_leave_attachment', 'LeaveLogController@removeAttachment')->name('remove_leave_attachment');
Route::any('/download_leave_attachment', 'LeaveLogController@downloadAttachment')->name('download_leave_attachment');
Route::post('/delete_leave', 'LeaveLogController@destroy')->name('delete_leave');

// -------------LOAN INTEREST RATE MODULE-----------
Route::any('/loan_interest_rate', 'LoanRatesController@index')->name('loan_interest_rate')->middleware('auth.admin');
Route::post('/create_loan_rate', 'LoanRatesController@create')->name('create_loan_rate');
Route::post('/edit_loan_rate_form', 'LoanRatesController@editForm')->name('edit_loan_rate_form');
Route::post('/edit_loan_rate', 'LoanRatesController@edit')->name('edit_loan_rate');
Route::post('/loan_status', 'LoanRatesController@changeLoanStatus')->name('loan_status');
Route::post('/delete_loan_rate', 'LoanRatesController@destroy')->name('delete_loan_rate');

// -------------PAYROLL MODULE-----------
Route::any('/payroll', 'PayrollController@index')->name('payroll')->middleware('auth');
Route::any('/process_payroll', 'PayrollController@process')->name('process_payroll');
Route::get('/payslip', 'PayrollController@payslip')->name('payslip')->middleware('auth');
Route::any('/payslip_item', 'PayrollController@payslipItem')->name('payslip_item');
Route::post('/approve_payroll', 'PayrollController@approve')->name('approve_payroll');
Route::any('/search_payroll_user', 'PayrollController@searchUser')->name('search_payroll_user');
Route::post('/delete_payroll', 'PayrollController@destroy')->name('delete_payroll');

// -------------INDIVIDUAL DEVELOPMENT PLAN MODULE-----------
Route::any('/idp', 'IdpController@index')->name('idp')->middleware('auth');
Route::post('/create_idp', 'IdpController@create')->name('create_idp');
Route::post('/edit_idp_form', 'IdpController@editForm')->name('edit_idp_form');
Route::post('/edit_idp', 'IdpController@edit')->name('edit_idp');
Route::post('/search_idp', 'IdpController@searchIndiGoal')->name('search_idp');
Route::post('/delete_idp', 'IdpController@destroy')->name('delete_idp');
Route::post('/status_idp', 'IdpController@statusChange')->name('status_idp');

// -------------Training Schedule MODULE-----------
Route::any('/training', 'TrainingController@index')->name('training')->middleware('auth');
Route::post('/create_training', 'TrainingController@create')->name('create_training');
Route::post('/edit_training_form', 'TrainingController@editForm')->name('edit_training_form');
Route::post('/edit_training', 'TrainingController@edit')->name('edit_training');
Route::post('/delete_training', 'TrainingController@destroy')->name('delete_training');


// -------------BIN TYPE MODULE-----------
Route::any('/bin_type', 'BinTypeController@index')->name('bin_type')->middleware('auth');
Route::post('/create_bin_type', 'BinTypeController@create')->name('create_bin_type');
Route::post('/edit_bin_type_form', 'BinTypeController@editForm')->name('edit_bin_type_form');
Route::post('/edit_bin_type', 'BinTypeController@edit')->name('edit_bin_type');
Route::post('/delete_bin_type', 'BinTypeController@destroy')->name('delete_bin_type');

// -------------BIN MODULE-----------
Route::any('/bin', 'BinController@index')->name('bin_type')->middleware('auth');
Route::post('/create_bin', 'BinController@create')->name('create_bin');
Route::post('/edit_bin_form', 'BinController@editForm')->name('edit_bin_form');
Route::post('/edit_bin', 'BinController@edit')->name('edit_bin');
Route::post('/delete_bin', 'BinController@destroy')->name('delete_bin');

// -------------ZONE MODULE-----------
Route::any('/zone', 'ZoneController@index')->name('zone')->middleware('auth');
Route::post('/create_zone', 'ZoneController@create')->name('create_zone');
Route::post('/edit_zone_form', 'ZoneController@editForm')->name('edit_zone_form');
Route::post('/edit_zone', 'ZoneController@edit')->name('edit_zone');
Route::post('/delete_zone', 'ZoneController@destroy')->name('delete_zone');

// -------------WAREHOUSE MODULE-----------
Route::any('/warehouse', 'WarehouseController@index')->name('warehouse')->middleware('auth');
Route::post('/create_warehouse', 'WarehouseController@create')->name('create_warehouse');
Route::post('/edit_warehouse_form', 'WarehouseController@editForm')->name('edit_warehouse_form');
Route::post('/edit_warehouse', 'WarehouseController@edit')->name('edit_warehouse');
Route::post('/delete_warehouse', 'WarehouseController@destroy')->name('delete_warehouse');

// -------------WAREHOUSE BIN MODULE-----------
Route::any('/warehouse_bin', 'ZoneBinController@Index')->name('warehouse')->middleware('auth');
Route::post('/create_warehouse_bin', 'ZoneBinController@Create')->name('create_warehouse');
Route::post('/add_warehouse_bin_form', 'ZoneBinController@addForm')->name('add_warehouse_bin_form');
Route::post('/delete_warehouse_bin', 'ZoneBinController@Destroy')->name('delete_warehouse_bin');

// -------------WAREHOUSE ZONE MODULE-----------
Route::any('/warehouse_zone', 'WarehouseZoneController@Index')->name('warehouse')->middleware('auth');
Route::post('/create_warehouse_zone', 'WarehouseZoneController@Create')->name('create_warehouse');
Route::post('/add_warehouse_zone_form', 'WarehouseZoneController@addForm')->name('add_warehouse_zone_form');
Route::post('/delete_warehouse_zone', 'WarehouseZoneController@Destroy')->name('delete_warehouse_zone');

// -------------PUT-AWAY TEMPLATE MODULE-----------
Route::any('/put_away_template', 'PutAwayTemplateController@index')->name('bin_type')->middleware('auth');
Route::post('/create_put_away_template', 'PutAwayTemplateController@create')->name('create_put_away_template');
Route::post('/edit_put_away_template_form', 'PutAwayTemplateController@editForm')->name('edit_put_away_template_form');
Route::post('/edit_put_away_template', 'PutAwayTemplateController@edit')->name('edit_put_away_template');
Route::post('/delete_put_away_template', 'PutAwayTemplateController@destroy')->name('delete_put_away_template');

// -------------PHYSICAL INVENTORY COUNT MODULE-----------
Route::any('/physical_inv_count', 'PhysicalInvCountController@index')->name('physical_inv_count')->middleware('auth');
Route::post('/create_physical_inv_count', 'PhysicalInvCountController@create')->name('create_physical_inv_count');
Route::post('/edit_physical_inv_count_form', 'PhysicalInvCountController@editForm')->name('edit_physical_inv_count_form');
Route::post('/edit_physical_inv_count', 'PhysicalInvCountController@edit')->name('edit_physical_inv_count');
Route::post('/delete_physical_inv_count', 'PhysicalInvCountController@destroy')->name('delete_physical_inv_count');

// -------------Unit of Measure-----------
Route::any('/unit_measure', 'UnitMeasureController@index')->name('unit_measure')->middleware('auth');
Route::post('/create_unit_measure', 'UnitMeasureController@create')->name('create_unit_measure');
Route::post('/edit_unit_measure_form', 'UnitMeasureController@editForm')->name('edit_unit_measure_form');
Route::post('/edit_unit_measure', 'UnitMeasureController@edit')->name('edit_unit_measure');
Route::post('/delete_unit_measure', 'UnitMeasureController@destroy')->name('delete_unit_measure');

// -------------VENDOR MODULE-----------
Route::any('/vendor', 'VendorCustomerController@indexVendor')->name('vendor_customer')->middleware('auth');
Route::any('/customer', 'VendorCustomerController@indexCustomer')->name('vendor_customer')->middleware('auth');
Route::post('/create_vendor_customer', 'VendorCustomerController@create')->name('create_vendor_customer');
Route::post('/edit_vendor_customer_form', 'VendorCustomerController@editForm')->name('edit_vendor_customer_form');
Route::post('/edit_vendor_customer', 'VendorCustomerController@edit')->name('edit_vendor_customer');
Route::any('/search_vendor', 'VendorCustomerController@searchVendor')->name('vendor_search');
Route::any('/search_customer', 'VendorCustomerController@searchCustomer')->name('customer_search');
Route::post('/delete_vendor_customer', 'VendorCustomerController@destroy')->name('delete_vendor_customer');
Route::post('/change_vendor_customer_status', 'VendorCustomerController@changeStatus')->name('change_vendor_customer_status');

// -------------INVENTORY CATEGORY MODULE-----------
Route::any('/inventory_category', 'InventoryCategoryController@index')->name('inventory_category')->middleware('auth');
Route::post('/create_inventory_cat', 'InventoryCategoryController@create')->name('create_inventory_cat');
Route::post('/edit_inventory_cat_form', 'InventoryCategoryController@editForm')->name('edit_inventory_cat_form');
Route::post('/edit_inventory_cat', 'InventoryCategoryController@edit')->name('edit_inventory_cat');
Route::post('/delete_inventory_cat', 'InventoryCategoryController@destroy')->name('delete_inventory_cat');

// -------------INVENOTRY MODULE-----------
Route::any('/inventory', 'InventoryController@index')->name('inventory')->middleware('auth');
Route::any('/ext_amount', 'InventoryController@extendedAmount')->name('ext_amount');
Route::post('/edit_inventory_form', 'InventoryController@editForm')->name('edit_inventory_form');
Route::any('/warehouse_inventory', 'InventoryController@warehouseInventory')->name('warehouse_inventory');
Route::any('/stock_inventory', 'InventoryController@stockInventory')->name('stock_inventory');
Route::post('/create_inventory', 'InventoryController@create')->name('create_inventory');
Route::post('/edit_inventory', 'InventoryController@edit')->name('edit_inventory');
Route::any('/search_inventory', 'InventoryController@searchInventory')->name('search_inventory');
Route::post('/delete_inventory', 'InventoryController@destroy')->name('delete_inventory');
Route::any('/delete_bom_item', 'InventoryController@permDelete')->name('delete_bom_item');
Route::post('/change_inventory_status', 'InventoryController@changeStatus')->name('change_inventory_status');

// -------------INVENTORY ACCESS MODULE-----------
Route::any('/inventory_access', 'InventoryAccessController@index')->name('inventory_access')->middleware('auth.admin');
Route::post('/create_inventory_access', 'InventoryAccessController@create')->name('create_inventory_access');
Route::post('/edit_inventory_access_form', 'InventoryAccessController@editForm')->name('edit_inventory_access_form');
Route::post('/edit_inventory_access', 'InventoryAccessController@edit')->name('edit_inventory_access');
Route::post('/delete_inventory_access', 'InventoryAccessController@destroy')->name('delete_inventory_access');

// -------------INVENTORY ASSIGN MODULE-----------
Route::any('/inventory_assign', 'InventoryAssignController@index')->name('inventory_assign')->middleware('auth');
Route::post('/create_inv_assign', 'InventoryAssignController@create')->name('create_inv_assign');
Route::post('/edit_inv_assign_form', 'InventoryAssignController@editForm')->name('edit_inv_assign_form');
Route::post('/edit_inv_assign', 'InventoryAssignController@edit')->name('edit_inv_assign');
Route::post('/delete_inv_assign', 'InventoryAssignController@destroy')->name('delete_inv_assign');

// -------------INVENTORY RECORD MODULE-----------
Route::any('/inventory_record', 'InventoryRecordController@index')->name('inventory_record')->middleware('auth');
Route::post('/create_inv_record', 'InventoryRecordController@create')->name('create_inv_record');
Route::post('/edit_inv_record_form', 'InventoryRecordController@editForm')->name('edit_inv_record_form');
Route::post('/edit_inv_record', 'InventoryRecordController@edit')->name('edit_inv_record');
Route::any('/search_inventory_record', 'InventoryController@searchInventoryRecord')->name('search_inventory_record');
Route::post('/delete_inv_record', 'InventoryRecordController@destroy')->name('delete_inv_record');


// -------------FINANCIAL YEAR MODULE-----------
Route::any('/financial_year', 'FinancialYearController@index')->name('financial_year')->middleware('auth');
Route::post('/create_financial_year', 'FinancialYearController@create')->name('create_financial_year');
Route::post('/edit_financial_year_form', 'FinancialYearController@editForm')->name('edit_financial_year_form');
Route::post('/edit_financial_year', 'FinancialYearController@edit')->name('edit_financial_year');
Route::post('/financial_year_status', 'FinancialYearController@finYearStatus')->name('financial_year_status');
Route::post('/delete_financial_year', 'FinancialYearController@destroy')->name('delete_financial_year');

// -------------CLOSING BOOK MODULE-----------
Route::any('/closing_books', 'ClosingBooksController@index')->name('closing_books')->middleware('auth');
Route::post('/create_closing_books', 'ClosingBooksController@create')->name('create_closing_books');
Route::post('/edit_closing_books_form', 'ClosingBooksController@editForm')->name('edit_closing_books_form');
Route::post('/edit_closing_books', 'ClosingBooksController@edit')->name('edit_closing_books');
Route::post('/closing_books_status', 'ClosingBooksController@finYearStatus')->name('closing_books_status');
Route::post('/delete_closing_books', 'ClosingBooksController@destroy')->name('delete_closing_books');

// -------------TRANS LOCATION MODULE-----------
Route::any('/trans_location', 'TransLocationController@index')->name('trans_location')->middleware('auth');
Route::post('/create_trans_location', 'TransLocationController@create')->name('create_trans_location');
Route::post('/edit_trans_location_form', 'TransLocationController@editForm')->name('edit_trans_location_form');
Route::post('/edit_trans_location', 'TransLocationController@edit')->name('edit_trans_location');
Route::post('/delete_trans_location', 'TransLocationController@destroy')->name('delete_trans_location');

// -------------TRANS CLASS MODULE-----------
Route::any('/trans_class', 'TransClassController@index')->name('trans_class')->middleware('auth');
Route::post('/create_trans_class', 'TransClassController@create')->name('create_trans_class');
Route::post('/edit_trans_class_form', 'TransClassController@editForm')->name('edit_trans_class_form');
Route::post('/edit_trans_class', 'TransClassController@edit')->name('edit_trans_class');
Route::post('/delete_trans_class', 'TransClassController@destroy')->name('delete_trans_class');

// -------------CHART OF ACCOUNTS MODULE-----------
Route::any('/account_chart', 'AccountChartController@index')->name('account_chart')->middleware('auth');
Route::post('/create_account_chart', 'AccountChartController@create')->name('create_account_chart');
Route::post('/edit_account_chart_form', 'AccountChartController@editForm')->name('edit_account_chart_form');
Route::post('/edit_account_chart', 'AccountChartController@edit')->name('edit_account_chart');
Route::post('/delete_account_chart', 'AccountChartController@destroy')->name('delete_account_chart');
Route::post('/change_account_chart_status', 'AccountChartController@changeStatus')->name('change_account_chart_status');

// -------------PURCHASE ORDER MODULE-----------
Route::any('/purchase_order', 'PurchaseOrderController@index')->name('inventory')->middleware('auth');
Route::post('/edit_po_form', 'PurchaseOrderController@editForm')->name('edit_po_form');
Route::post('/create_po', 'PurchaseOrderController@create')->name('create_po');
Route::post('/edit_po', 'PurchaseOrderController@edit')->name('edit_po');
Route::any('/search_po', 'PurchaseOrderController@searchPo')->name('search_po');
Route::post('/delete_po', 'PurchaseOrderController@destroy')->name('delete_po');
Route::any('/delete_po_item', 'PurchaseOrderController@permDelete')->name('delete_po_item');
Route::post('/change_po_status', 'PurchaseOrderController@changeStatus')->name('change_po_status');
Route::any('/po_remove_attachment', 'PurchaseOrderController@removeAttachment')->name('po_remove_attachment');
Route::any('/po_download_attachment', 'PurchaseOrderController@downloadAttachment')->name('po_download_attachment');