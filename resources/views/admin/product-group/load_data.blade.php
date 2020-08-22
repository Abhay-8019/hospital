<thead>
<tr>
    <th width="5%" class="text-center">{!! lang('common.id') !!}</th>
    <th>
        {!! lang('common.name') !!}
    </th>
    <th>
        {!! lang('common.code') !!}
    </th>
    @if(hasMenuRoute('product-group.edit') || isAdmin())
        <th class="text-center"> {!! lang('common.status') !!} </th>
    @endif
    @if(hasMenuRoute('product-group.edit') || isAdmin() || hasMenuRoute('product-group.drop'))
        <th class="text-center">{!! lang('common.action') !!}</th>
    @endif
</tr>
</thead>
<tbody>
<?php $index = 1; ?>
@foreach($data as $detail)
    <tr id="order_{{ $detail->id }}">
        <td class="text-center">{!! pageIndex($index++, $page, $perPage) !!}</td>
        <td>
        @if(hasMenuRoute('product-group.edit') || isAdmin())
          <a title="{!! lang('common.edit') !!}" href="{{ route('product-group.edit', [$detail->id]) }}">
           {!! $detail->name !!}
          </a>
        @else
          {!! $detail->name !!}
        @endif
        </td>
        <td>{!! $detail->code !!}</td>
        @if(hasMenuRoute('product-group.edit') || isAdmin())
        <td class="text-center">
            <a title="{!! lang('common.status') !!}" href="javascript:void(0);" class="toggle-status" data-message="{!! lang('messages.change_status') !!}" data-route="{!! route('product-group.toggle', $detail->id) !!}">
                {!! Html::image('assets/images/' . $detail->status . '.gif') !!}
            </a>
        </td>
        @endif
        <td class="text-center col-md-1">
            @if(hasMenuRoute('product-group.edit') || isAdmin())
                <a title="{!! lang('common.edit') !!}" class="btn btn-xs btn-primary" href="{{ route('product-group.edit', [$detail->id]) }}"><i class="fa fa-edit"></i></a>
            @endif
            {{--@if(hasMenuRoute('product-group.drop') || isAdmin())
                <a title="{!! lang('common.delete') !!}" class="btn btn-xs btn-danger __drop" data-route="{!! route('product-group.drop', [$detail->id]) !!}" data-message="{!! lang('messages.sure_delete', string_manip(lang('product_group.product_group'))) !!}" href="javascript:void(0)"><i class="fa fa-times"></i></a>
            @endif--}}
        </td>

    </tr>
@endforeach
@if (count($data) < 1)
    <tr>
        <td class="text-center" colspan="6"> {!! lang('messages.no_data_found') !!} </td>
    </tr>
@else
    <tr class="margintop10">
        <td colspan="6">
            {!! paginationControls($page, $total, $perPage) !!}
        </td>
    </tr>
@endif
</tbody>