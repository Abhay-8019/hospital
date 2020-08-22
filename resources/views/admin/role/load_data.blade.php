<thead>
<tr>
    <th width="5%" class="text-center">{!! lang('common.id') !!}</th>
    <th>{!! lang('common.name') !!}</th>
    <th>{!! lang('common.code') !!}</th>
    @if(hasMenuRoute('role.edit'))
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
                @if(!$detail->isdefault && hasMenuRoute('role.edit'))
                    <a href="{!! route('role.edit', [$detail->id]) !!}">
                        {!! $detail->name !!}
                    </a>
                @else
                    {!! $detail->name !!}
                @endif
            </td>
            <td>{!! $detail->code !!}</td>
            @if(hasMenuRoute('role.edit'))
                <td class="text-center">
                    @if(!$detail->isdefault)
                        <a href="javascript:void(0);" class="toggle-status" data-message="{!! lang('messages.change_status') !!}" data-route="{!! route('role.toggle', $detail->id) !!}">
                            {!! Html::image('assets/images/' . $detail->status . '.gif') !!}
                        </a>
                    @else
                        Default
                    @endif
                </td>
                <td class="text-center col-md-1">
                    @if(!$detail->isdefault)
                        <a class="btn btn-xs btn-primary" href="{{ route('role.edit', [$detail->id]) }}"><i class="fa fa-edit"></i></a>
                    @else
                        Default
                    @endif
                </td>
            @endif
        </tr>
    @endforeach

    <tr class="margintop10">
        <td colspan="5">
            {!! paginationControls($page, $total, $perPage) !!}
        </td>
    </tr>
@else
    <tr>
        <td class="text-center" colspan="5"> {!! lang('messages.no_data_found') !!} </td>
    </tr>
@endif
</tbody>