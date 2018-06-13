
@if($type == 'default_search')
@foreach($optionArray as $data)

<li>
    <a href="#" onclick="dropdownItem('{{$searchId}}','{{$data->firstname}} {{$data->lastname}}','{{$hiddenId}}','{{$data->id}}','{{$listId}}');">{{$data->firstname}} &nbsp; {{$data->lastname}}</a>
</li>

@endforeach
@endif

@if($type == 'search_comp_cat')

        <select name="competency_category"  class="form-control" id="ccompetency_cat"  >
            @if(count($optionArray) > 0)
            @foreach($optionArray as $data)
                <option value="{{$data->id}}">{{$data->category_name}}</option>
            @endforeach

            @else
                <option value="">Competency Category</option>
            @endif
        </select>
@endif

@if($type == 'dept_users')
    @if(count($optionArray) > 0)
        <select name="user"  class="form-control" id=""  >
            @foreach($optionArray as $data)
                <option value="{{$data->id}}">{{$data->firstname}}&nbsp;{{$data->lastname}}</option>
            @endforeach
        </select>
    @else
        <select name="user"  class="form-control" id=""  >
        <option value="">No User found</option>
        </select>
    @endif
@endif

@if($type == 'core_behav_comp')

        <select name="element"  class="form-control element element_edit" id=""  >
            @if(count($optionArray) > 0)
            @foreach($optionArray as $data)
                <option value="{{$data->item_desc}}">{{$data->item_desc}}</option>
            @endforeach

            @else
                <option value="">Element of Behavioural Competency</option>
            @endif
        </select>
@endif

@if($type == 'core_tech_comp')

        <select name="capable"  class="form-control capable capable_edit" id=""  >
            @if(count($optionArray) > 0)
            @foreach($optionArray as $data)
                <option value="{{$data->item_desc}}">{{$data->item_desc}}</option>
            @endforeach

            @else
                <option value="">Capabilities</option>
            @endif
        </select>
@endif

@if($type == 'dept_frame_tech')

    <select name="competency_category"  class="form-control competency_cat_tech competency_cat_tech_edit" id="ccompetency_cat"  >
        @if(count($optionArray) > 0)
            @foreach($optionArray as $data)
                <option value="{{$data->id}}">{{$data->category_name}}</option>
            @endforeach

        @else
            <option value="">Competency Category</option>
        @endif
    </select>
@endif

@if($type == 'dept_frame_behav')

    <select name="competency_category"  class="form-control competency_cat" id="ccompetency_cat"  >
        @if(count($optionArray) > 0)
            @foreach($optionArray as $data)
                <option value="{{$data->id}}">{{$data->category_name}}</option>
            @endforeach

        @else
            <option value="">Competency Category</option>
        @endif
    </select>
@endif