<thead>
<tr>
    <th width="7%" class="text-center">{!! lang('common.id') !!}</th>
    <th width="25%">{!! lang('vendor.vendor_name') !!}</th>
    <th>{!! lang('vendor.contact_number') !!}</th>
    <th>{!! lang('vendor.email') !!}</th>
    <th>{!! lang('vendor.company_name') !!}</th>
    @if(hasMenuRoute('vendor.edit'))
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
                @if(hasMenuRoute('vendor.edit'))
                    <a href="{!! route('vendor.edit', [$detail->id]) !!}">
                        {!! $detail->company_name !!}
                    </a>
                @else
                    {!! $detail->company_name !!}
                @endif
            </td>
            <td>{!! $detail->company_phone !!}</td>
            <td>{!! $detail->email !!}</td>
            <td>{!! $detail->name !!}</td>
            @if(hasMenuRoute('vendor.edit'))
                <td width="7%" class="text-center">
                    <a href="javascript:void(0);" class="toggle-status" data-message="{!! lang('messages.change_status') !!}" data-route="{!! route('vendor.toggle', $detail->id) !!}">
                        {!! Html::image('assets/images/' . $detail->status . '.gif') !!}
                    </a>
                </td>
                <td class="text-center col-md-1">
                    <a class="btn btn-xs btn-primary" href="{{ route('vendor.edit', [$detail->id]) }}"><i class="fa fa-edit"></i></a>
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