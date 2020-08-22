<thead>
<tr>
    <th width="5%" class="text-center">{!! lang('common.id') !!}</th>
    <th>{!! lang('common.name') !!}</th>
    <th>{!! lang('common.code') !!}</th>
    <th>{!! lang('department.floor_name') !!}</th>
    <th>{!! lang('common.description') !!}</th>
    @if(hasMenuRoute('department.edit'))
     <th class="text-center"> {!! lang('common.status') !!} </th>
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
        @if(hasMenuRoute('department.edit'))
          <a href="{{ route('department.edit', [$detail->id]) }}">
            {!! $detail->name !!}
          </a>
        @else
         {!! $detail->name !!}
        @endif
           
        </td>
        <td>{!! $detail->code !!}</td>
        <td>{!! $detail->floor_name !!}</td>
        <td>{!! $detail->description !!}</td>
        @if(hasMenuRoute('department.edit'))
          <td class="text-center">
            <a href="javascript:void(0);" class="toggle-status" data-message="{!! lang('messages.change_status') !!}" data-route="{!! route('department.toggle', $detail->id) !!}">
                {!! Html::image('assets/images/' . $detail->status . '.gif') !!}
            </a>
          </td>
          <td class="text-center col-md-1">
            <a class="btn btn-xs btn-primary" href="{{ route('department.edit', [$detail->id]) }}"><i class="fa fa-edit"></i></a>
          </td>
        @endif
    </tr>
@endforeach
@if (count($data) < 1)
    <tr>
        <td class="text-center" colspan="7"> {!! lang('messages.no_data_found') !!} </td>
    </tr>
@else
    <tr class="margintop10">
        <td colspan="7">
            {!! paginationControls($page, $total, $perPage) !!}
        </td>
    </tr>
@endif
</tbody>