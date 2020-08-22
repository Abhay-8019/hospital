<thead>
<tr>
    <th width="5%" class="text-center">{!! lang('common.id') !!}</th>
    <th>
        {!! lang('products.product_code') !!}
    </th>
    <th>
        {!! lang('common.name') !!}
    </th>
    <th>{!! lang('tax.tax') !!}</th>
    <th>{!! lang('hsn_code.hsn_code') !!}</th>
    <th>
        {!! lang('products.unit') !!}
    </th>
    @if(hasMenuRoute('products.edit') || isAdmin())
      <th width="6%" class="text-center"> {!! lang('common.status') !!} </th>
    @endif
    @if(hasMenuRoute('product.drop') || hasMenuRoute('products.edit') || isAdmin())

      <th class="text-center">
          {!! lang('common.action') !!}
      </th>
    @endif
</tr>
</thead>
<tbody>
<?php $index = 1; ?>
@foreach($data as $detail)
<tr id="order_{{ $detail->id }}">
    <td class="text-center">{!! pageIndex($index++, $page, $perPage) !!}</td>
    <td>{!! ($detail->product_code != "") ? $detail->product_code : "--" !!}</td>
    <td>
        @if(hasMenuRoute('products.edit') || isAdmin())
            <a title="{!! lang('common.edit') !!}" href="{!! route('products.edit', [$detail->id]) !!}">
                {!! $detail->product_name!!}
            </a>
        @else
            {!! $detail->product_name !!}
        @endif
    </td>
    <td>{!! $detail->tax_group !!}</td>
    <td>{!! $detail->hsn_code !!}</td>
    <td>{!! $detail->unit !!}</td>
    @if(hasMenuRoute('products.edit') || isAdmin())
      <td class="text-center">
        <a title="{!! lang('common.status') !!}" href="javascript:void(0);" class="toggle-status" data-message="{!! lang('messages.change_status') !!}" data-route="{!! route('products.toggle', $detail->id) !!}">
            {!! Html::image('assets/images/' . $detail->status . '.gif') !!}
        </a>
      </td>
    @endif
      <td class="text-center col-md-1">
          @if(hasMenuRoute('products.edit') || isAdmin())
            <a title="{!! lang('common.edit') !!}" class="btn btn-xs btn-primary" href="{{ route('products.edit', [$detail->id]) }}"><i class="fa fa-edit"></i></a>
          @endif
          {{--@if(hasMenuRoute('product.drop') || isAdmin())
            <a title="{!! lang('common.delete') !!}" class="btn btn-xs btn-danger __drop" data-route="{!! route('product.drop', [$detail->id]) !!}" data-message="{!! lang('messages.sure_delete', string_manip(lang('products.product'))) !!}" href="javascript:void(0)"><i class="fa fa-times"></i></a>
          @endif--}}
      </td>
</tr>
@endforeach
@if (count($data) < 1)
<tr>
    <td class="text-center" colspan="9"> {!! lang('messages.no_data_found') !!} </td>
</tr>
@else
<tr class="margintop10">
    <td colspan="12">
        {!! paginationControls($page, $total, $perPage) !!}
    </td>
</tr>
@endif
</tbody>