<thead>
<tr>
    <th width="5%" class="text-center">{!! lang('common.id') !!}</th>
    <th>{!! lang('menu.display_name') !!}</th>
    <th>{!! lang('menu.route_name') !!}</th>
    <th>{!! lang('menu.parent_name') !!}</th>
    <th>{!! lang('menu.is_in_menu') !!}</th>
    <th>{!! lang('menu.quick_menu') !!}</th>
    <th width="6%" class="text-center"> {!! lang('common.status') !!} </th>
    <th class="text-center">{!! lang('common.action') !!}</th>
</tr>
</thead>
<tbody>
<?php $index = 1; ?>
@if (isset($data) && count($data) > 0)
    @foreach($data as $detail)
        <tr id="order_{{ $detail->id }}">
            <td class="text-center">{!! pageIndex($index++, $page, $perPage) !!}</td>
            <td>
                <a href="{!! route('menu.edit', [$detail->id]) !!}">
                    {!! $detail->name !!}
                </a>
            </td>
            <td>{!! ($detail->route)? $detail->route : '--' !!}</td>
            <td>{!! ($detail->parent)? $detail->parent : '--' !!}</td>
            <?php $is_in_menu = ($detail->is_in_menu && $detail->is_in_menu == 1 ) ? 'fa fa-check' : '' ; ?>
            <td>
                @if($is_in_menu)
                    <span class="{!! $is_in_menu !!}"></span>
                @else
                    --
                @endif
            </td>
            <?php $quick_menu = ($detail->quick_menu && $detail->quick_menu == 1 ) ? 'fa fa-check' : '' ; ?>
            <td>
                @if($quick_menu)
                    <span class="{!! $quick_menu !!}"></span>
                @else
                    --
                @endif
            </td>
            <td class="text-center">
                <a href="javascript:void(0);" class="toggle-status" data-message="{!! lang('messages.change_status') !!}" data-route="{!! route('menu.toggle', $detail->id) !!}">
                    {!! Html::image('assets/images/' . $detail->status . '.gif') !!}
                </a>
            </td>
            <td class="text-center col-md-1">
                <a class="btn btn-xs btn-primary" href="{{ route('menu.edit', [$detail->id]) }}"><i class="fa fa-edit"></i></a>
            </td>
        </tr>
    @endforeach

    <tr class="margintop10">
        <td colspan="8">
            {!! paginationControls($page, $total, $perPage) !!}
        </td>
    </tr>
@else
    <tr>
        <td class="text-center" colspan="8"> {!! lang('messages.no_data_found') !!} </td>
    </tr>
@endif
</tbody>