<thead>
<tr>
    <th width="7%" class="text-center">{!! lang('common.id') !!}</th>
    <th>{!! lang('room.room_name') !!}</th>
    <th width="28%">{!! lang('room.floor') !!}</th>
    <th>{!! lang('room.room_type') !!}</th>
    <th>{!! lang('room.room_charges') !!}</th>
    @if(hasMenuRoute('room.edit'))
        <th class="text-center"> {!! lang('common.status') !!} </th>
        <th class="text-center">{!! lang('common.action') !!}</th>
    @endif
</tr>
</thead>
<tbody>
<?php $index = 1; $roomType = lang('common.room_type'); ?>
@if (isset($data) && count($data) > 0)
    @foreach($data as $detail)
        <tr id="order_{{ $detail->id }}">
            <td class="text-center">{!! pageIndex($index++, $page, $perPage) !!}</td>
            <td>
                @if(hasMenuRoute('room.edit'))
                    <a href="{!! route('room.edit', [$detail->id]) !!}">
                        {!! $detail->room_name.' ['. $detail->room_code.']' !!}
                    </a>
                @else
                    {!! $detail->room_name.' ['. $detail->room_code.']' !!}
                @endif
            </td>
            <td>{!! $detail->floor_name !!}</td>
            <td>{!! ($detail->room_type)? $roomType[$detail->room_type] : '--' !!}</td>
            <td>{!! numberFormat($detail->room_charges) !!}</td>
            @if(hasMenuRoute('room.edit'))
                <td class="text-center">
                    <a href="javascript:void(0);" class="toggle-status" data-message="{!! lang('messages.change_status') !!}" data-route="{!! route('room.toggle', $detail->id) !!}">
                        {!! Html::image('assets/images/' . $detail->status . '.gif') !!}
                    </a>
                </td>
                <td class="text-center col-md-1">
                    <a class="btn btn-xs btn-primary" href="{{ route('room.edit', [$detail->id]) }}"><i class="fa fa-edit"></i></a>
                </td>
            @endif
        </tr>
    @endforeach

    <tr class="margintop10">
        <td colspan="7">
            {!! paginationControls($page, $total, $perPage) !!}
        </td>
    </tr>
@else
    <tr>
        <td class="text-center" colspan="7"> {!! lang('messages.no_data_found') !!} </td>
    </tr>
@endif
</tbody>