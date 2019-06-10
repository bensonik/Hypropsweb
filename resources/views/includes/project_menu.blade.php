<ul  class="nav nav-tabs col-md-2 ">
    <li  class="active" onclick="navigatePage('<?php echo url('project_item/'.$item->id.\App\Helpers\Utility::authLink('temp_user')) ?>')">
        <div data-target="#overview" data-toggle="tab">
            <div>
                <span class="account-type">Overview</span><br/>
            </div>
        </div>
    </li>
    <li>
        <div data-target="#timesheet" onclick="navigatePage('<?php echo url('project/'.$item->id.'/timesheet'.\App\Helpers\Utility::authLink('temp_user')) ?>')" data-toggle="tab">
            <div class="ellipsis">
                <span class="account-type">Timesheet</span><br/>
                <span class="account-amount">{{$item->timesheet}}</span><br/>
                <a href="#" class="account-link">Entries</a>
            </div>
        </div>
    </li>
    @if($item->project_head != \App\Helpers\Utility::checkAuth('temp_user')->id || in_array(\App\Helpers\Utility::checkAuth('temp_user')->role,\App\Helpers\Utility::TOP_USERS))
        <li>
            <div data-target="#timesheet" onclick="navigatePage('<?php echo url('project/'.$item->id.'/timesheet_approval'.\App\Helpers\Utility::authLink('temp_user')) ?>')" data-toggle="tab">
                <div class="ellipsis">
                    <span class="account-type">Timesheet</span><br/>
                    <span class="account-amount">Approval</span><br/>
                    <a href="#" class="account-link"></a>
                </div>
            </div>
        </li>
    @endif
    <li>
        <div data-target="#milestone" onclick="navigatePage('<?php echo url('project/'.$item->id.'/milestone'.\App\Helpers\Utility::authLink('temp_user')) ?>')" data-toggle="tab">
            <div>
                <span class="account-type">Milestone</span><br/>
                <span class="account-amount">{{$item->milestone}}</span><br/>
            </div>
        </div>
    </li>
    <li>
        <div data-target="#task_list" onclick="navigatePage('<?php echo url('project/'.$item->id.'/task_list'.\App\Helpers\Utility::authLink('temp_user')) ?>')" data-toggle="tab">
            <div>
                <span class="account-type">Task List</span><br/>
                <span class="account-amount">{{$item->task_list}}</span><br/>
            </div>
        </div>
    </li>
    <li>
        <div data-target="#task" onclick="navigatePage('<?php echo url('project/'.$item->id.'/task'.\App\Helpers\Utility::authLink('temp_user')) ?>')" data-toggle="tab">
            <div>
                <span class="account-type">Task</span><br/>
                <span class="account-amount">{{$item->task}}</span><br/>
                <a href="#" class="account-link">Assigned</a>
            </div>
        </div>
    </li>
    <li class="">
        <div data-target="#team_members" onclick="navigatePage('<?php echo url('project/'.$item->id.'/project_team'.\App\Helpers\Utility::authLink('temp_user')) ?>')" data-toggle="tab">
            <div class="ellipsis">
                <span class="account-type">Team Members</span><br/>
                <span class="account-amount">{{$item->members}}</span><br/>
                <a href="#" class="account-link">Members</a>
            </div>
        </div>
    </li>
    <li>
        <div data-target="#requests" onclick="navigatePage('<?php echo url('project/'.$item->id.'/project_request'.\App\Helpers\Utility::authLink('temp_user')) ?>')" data-toggle="tab">
            <div>
                <span class="account-type">My Requests</span><br/>
                <span class="account-amount">{{$item->requests}}</span><br/>
            </div>
        </div>
    </li>
    @if($item->project_head != \App\Helpers\Utility::checkAuth('temp_user')->id || in_array(\App\Helpers\Utility::checkAuth('temp_user')->role,\App\Helpers\Utility::TOP_USERS))
        <li>
            <div data-target="#all_request" onclick="navigatePage('<?php echo url('project/'.$item->id.'/all_request'.\App\Helpers\Utility::authLink('temp_user')) ?>')" data-toggle="tab">
                <div class="ellipsis">
                    <span class="account-type">Request(s)</span><br/>
                    <span class="account-amount">Awaiting Reply</span><br/>
                    <a href="#" class="account-link">{{$item->all_requests}}</a>
                </div>
            </div>
        </li>
    @endif
    <li>
        <div data-target="#issues" data-toggle="tab">
            <div>
                <span class="account-type">Issues</span><br/>
                <span class="account-amount">{{$item->issues}}</span><br/>
            </div>
        </div>
    </li>
    <li>
        <div data-target="#change_log" data-toggle="tab">
            <div>
                <span class="account-type">Change Log</span><br/>
                <span class="account-amount">{{$item->change_log}}</span><br/>
            </div>
        </div>
    </li>
    <li>
        <div data-target="#decision" data-toggle="tab">
            <div>
                <span class="account-type">Decision</span><br/>
                <span class="account-amount">{{$item->decision}}</span><br/>
                <a href="#" class="account-link">taken</a>
            </div>
        </div>
    </li>
    <li class="">
        <div data-target="#risk" data-toggle="tab">
            <div class="ellipsis">
                <span class="account-type">Risk</span><br/>
                <span class="account-amount">{{$item->risk}}</span><br/>
            </div>
        </div>
    </li>
    <li>
        <div data-target="#assumption" data-toggle="tab">
            <div>
                <span class="account-type">Assumption</span><br/>
                <span class="account-amount">{{$item->assump}}</span><br/>
                <a href="#" class="account-link">Constraint</a><br/>
            </div>
        </div>
    </li>
    <li>
        <div data-target="#deliverable" data-toggle="tab">
            <div>
                <span class="account-type">Deliverable</span><br/>
                <span class="account-amount">{{$item->deliverable}}</span><br/>
            </div>
        </div>
    </li>
    <li>
        <div data-target="#documents" data-toggle="tab">
            <div>
                <span class="account-type">Documents</span><br/>
                <span class="account-amount">{{$item->documents}}</span><br/>
            </div>
        </div>
    </li>
    <li class="">
        <div data-target="#lesson_learnt" data-toggle="tab">
            <div class="ellipsis">
                <span class="account-type">Lesson Learnt</span><br/>
                <span class="account-amount">{{$item->lesson_learnt}}</span><br/>
            </div>
        </div>
    </li>
    <li>
        <div data-target="#status_report" data-toggle="tab">
            <div>
                <span class="account-type">Status Report</span><br/>
            </div>
        </div>
    </li>
    <li>
        <div data-target="#custom_report" data-toggle="tab">
            <div>
                <span class="account-type">Custom Report</span><br/>
            </div>
        </div>
    </li>
</ul>