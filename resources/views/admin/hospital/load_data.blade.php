<thead>
<tr>
    <th width="1%" class="text-center">{!! lang('common.id') !!}</th>
    <th>{!! lang('hospital.hospital_code') !!}</th>
    <th>{!! lang('hospital.hospital_name') !!}</th>
    <th>{!! lang('hospital.contact_person') !!}</th>
    <th>{!! lang('hospital.gst_number') !!}</th>
    <th>{!! lang('hospital.email') !!}</th>
    <th>{!! lang('hospital.mobile') !!}</th>
    @if(hasMenuRoute('hospital.edit'))
        <th class="text-center"> {!! lang('common.status') !!} </th>
        <th class="text-center">{!! lang('common.action') !!}</th>
    @endif
</tr>
</thead>
<tbody>
<?php $index = 1;
$dutyType = lang('common.duty_type');
$filePath = \Config::get('constants.UPLOADS');
$folder = ROOT . $filePath;
?>
@if (isset($data) && count($data) > 0)
    @foreach($data as $detail)
        <tr id="order_{{ $detail->id }}">
            <td class="text-center">{!! pageIndex($index++, $page, $perPage) !!}</td>
            <td> {!! $detail->hospital_code !!} </td>
            <td>
                @if(hasMenuRoute('hospital.edit'))
                    <a href="{!! route('hospital.edit', [$detail->id]) !!}">
                        {!! $detail->hospital_name !!}
                    </a>
                @else
                    {!! $detail->hospital_name !!}
                @endif
            </td>
            <td> {!! $detail->contact_person !!} </td>
            <td> {!! $detail->tin_number !!} </td>
            <td> {!! $detail->email !!} </td>
            <td> {!! $detail->mobile !!} </td>
            @if(hasMenuRoute('hospital.edit'))
                <td class="text-center">
                    <a href="javascript:void(0);" class="toggle-status" data-message="{!! lang('messages.change_status') !!}" data-route="{!! route('hospital.toggle', $detail->id) !!}">
                        {!! Html::image('assets/images/' . $detail->status . '.gif') !!}
                    </a>
                </td>
                <td class="text-center col-md-1">
                    <a class="btn btn-xs btn-primary" href="{{ route('hospital.edit', [$detail->id]) }}"><i class="fa fa-edit"></i></a>
                </td>
            @endif
        </tr>
    @endforeach

    <tr class="margintop10">
        <td colspan="10">
            {!! paginationControls($page, $total, $perPage) !!}
        </td>
    </tr>
@else
    <tr>
        <td class="text-center" colspan="10"> {!! lang('messages.no_data_found') !!} </td>
    </tr>
@endif
</tbody>