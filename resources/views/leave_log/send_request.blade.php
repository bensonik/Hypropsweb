
@if($data->type == 'next_approval')
    @if(Auth::user()->id == $data->user_id)
    <p>
        Hello {{$data->name}}, {{$data->sender_name}} made a request contained below<br>
        {{$data->desc}}. Please action this request.

    </p>
    @else
        <p>
            Hello {{$data->name}}, {{Auth::user()->firstname}} made a request on behalf of {{$data->sender_name}},<br>
            {{$data->desc}}. Please action this request.
        </p>
    @endif

@endif

@if($data->type == 'request_approved')

    Hello, the request made by {{$data->sender_name}} has been approved.<br>
    {{$data->desc}}.

@endif

@if($data->type == 'request_denied')

    Hello, the request made by {{$data->sender}} has been denied.<br>
    {{$data->desc}}.

@endif