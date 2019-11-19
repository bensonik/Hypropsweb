@extends('layouts.app')

@section('content')

    <!-- News Modal -->
    <div class="modal fade" id="news_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">News Content</h4>
                </div>
                <div class="modal-body" id="" style="height:450px; overflow:scroll;">
                    <h5 id="news_title_id"></h5>
                    <span id="news_detail_id"></span>

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

you are welcome

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Upcoming Events
                        <small></small>
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                @include('includes/export',[$exportId = 'upcoming_events', $exportDocId = 'upcoming_events'])
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div id="upcoming_events">

                    </div>
                </div>
            </div>
        </div>

    </div>

<div id="dashboard_reports"></div>



<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function loadDashboardReports(id,page){
        $('#'+id).html('Loading Dashboard Reports...');
        $.ajax({
            type:'POST',
            url: page,
            data: 'get=rough'
        }).done(function(data){
            $('#'+id).html(data);

        });

    }

    ;
    setInterval(loadDashboardReports('dashboard_reports','<?php echo url("dashboard_report") ?>'), 36000);

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('upcoming_events');


        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
            height: 'parent',
            header: {
                left: 'prevYear,prev,next,nextYear today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            defaultView: 'dayGridMonth',
            defaultDate: '{{date('Y-m-d')}}',
            navLinks: true, // can click day/week names to navigate views

            selectable: true,
            selectMirror: true,
            selectHelper: true,

            editable: false,

            eventLimit: false, // allow "more" link when too many events
            events: '{{url('load_dashboard_general_calendar')}}'
        });

        calendar.render();
    });


</script>

@endsection