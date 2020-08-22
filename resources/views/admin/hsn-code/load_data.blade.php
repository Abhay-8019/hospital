<thead>
<tr>
    <th width="5%" class="text-center">{!! lang('common.id') !!}</th>
    <th>
        {!! lang('hsn_code.hsn_code') !!}
    </th>

    @if(hasMenuRoute('hsn-code.edit') || isAdmin())
      <th width="6%" class="text-center"> {!! lang('common.status') !!} </th>
    @endif
    @if(hasMenuRoute('hsn-code.drop') || hasMenuRoute('hsn-code.edit') || isAdmin())
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
    <td>
    @if(hasMenuRoute('hsn-code.edit') || isAdmin())
     <a title="{!! lang('common.edit') !!}" href="{!! route('hsn-code.edit', [$detail->id]) !!}">
        {!! $detail->hsn_code!!}
     </a>
     @else
        {!! $detail->hsn_code !!}
     @endif
    </td>
    @if(hasMenuRoute('hsn_code.toggle') || isAdmin())
      <td class="text-center">
        <a title="{!! lang('common.status') !!}" href="javascript:void(0);" class="toggle-status" data-message="{!! lang('messages.change_status') !!}" data-route="{!! route('hsn_code.toggle', $detail->id) !!}">
            {!! Html::image('assets/images/' . $detail->status . '.gif') !!}
        </a>
      </td>
    @endif
      <td class="text-center col-md-1">
          @if(hasMenuRoute('hsn-code.edit') || isAdmin())
            <a title="{!! lang('common.edit') !!}" class="btn btn-xs btn-primary" href="{{ route('hsn-code.edit', [$detail->id]) }}"><i class="fa fa-edit"></i></a>
          @endif
          {{--@if(hasMenuRoute('hsn-code.drop') || isAdmin())
            <a title="{!! lang('common.delete') !!}" class="btn btn-xs btn-danger __drop" data-route="{{ route('hsn-code.drop', [$detail->id]) }}" data-message="{!! lang('messages.sure_delete', string_manip(lang('hsn_code.hsn_code'))) !!}" href="javascript:void(0)"><i class="fa fa-times"></i></a>
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
    <td colspan="4">
        {!! paginationControls($page, $total, $perPage) !!}
    </td>
</tr>
@endif
</tbody>