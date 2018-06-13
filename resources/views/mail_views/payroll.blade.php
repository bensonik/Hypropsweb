@if($data->type == 'update_request')
Hello, {{$data->sender}} sent {{$data->comp_type}}, please action this task
@endif

@if($data->type == 'process_request')
    Hello, {{$data->sender}} sent {{$data->comp_type}}, please action this task
@endif

@if($data->type == 'request_approval')
    Hello, {{$data->sender}} from Accounts/Finance department made some payments as briefed below
    {{$data->desc}}
@endif