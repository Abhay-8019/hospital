<thead>
<tr>
    {{--<th width="3%"> <input type="checkbox" name="check-all" class="check-all" value="0" /> </th>--}}
    <th width="5%" class="text-center"> {!! lang('common.id') !!} </th>
    <th> {!! lang('user.username') !!} </th>
    <th> {!! lang('user.name') !!} </th>
    {{--<th> {!! lang('hospital.hospital_name') !!} </th>--}}
    <th> {!! lang('user.role') !!} </th>
    @if(hasMenuRoute('user.edit'))
     <th width="6%" class="text-center"> {!! lang('common.status') !!} </th>
     <th class="text-center">{!! lang('common.action') !!}</th>
    @endif 
</tr>
</thead>
<tbody>
<?php $index = 1; ?>
@if (isset($data) && count($data) > 0)
    @foreach($data as $detail)
        <tr id="order_{{ $detail->id }}">
            {{--<td> <input type="checkbox" name="tick[]" value="{{ $detail->id }}" class="check-one" /> </td>--}}
            <td class="text-center">{!! pageIndex($index++, $page, $perPage) !!}</td>
            <td>
                @if(hasMenuRoute('user.edit'))
                    <a href="{!! route('user.edit', [$detail->id]) !!}">
                        {!! $detail->username !!}
                    </a>
                @else
                    {!! $detail->username !!}
                @endif
            </td>
            <td>{!! $detail->name !!}</td>
            {{--<td>{!! $detail->hospital_name !!}</td>--}}
            <td>{!! $detail->role !!}</td>
            @if(hasMenuRoute('user.edit'))
                <td class="text-center">
                    <a href="javascript:void(0);" class="toggle-status" data-message="{!! lang('messages.change_status') !!}" data-route="{!! route('user.toggle', $detail->id) !!}">
                        {!! Html::image('assets/images/' . $detail->status . '.gif') !!}
                    </a>
                </td>
                <td class="text-center col-md-1">
                    <a class="btn btn-xs btn-primary" href="{{ route('user.edit', [$detail->id]) }}"><i class="fa fa-edit"></i></a>
                </td>
            @endif
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