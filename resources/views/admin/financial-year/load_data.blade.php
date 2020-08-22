<thead>
<tr>
    <th width="5%" class="text-center">{!! lang('common.id') !!}</th>
    <th>
        {!! lang('common.name') !!}
    </th>
    <th>
        {!! lang('common.from_date') !!}
    </th>
    <th>
        {!! lang('common.to_date') !!}
    </th>
    @if(hasMenuRoute('financial-year.edit') || isAdmin() )
        <th class="text-center"> {!! lang('common.status') !!} </th>
    @endif
    @if(hasMenuRoute('financial-year.edit') || isAdmin() )
        <th class="text-center"> {!! lang('financial_year.active_year') !!} </th>
    @endif
    @if(hasMenuRoute('financial-year.edit') || isAdmin() || hasMenuRoute('financial-year.drop'))
        <th class="text-center"> {!! lang('common.action') !!} </th>
    @endif
</tr>
</thead>
<tbody>
@foreach($data as $detail)
    <tr id="order_{{ $detail->id }}">
        <td class="text-center">{{ $detail->id }}</td>
        <td>
            @if(hasMenuRoute('financial-year.edit') || isAdmin())
                <a title="{!! lang('common.edit') !!}" href="{{ route('financial-year.edit', [$detail->id]) }}">
                    {!! $detail->name !!}
                </a>
            @else
                {!! $detail->name !!}
            @endif
        </td>
        <td>{!! dateFormat('d-m-Y',$detail->from_date) !!}</td>
        <td>{!! dateFormat('d-m-Y',$detail->to_date) !!}</td>
        @if(hasMenuRoute('financial-year.edit') || isAdmin())
            <td class="text-center">
                {!! Html::image(asset('assets/images/' . $detail->status . '.gif')) !!}
            </td>
        @endif
        <td class="text-center">
            @if($detail->id == session('fn_id'))
                <span class="btn btn-success btn-xs">
                    {!! lang('common.active') !!}
                </span>
            @else
                <a title="{!! lang('common.change_year') !!}" href="javascript:void(0);" class="__route" data-realod="1"  data-message="{!! lang('messages.change_status') !!}" data-route="{!! route('financial-year.toggle', ['id' => $detail->id, 'c' => 1]) !!}">
                    <span class="btn btn-danger btn-xs">
                        {!! lang('common.change_year') !!}
                    </span>
                </a>
            @endif
        </td>
        <td class="text-center col-md-1">
            @if(hasMenuRoute('financial-year.edit') || isAdmin())
                <a title="{!! lang('common.edit') !!}" class="btn btn-xs btn-primary" href="{{ route('financial-year.edit', [$detail->id]) }}"><i class="fa fa-edit"></i></a>
            @endif
        </td>
    </tr>
@endforeach
@if (count($data) < 1)
    <tr>
        <td class="text-center" colspan="7"> {!! lang('messages.no_data_found') !!} </td>
    </tr>
@else
    <tr>
        <td colspan="7">
            {!! paginationControls($page, $total, $perPage) !!}
        </td>
    </tr>
@endif
</tbody>

