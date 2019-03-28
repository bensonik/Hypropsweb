@extends('layouts.letter_head')

@section('content')

    <div class="row">
     <div class="col-md-6"></div>
    <div class="col-md-6">
        <table class="table table-bordered table-hover table-striped" id="">
            <thead>
            <tr>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Invoice #</td>
                <td>{{$data->id}}</td>
            <tr>
                <td>Created At</td>
                <td>{{\App\Helpers\Utility::standardDate($data->created_at)}}</td>
            </tr>
            </tbody>
        </table>
    </div>
    </div>


    <table class="table table-bordered table-hover table-striped" id="">
        <thead>
        <tr>

            <th>Category</th>
            <th>Description</th>
            <th>Request Type</th>
            <th>Project</th>
            <th>Amount {{\App\Helpers\Utility::defaultCurrency()}}</th>
            <th>Requested by</th>
            <th>Department</th>
            <th>Approved by</th>
            <th>Created by</th>
            <th>Created at</th>
        </tr>
        </thead>
        <tbody>

            <tr>

                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                <td>{{$data->requestCat->request_name}}</td>
                <td>{{$data->req_desc}}</td>

                <td>{{$data->requestType->request_type}}</td>
                <td>
                    @if($data->proj_id != 0)
                        {{$data->project->project_name}}
                    @endif
                </td>
                <td>{{number_format($data->amount)}}</td>
                <td>
                    <table class="table table-bordered table-hover table-striped" id="">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Sub Total</td>
                            <td>{{number_format($data->amount)}}</td>
                        <tr>
                            <td>Total</td>
                            <td>{{number_format($data->amount)}}</td>
                        </tr>
                        </tbody>
                    </table>
                </td>

                <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

            </tr>

        </tbody>
    </table>

    <table class="table table-bordered table-hover table-striped" id="">
        <thead>
        <tr>

            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>


        <tr>
            <td>Approved By</td>
            <td>
                @if($data->approved_users != '')
                    <table class="table table-bordered table-responsive">
                        <thead>
                        <th>Name</th>
                        </thead>
                        <tbody>
                        @foreach($data->approved_by as $users)
                            <tr>
                                <td>{{$users->firstname}} &nbsp; {{$users->lastname}}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                @else
                    @if($data->approval_status === 1)
                        Management
                    @endif
                @endif
            </td>

        </tr>
        <tr>
            <td>Created By</td>
            <td>
                @if($data->created_by != '0')
                    {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                @endif
            </td>
        </tr>
        </tbody>
    </table>

@endsection