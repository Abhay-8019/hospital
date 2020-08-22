<thead>
<tr>
    <th width="7%" class="text-center">{!! lang('common.id') !!}</th>
    <th width="25%">{!! lang('event_type.event_type') !!}</th>
    @if(hasMenuRoute('event_type.edit'))
        <th class="text-center"> {!! lang('common.status') !!} </th>
        <th class="text-center">{!! lang('common.action') !!}</th>
    @endif
</tr>
</thead>
<tbody>
<?php $index = 1; ?>
@if (isset($data) && count($data) > 0)
    @foreach($data as $detail)
        <tr id="order_{{ $detail->id }}">
            <td class="text-center">{!! pageIndex($index++, $page, $perPage) !!}</td>
            <td>
                @if(hasMenuRoute('event_type.edit'))
                    <a href="{!! route('event_type.edit', [$detail->id]) !!}">
                        {!! $detail->event_type !!}
                    </a>
                @else
                    {!! $detail->event_type !!}
                @endif
            </td>
            @if(hasMenuRoute('event_type.edit'))
                <td width="7%" class="text-center">
                    <a href="javascript:void(0);" class="toggle-status" data-message="{!! lang('messages.change_status') !!}" data-route="{!! route('event_type.toggle', $detail->id) !!}">
                        {!! Html::image('assets/images/' . $detail->status . '.gif') !!}
                    </a>
                </td>
                <td class="text-center col-md-1">
                    <a class="btn btn-xs btn-primary" href="{{ route('event_type.edit', [$detail->id]) }}"><i class="fa fa-edit"></i></a>
                </td>
            @endif
        </tr>
    @endforeach

    <tr class="margintop10">
        <td colspan="4">
            {!! paginationControls($page, $total, $perPage) !!}
        </td>
    </tr>
@else
    <tr>
        <td class="text-center" colspan="4"> {!! lang('messages.no_data_found') !!} </td>
    </tr>
@endif
</tbody>