
<!-- TAX SYSTEM -->
@if($type == 'tax')

    <div class="row clearfix remove_tax{{$more}} new_taxes">
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control comp_name_edit comp_name" name="component_name{{$num2}}" placeholder="Component Name">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control tax_agent_edit tax_agent" name="tax_agent{{$num2}}" placeholder="Tax Agent">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="number" class="form-control percentage_edit percentage" name="percentage{{$num2}}" placeholder="Percentage Deduction">
                </div>
            </div>
        </div>

        <div class="col-sm-4 addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','tax','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

        <div class="col-sm-4" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_tax{{$more}}','{{url('add_more')}}','tax','new_taxes','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

    </div>

@endif

<!-- SALARY STRUCTURE -->
@if($type == 'salary_struct')

    <div class="row clearfix remove_sal{{$more}} new_sal">
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select class="form-control comp_name_edit comp_name"  name="salary_comp" >
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
                    <input type="number" class="form-control amount_edit amount" name="amount" placeholder="Amount">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select class="form-control comp_type comp_type_edit"  name="comp_type" >
                        @foreach(\App\Helpers\Utility::COMPONENT_TYPE as $comp)
                            <option value="{{$comp}}">{{$comp}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4 addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','salary_struct','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

        <div class="col-sm-4" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_sal{{$more}}','{{url('add_more')}}','salary_struct','new_sal','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

    </div>

    <div id="add_more"></div>


@endif

<!-- APPROVAL SYSTEM -->
@if($type == 'approval_sys')

    <div class="row clearfix remove_sal{{$more}} new_sal">
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">

                    <input type="text" class="form-control " autocomplete="off" id="select_user{{$num2}}" onkeyup="searchOptionList('select_user{{$num2}}','myUL{{$num2}}','{{url('default_select')}}','default_search','user{{$num2}}');" name="select_user" placeholder="Select User">
                    <input type="hidden" class="user_class_edit user_class" name="user" id="user{{$num2}}" />
                </div>
            </div>
            <ul id="myUL{{$num2}}" class="myUL"></ul>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select class="form-control stage_edit stage"  name="stage" >
                        <option value="">select</option>
                        <?php for($i=0; $i<10;$i++){ ?>
                        @if($i == 0)
                        @else
                            <option value="{{$i}}">Stage {{$i}}</option>
                        @endif

                        <?php } ?>

                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4 addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','approval_sys','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

        <div class="col-sm-4" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_sal{{$more}}','{{url('add_more')}}','approval_sys','new_sal','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

    </div>

    <div id="add_more"></div>


@endif

<!-- COMPETENCY CATEGORY -->
@if($type == 'competency_cat')

    <div class="row clearfix remove_competency{{$more}} new_competency">
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select  class="form-control department department_edit" name="department{{$num2}}" >
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
                <div class="form-line">
                    <select  class="form-control competency competency_edit" name="competency_type{{$num2}}" >
                        <option value="">Competency Type</option>
                        @foreach($compType as $ap)
                            <option value="{{$ap->id}}">{{$ap->skill_comp}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control category category_edit" name="category_name{{$num2}}" placeholder="Category Name">

                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control desc desc_edit" name="description{{$num2}}" placeholder="Description">
                </div>
            </div>
        </div>

        <div class="col-sm-4 addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','competency_cat','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

        <div class="col-sm-4" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_competency{{$more}}','{{url('add_more')}}','competency_cat','new_competency','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

    </div>

@endif

<!-- COMPETENCY FRAMEWORK -->
@if($type == 'behav_comp')

    <div class="row clearfix remove_behav_comp{{$more}} new_behav_comp">
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select  class="form-control department" name="department{{$num2}}" id="dept_behav{{$num2}}" onchange="fillNextInput('dept_behav{{$num2}}','behav_compet{{$num2}}','<?php echo url('default_select'); ?>','dept_frame_behav')">
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
                <div class="form-line">
                    <select  class="form-control position" name="position{{$num2}}" >
                        <option value="">Position</option>
                        @foreach($position as $ap)
                            <option value="{{$ap->id}}">{{$ap->position_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line" id="behav_compet{{$num2}}">
                    <select  class="form-control competency_cat"  name="competency_category{{$num2}}" >
                        <option value="">Competency Category</option>

                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control cat_desc" name="cat_desc{{$num2}}" placeholder="Item Description">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select  class="form-control behav_level" name="behav_level{{$num2}}" >
                        <option value="">Level</option>
                        @for($i=0; $i<6; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4 addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','behav_comp','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

        <div class="col-sm-4" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_behav_comp{{$more}}','{{url('add_more')}}','behav_comp','new_behav_comp','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

    </div>

@endif

@if($type == 'tech_comp')

    <div class="row clearfix remove_tech_comp{{$more}} new_tech_comp">
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select  class="form-control department_tech department_tech_edit" name="department{{$num2}}" id="dept_tech{{$num2}}" onchange="fillNextInput('dept_tech{{$num2}}','tech_compet{{$num2}}','<?php echo url('default_select'); ?>','dept_frame_tech')" >
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
                <div class="form-line">
                    <select  class="form-control position_tech position_tech_edit" name="position{{$num2}}" >
                        <option value="">Position</option>
                        @foreach($position as $ap)
                            <option value="{{$ap->id}}">{{$ap->position_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line" id="tech_compet{{$num2}}">
                    <select  class="form-control competency_cat_tech competency_cat_tech_edit" name="competency_category{{$num2}}" >
                        <option value="">Competency Category</option>

                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <textarea  class="form-control cat_desc_tech cat_desc_tech_edit" name="cat_desc1{{$num2}}" placeholder="Item Description"></textarea>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select  class="form-control tech_level tech_level_edit" name="tech_level{{$num2}}" >
                        <option value="">Level</option>
                        @for($i=0; $i<6; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4 addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','tech_comp','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

        <div class="col-sm-4" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_tech_comp{{$more}}','{{url('add_more')}}','tech_comp','new_tech_comp','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

    </div>

@endif

@if($type == 'pro_qual')

    <div class="row clearfix remove_pro_qual{{$more}} new_pro_qual">
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select  class="form-control department_pro" name="department{{$num2}}" >
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
                <div class="form-line">
                    <select  class="form-control position_pro" name="position{{$num2}}" >
                        <option value="">Position</option>
                        @foreach($position as $ap)
                            <option value="{{$ap->id}}">{{$ap->position_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control min_aca_qual" name="min_aca_qual{{$num2}}" placeholder="Minimum Academic Qualification">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select  class="form-control cog_exp" name="cog_exp{{$num2}}" >
                        <option value="">Cognate Experience</option>
                        @for($i=0; $i<51; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control pro_qual" name="pro_qual{{$num2}}" placeholder="Professional Qualification">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select  class="form-control yr_post_cert" name="yr_post_cert{{$num2}}" >
                        <option value="">Years Post Certification</option>
                        @for($i=0; $i<51; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4 addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','pro_qual','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

        <div class="col-sm-4" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_pro_qual{{$more}}','{{url('add_more')}}','pro_qual','new_pro_qual','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

    </div>

@endif

<!-- UNIT GOAL -->
@if($type == 'unit_goal')

    <tr class="row clearfix remove_unit_goal{{$more}} new_unit_goal">
        <td>
            <div class="col-md-10">
                <div class="form-group">
                    <div class="form-line">
                        <textarea rows="6" class=" strat_obj strat_obj_edit" name="strat_obj" placeholder="Strategic Objective"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea rows="6" class=" measure measure_edit" name="measure" placeholder="Measurement"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea rows="6" class=" q1 q1_edit" name="q1 " placeholder="Target Q1"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea rows="6" class=" q2 q2_edit" name="q2 " placeholder="Target Q2"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea rows="6" class=" q3 q3_edit" name="q3" placeholder="Target Q3"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea rows="6" class=" q4 q4_edit" name="q4" placeholder="Target Q4"></textarea>
                    </div>
                </div>
            </div>
        </td>

        @if($hod == App\Helpers\Utility::HOD_DETECTOR)
        <td>
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <textarea rows="6" class=" ops ops_edit" name="over_perf_score" placeholder="over_perf_score"></textarea>
                    </div>
                </div>
            </div>
        </td>
        @else
        <td>
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <textarea rows="6" class=" ops ops_edit" disabled name="over_perf_score" placeholder="over_perf_score">
                            Awaiting Score
                        </textarea>
                    </div>
                </div>
            </div>
        </td>
        @endif

        <td class="col-sm-4 addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','unit_goal','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td class="col-sm-4" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_unit_goal{{$more}}','{{url('add_more')}}','unit_goal','new_unit_goal','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

    </tr>

@endif

<!-- APP OBJ GOAL -->
@if($type == 'app_obj_goal')

    <tr class="row clearfix remove_app_obj_goal{{$more}} new_app_obj_goal">

                <td>
                    <div class="col-md-10">
                        <div class="form-group">
                            <div class="form-line">
                                <textarea rows="6" cols="40" class=" obj obj_edit" name="obj" placeholder="Objectives"></textarea>
                            </div>
                        </div>
                    </div>
                </td>

                <td>
                    <div class="">
                        <div class="form-group">
                            <div class="form-line">
                                <select  class="form-control obj_level obj_level_edit" name="obj_level" >
                                    <option value="" selected>Level</option>
                                    @foreach(APP\Helpers\Utility::REVIEW_RATE as $key => $val)
                                        <option value="{{$val}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </td>

                <td>
                    <div class="">
                        <div class="form-group">
                            <div class="form-line">
                                <select  class="form-control rev_rate rev_rate_edit" disabled name="rev_rate" >
                                    <option value="" selected>Reviewer Ratings</option>
                                    @foreach(APP\Helpers\Utility::REVIEW_RATE as $key => $val)
                                        <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </td>

        <td class=" addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','app_obj_goal','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td class="" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_app_obj_goal{{$more}}','{{url('add_more')}}','app_obj_goal','new_app_obj_goal','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

    </tr>

@endif

<!-- COMP ASSESS -->
@if($type == 'comp_assess')

    <tr class="row clearfix remove_comp_assess{{$more}} new_comp_assess">

            <td>
                <div class="col-md-10">
                    <div class="form-group">
                        <div class="form-line">
                            <select class=" core_comp core_comp_edit" name="core_comp" id="core_comp{{$num2}}" onchange="fillNextInput('core_comp{{$num2}}','capable{{$num2}}','<?php echo url('default_select'); ?>','core_tech_comp')">
                                <option value="">Core Technical Competency</option>
                                @foreach($techComp as $ap)
                                    <option value="{{$ap->id}}">{{$ap->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </td>

            <td>
                <div class="col-md-10">
                    <div class="form-group">
                        <div class="form-line capable capable_edit" id="capable{{$num2}}" >
                            <select  class="form-control" name="capable"  >
                                <option value="">Capabilities</option>
                            </select>
                        </div>
                    </div>
                </div>
            </td>

                <td>
                    <div class="">
                        <div class="form-group">
                            <div class="form-line">
                                <select  class="form-control comp_level comp_level_edit" name="comp_level" >
                                    <option value="" selected>Level</option>
                                    @foreach(APP\Helpers\Utility::REVIEW_LEVEL as $key => $val)
                                        <option value="{{$val}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </td>

                <td>
                    <div class="">
                        <div class="form-group">
                            <div class="form-line">
                                <select  class="form-control comp_rev_rate comp_rev_rate_edit" disabled name="rev_rate" >
                                    <option value="" selected>Reviewer Ratings</option>
                                    @foreach(APP\Helpers\Utility::REVIEW_RATE as $key => $val)
                                        <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </td>


        <td class=" addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','comp_assess','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td class="" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_comp_assess{{$more}}','{{url('add_more')}}','comp_assess','new_comp_assess','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

    </tr>

@endif

<!-- COMP ASSESS -->
@if($type == 'behav_comp2')

    <tr class="row clearfix remove_behav_comp2{{$more}} new_behav_comp2">

                <td>
                    <div class="">
                        <div class="form-group">
                            <div class="form-line">
                                <select  class="form-control core_behav_comp core_behav_comp_edit" name="core_behav_comp" id="core_behav_comp{{$num2}}" onchange="fillNextInput('core_behav_comp{{$num2}}','element{{$num2}}','<?php echo url('default_select'); ?>','core_behav_comp')" >
                                    <option value="">Core Behavioural Competency</option>
                                    @foreach($behavComp as $ap)
                                        <option value="{{$ap->id}}">{{$ap->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </td>

                <td>
                    <div class="col-md-10">
                        <div class="form-group">
                            <div class="form-line element element_edit" id="element{{$num2}}" >
                                <select  class="form-control" name="element"  >
                                    <option value="">Elements of behavioural competency</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </td>

                <td>
                    <div class="">
                        <div class="form-group">
                            <div class="form-line">
                                <select  class="form-control behav_level behav_level_edit" name="behav_level" >
                                    <option value="" selected>Level</option>
                                    @foreach(APP\Helpers\Utility::REVIEW_LEVEL as $key => $val)
                                        <option value="{{$val}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </td>

                <td>
                    <div class="">
                        <div class="form-group">
                            <div class="form-line">
                                <select  class="form-control behav_rev_rate behav_rev_rate_edit" disabled name="behav_rev_rate" >
                                    <option value="" selected>Reviewer Ratings</option>
                                    @foreach(APP\Helpers\Utility::REVIEW_RATE2 as $key => $val)
                                        <option value="{{$val}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </td>

        <td class=" addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','behav_comp2','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td class="" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_behav_comp2{{$more}}','{{url('add_more')}}','behav_comp2','new_behav_comp2','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

    </tr>

@endif


