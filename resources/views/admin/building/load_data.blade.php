<thead>
<tr>
    <th width="7%" class="text-center">{!! lang('common.id') !!}</th>
    <th>{!! lang('common.name') !!}</th>
    <th>{!! lang('building.building_code') !!}</th>
    <th>{!! lang('building.building_location') !!}</th>
    <th>{!! lang('building.no_of_floors') !!}</th>
    @if(hasMenuRoute('building.edit'))
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
                @if(hasMenuRoute('building.edit'))
                    <a href="{!! route('building.edit', [$detail->id]) !!}">
                        {!! $detail->name !!}
                    </a>
                @else
                    {!! $detail->name !!}
                @endif
            </td>
            <td>{!! $detail->building_code !!}</td>
            <td>{!! $detail->location !!}</td>
            <td>{!! $detail->no_of_floors !!}</td>
            @if(hasMenuRoute('building.edit'))
                <td class="text-center">
                    <a href="javascript:void(0);" class="toggle-status" data-message="{!! lang('messages.change_status') !!}" data-route="{!! route('building.toggle', $detail->id) !!}">
                        {!! Html::image('assets/images/' . $detail->status . '.gif') !!}
                    </a>
                </td>
                <td class="text-center col-md-1">
                    <a class="btn btn-xs btn-success" href="{{ route('building.add', [$detail->id]) }}"><i class="fa fa-plus"></i></a>
                    <a class="btn btn-xs btn-primary" href="{{ route('building.edit', [$detail->id]) }}"><i class="fa fa-edit"></i></a>
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