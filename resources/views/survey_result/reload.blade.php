@if($type == 'error')
    No match found, please fill in all required fields
    <ul>
        @foreach($mainData as $data)
            <li>{{$data}}</li>
        @endforeach
    </ul>
@endif

@if($type == 'data')
<!-- Example Tab -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                   Survey Result
                    <small></small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);">Action</a></li>
                            <li><a href="javascript:void(0);">Another action</a></li>
                            <li><a href="javascript:void(0);">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <?php $allDept = $mainData->dept; $firstId = $allDept[0]->id; ?>
            <div class="body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs tab-nav-right" role="tablist">
                    <li role="presentation" class="active"><a href="#report" data-toggle="tab">Report</a></li>
                @foreach($mainData->dept as $dept)
                        <li role="presentation" class=""><a href="#dept_tab{{$dept->id}}" data-toggle="tab">{{$dept->dept_name}}</a></li>
                @endforeach
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="report">

                        <ul class="nav nav-tabs tab-nav-right" role="tablist">
                            <li role="presentation" class="active"><a href="#report1" data-toggle="tab">Report 1</a></li>
                            <li role="presentation" class=""><a href="#report2" data-toggle="tab">Report 2</a></li>
                            <li role="presentation" class=""><a href="#report3" data-toggle="tab">Report 3</a></li>

                        </ul>

                        <div class="tab-content" id="report-tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="report1">
                                <b>{{$mainData->survey_name}}</b><hr/>
                                <p>{{$mainData->survey_desc}}</p><hr/>
                                @foreach($mainData->dept2 as $dept2)
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <h3>

                                                <span class=" label bg-black">{{$dept2->dept_name}}</span>
                                            </h3>
                                        </div>
                                        <div class="col-sm-4">
                                        </div>
                                    </div>
                                    @foreach($dept2->questionCategory as $category)
                                        <div class="row">
                                            <div class="col-sm-7">
                                                <h5>

                                                    <span class=" lable bg-black">{{$category->category_name}} </span>
                                                </h5>
                                            </div>
                                            <div class="col-sm-4">
                                                <p class="btn-link">{{$category->questCatNumOption}} out of {{$category->questCatNum}} questions has options  </p>
                                            </div>
                                        </div>
                                        <?php $num = 0; ?>
                                        @foreach($category->answerCategory as $ans)
                                            <div class="row" id="tr_{{$ans->id}}">
                                                <form name="questOptionForm{{$ans->id}}" id="questOptionForm{{$ans->id}}" onsubmit="false;" class="form form-horizontal container" method="post" enctype="multipart/form-data">


                                                    <!-- BEGIN OF ANSWERS AND ANSWER CATEGORY -->
                                                    <?php $num++; ?>
                                                    <input type="hidden" name="answer_id{{$num}}" value="{{$ans->id}}" />
                                                    <div class="row">
                                                        <div class="col-sm-1">
                                                            <div class="form-group pull-right">
                                                                <div class="form-line">
                                                                    <p>{{$num}} </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3 ">
                                                            <div class="form-group ">
                                                                <div class="form-line">
                                                                    <p >{{$ans->category_name}} </p>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="progress ">
                                                                <div class="progress-bar {{\App\Helpers\Utility::surveyPerctentClass($ans->ansCatPerct)}} progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                                                     aria-valuemax="100" style="width: {{$ans->ansCatPerct}}%">
                                                                    <span >{{$ans->ansCatPerct}}% </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-1 ">
                                                            <div class="form-group pull-right">
                                                                <div class="form-line">

                                                                    <p >{{$ans->countQuestCatAnsCat}}/{{$category->countQuestCatAns}}</p>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </form><hr/>


                                            </div>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </div><!-- END OF REPORT 1 TAB CONTENT -->

                            <div role="tabpanel" class="tab-pane fade in" id="report2">
                                gfgfgf
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="report3">
                                gbfmjhghg
                            </div>

                        </div>  <!-- END OF REPORT TAB CONTENT -->

                    </div>

                    @foreach($mainData->dept as $dept)

                        <div role="tabpanel" class="tab-pane fade " id="dept_tab{{$dept->id}}">
                            <b>{{$mainData->survey_name}}</b><hr/>
                            <p>{{$mainData->survey_desc}}</p><hr/>




                            @foreach($dept->questionCategory as $category)
                                <div class="row">
                                    <div class="col-sm-7">
                                        <h3>

                                            <span class=" label bg-black">{{$category->category_name}}</span>
                                        </h3>
                                    </div>
                                    <div class="col-sm-4">
                                    </div>
                                </div>
                                @foreach($category->question as $quest)
                                    <div class="row" id="tr_{{$quest->id}}">
                                        <form name="questOptionForm{{$quest->id}}" id="questOptionForm{{$quest->id}}" onsubmit="false;" class="form form-horizontal container" method="post" enctype="multipart/form-data">

                                            <input type="hidden" name="text_type" value="{{$quest->text_type}}" />
                                            <input type="hidden" name="question_id" value="{{$quest->id}}" />
                                            <input type="hidden" name="survey" value="{{$quest->survey_id}}" />
                                            <input type="hidden" name="department" value="{{$quest->dept_id}}" />
                                            <input type="hidden" name="countExtraAns" value="{{$quest->moreAnsColumnCount}}" />
                                            <input type="hidden" name="countAns" value="{{$quest->count_ans}}" />
                                            <div class="row">

                                                <div class="col-sm-1 ">
                                                    <div class="form-group pull-right">
                                                        <div class="form-line">
                                                            <p class="btn-link">{{$quest->quest_number}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <p  class="btn-link" >{{$quest->question}}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2 ">
                                                    <div class=" pull-right">
                                                        <div class="">
                                                            <span class="btn-link" >Total Participants -- {{$quest->countPeople}}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <hr/>

                                            <!-- END OF QUESTION AND QUESTION CATEGORY -->

                                            <!-- BEGIN OF ANSWERS AND ANSWER CATEGORY -->
                                            @if($quest->text_type == '0')
                                                <?php $num = 0; ?>
                                                @foreach($quest->ans as $ans)
                                                    <?php $num++; ?>
                                                    <input type="hidden" name="answer_id{{$num}}" value="{{$ans->id}}" />
                                                    <div class="row">
                                                        <div class="col-sm-1">
                                                            <div class="form-group pull-right">
                                                                <div class="form-line">
                                                                    <p>{{$num}} </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3 ">
                                                            <div class="form-group ">
                                                                <div class="form-line">
                                                                    <p >{{$ans->ansCat->category_name}}</p>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="progress ">
                                                                <div class="progress-bar {{\App\Helpers\Utility::surveyPerctentClass($ans->userAnsPerct)}} progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                                                     aria-valuemax="100" style="width: {{$ans->userAnsPerct}}%">
                                                                    <span >{{$ans->userAnsPerct}}% </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-1 ">
                                                            <div class="form-group pull-right">
                                                                <div class="form-line">

                                                                    <p value="">{{$ans->userAnsRatioToPeople}} </p>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                @endforeach
                                            @else
                                                <div class="row">
                                                    <div class="col-md-2">

                                                    </div>
                                                    <div class="col-md-8">
                                                        <span>Click Here to View Participant's statements</span>
                                                    </div>

                                                </div>
                                            @endif
                                        </form><hr/>


                                    </div>
                                @endforeach
                            @endforeach

                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Example Tab -->

<script>
    $(document).ready(function() {
        $('table.highchart').highchartTable();
    });
</script>

@endif

