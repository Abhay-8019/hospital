<thead>
<tr>
    <th width="7%" class="text-center">{!! lang('common.id') !!}</th>
    <th width="22%">{!! lang('event.event_name') !!}</th>
    <th>{!! lang('event.event_start') !!} / {!! lang('event.event_end') !!}</th>
    <th>{!! lang('event.is_holiday') !!}</th>
    <th>{!! lang('event.event_type') !!}</th>
    @if(hasMenuRoute('add_events.edit'))
        <th class="text-center"> {!! lang('common.status') !!} </th>
        <th class="text-center">{!! lang('common.action') !!}</th>
    @endif
</tr>
</thead>
<tbody>
<?php
    $index = 1;  $faCheckIcon = "<i class='fa fa-check'>&nbsp;</i>";
    $eventFor = lang('common.event_for');
?>
@if (isset($data) && count($data) > 0)
    @foreach($data as $detail)
        <tr id="order_{{ $detail->id }}">
            <td class="text-center">{!! pageIndex($index++, $page, $perPage) !!}</td>
            <td>
                @if(hasMenuRoute('add_events.edit'))
                    <a href="{!! route('add_events.edit', [$detail->id]) !!}">
                        {!! $detail->event_name.' ['. $detail->event_code .']' !!}
                    </a>
                @else
                    {!! $detail->event_name.' ['. $detail->event_code .']' !!}
                @endif
            </td>
            <td>{!! convertToLocal($detail->event_start, 'd-m-Y') !!} / {!! convertToLocal($detail->event_end, 'd-m-Y') !!}</td>
            <td>{!! ($detail->is_holiday)? $faCheckIcon : '--' !!}</td>
            <td>{!! ($detail->event_type)? $detail->event_type : '--' !!}</td>
            @if(hasMenuRoute('add_events.edit'))
                <td width="7%" class="text-center">
                    <a href="javascript:void(0);" class="toggle-status" data-message="{!! lang('messages.change_status') !!}" data-route="{!! route('add_events.toggle', $detail->id) !!}">
                        {!! Html::image('assets/images/' . $detail->status . '.gif') !!}
                    </a>
                </td>
                <td class="text-center col-md-1">
                    <a class="btn btn-xs btn-primary" href="{{ route('add_events.edit', [$detail->id]) }}"><i class="fa fa-edit"></i></a>
                </td>
            @endif
        </tr>
    @endforeach

    <tr class="margintop10">
        <td colspan="9">
            {!! paginationControls($page, $total, $perPage) !!}
        </td>
    </tr>
@else
    <tr>
        <td class="text-center" colspan="9"> {!! lang('messages.no_data_found') !!} </td>
    </tr>
@endif
</tbody>