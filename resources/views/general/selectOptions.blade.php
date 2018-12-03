
@if($type == 'default_search')
@foreach($optionArray as $data)

<li>
    <a href="#" onclick="dropdownItem('{{$searchId}}','{{$data->firstname}} {{$data->lastname}}','{{$hiddenId}}','{{$data->id}}','{{$listId}}');">{{$data->firstname}} &nbsp; {{$data->lastname}}</a>
</li>

@endforeach
@endif

@if($type == 'search_vendor' || $type == 'search_customer')
    @foreach($optionArray as $data)

        <li>
            <a href="#" onclick="dropdownItem('{{$searchId}}','{{$data->name}} ({{$data->email1}})','{{$hiddenId}}','{{$data->id}}','{{$listId}}');">{{$data->name}} ({{$data->email1}})</a>
        </li>

    @endforeach
@endif

@if($type == 'search_vendor_transact' || $type == 'search_customer_transact')
    @foreach($optionArray as $data)

        <li>
            <a href="#" onclick="dropdownItemTransact('{{$searchId}}','{{$data->name}} ({{$data->email1}})','{{$hiddenId}}','{{$data->id}}','{{$listId}}','overall_sum','<?php echo url('vendor_customer_currency') ?>','foreign_amount');">{{$data->name}} ({{$data->email1}})</a>
        </li>

    @endforeach
@endif

@if($type == 'search_inventory')
    @foreach($optionArray as $data)

        <li>
            <a href="#" onclick="dropdownItem('{{$searchId}}','{{$data->item_name}}','{{$hiddenId}}','{{$data->id}}','{{$listId}}');">{{$data->item_name}}</a>
        </li>

    @endforeach
@endif

@if($type == 'search_inventory_transact')
    @foreach($optionArray as $data)

        <li>
            <a href="#" onclick="dropdownItemInv('{{$searchId}}','{{$data->item_name}}','{{$hiddenId}}','{{$data->id}}','{{$listId}}','{{\App\Helpers\Utility::PURCHASE_DESC}}','<?php echo url('inventory_details') ?>','{{$descId}}','{{$rateId}}','{{$unitMId}}','{{$subTotalId}}','{{$sharedSubTotal}}','{{$overallSum}}','{{$foreignOverallSum}}','<?php echo url('amount_to_default_curr') ?>');">{{$data->item_name}}</a>
        </li>

    @endforeach
@endif

@if($type == 'search_accounts')
    @foreach($optionArray as $data)

        <li>
            <a href="#" onclick="dropdownItem('{{$searchId}}','{{ $data->acct_name.' ('.$data->acct_no.')' }}','{{$hiddenId}}','{{$data->id}}','{{$listId}}');">{{ $data->acct_name.' ('.$data->acct_no.')' }}</a>
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

@if($type == 'account_chart')

    <select name="detail_type"  class="form-control " id=""  >
        @if(count($optionArray) > 0)
            @foreach($optionArray as $data)
                <option value="{{$data->id}}">{{$data->detail_type}}</option>
            @endforeach

        @else
            <option value="">Detail Type</option>
        @endif
    </select>
@endif