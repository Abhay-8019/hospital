<thead>
<tr>
    <th width="7%" class="text-center">{!! lang('common.id') !!}</th>
    <th>{!! lang('common.name') !!}</th>
    @if(hasMenuRoute('employee-type.edit'))
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
                @if(hasMenuRoute('employee-type.edit'))
                    <a href="{!! route('employee-type.edit', [$detail->id]) !!}">
                        {!! $detail->name !!}
                    </a>
                @else
                    {!! $detail->name !!}
                @endif
            </td>
            @if(hasMenuRoute('employee-type.edit'))
                <td class="text-center">
                    <a href="javascript:void(0);" class="toggle-status" data-message="{!! lang('messages.change_status') !!}" data-route="{!! route('employee-type.toggle', $detail->id) !!}">
                        {!! Html::image('assets/images/' . $detail->status . '.gif') !!}
                    </a>
                </td>
                <td class="text-center col-md-1">
                    <a class="btn btn-xs btn-primary" href="{{ route('employee-type.edit', [$detail->id]) }}"><i class="fa fa-edit"></i></a>
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