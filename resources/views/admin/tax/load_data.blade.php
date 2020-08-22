<thead>
<tr>
    <th width="5%" class="text-center">{!! lang('common.id') !!}</th>
    <th>{!! lang('common.name') !!}</th>
    @if(hasMenuRoute('tax.edit') || isAdmin())
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
        @if(hasMenuRoute('tax.edit') || isAdmin())
         <a href="{{ route('tax.edit', [$detail->id]) }}">
           {!! $detail->name !!}
         </a>
        @else
           {!! $detail->name !!}
        @endif
        </td>
        @if(hasMenuRoute('tax.edit') || isAdmin())
         <td class="text-center col-md-1">
            <a class="btn btn-xs btn-primary" href="{{ route('tax.edit', [$detail->id]) }}"><i class="fa fa-edit"></i></a>
         </td>
        @endif
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