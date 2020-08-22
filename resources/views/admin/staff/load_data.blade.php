<thead>
<tr>
    <th width="7%" class="text-center">{!! lang('common.id') !!}</th>
    {{--<th>{!! lang('staff.image') !!}</th>--}}
    <th width="15%">{!! lang('common.name').' ['. lang('staff.register_number').']' !!}</th>
    {{--<th>{!! lang('staff.dob')!!}</th>--}}
    <th>{!! lang('common.gender') !!}</th>
    <th>{!! lang('common.email') !!}</th>
    <th>{!! lang('common.contact_number') !!}</th>
    <th>{!! lang('staff.department').' / '.lang('staff.designation') !!}</th>
    <th>{!! lang('staff.do_joining').' / '.lang('staff.do_retirement') !!}</th>
    @if(hasMenuRoute('staff.edit'))
     <th class="text-center"> {!! lang('common.status') !!} </th>
     <th class="text-center">{!! lang('common.action') !!}</th>
    @endif
</tr>
</thead>
<tbody>
<?php
    $index = 1;
    $genderArr = lang('common.genderArray');
    $bloodGroupArr = lang('common.bloodGroupArr');

    $filePath = \Config::get('constants.UPLOADS');
    $folder = ROOT . $filePath;
?>
@if (isset($data) && count($data) > 0)
    @foreach($data as $detail)
        <?php
            $nameAndNumber = ($detail->last_name)? $detail->first_name.' '.$detail->last_name.' ['.$detail->register_number.']' : $detail->first_name . ' ['. $detail->register_number.']';
//            $bloodGroup = ($detail->blood_group != '')? "&nbsp; - &nbsp;".$bloodGroupArr[$detail->blood_group] : '--';
            $gender = ($detail->gender != '')? $genderArr[$detail->gender] : '--';
            $dob = dateFormat('d-m-Y', $detail->dob);
            $doRetirement = ($detail->do_retirement)? "&nbsp; / &nbsp;".convertToLocal($detail->do_retirement, 'd-m-Y') : ' / -- ';
        ?>

        <tr id="order_{{ $detail->id }}">
            <td class="text-center">{!! pageIndex($index++, $page, $perPage) !!}</td>
            <td class="text-center">
                @if(hasMenuRoute('staff.edit'))
                    <a href="{!! route('staff.edit', [$detail->id]) !!}">
                        @if(file_exists($folder . $detail->image) && $detail->image)
                            {!! Html::image($filePath.$detail->image, getFileName($detail->image), ['class' => 'img-responsive img-circle margin0-auto', 'width' => '60']) !!}
                        @endif
                        {!! $nameAndNumber !!}
                    </a>
                @else
                    @if(file_exists($folder . $detail->image) && $detail->image)
                        {!! Html::image($filePath.$detail->image, getFileName($detail->image), ['class' => 'img-responsive img-circle margin0-auto', 'width' => '60']) !!}
                    @endif
                    {!! $nameAndNumber !!}
                @endif
            </td>
            {{--<td>{!! $dob !!}</td>--}}
            <td>{!! $gender !!}</td>
            <td>{!! $detail->email !!}</td>
            <td>{!! $detail->contact_number !!}</td>
            <td>{!! $detail->department_name."&nbsp; /<br/>".$detail->designation_name !!}</td>
            <td>{!! convertToLocal($detail->do_joining, 'd-m-Y'). $doRetirement !!}</td>
            @if(hasMenuRoute('staff.edit'))
                <td class="text-center">
                    <a href="javascript:void(0);" class="toggle-status" data-message="{!! lang('messages.change_status') !!}" data-route="{!! route('staff.toggle', $detail->id) !!}">
                        {!! Html::image('assets/images/' . $detail->status . '.gif') !!}
                    </a>
                </td>
                <td class="text-center col-md-1">
                        <a class="btn btn-xs btn-primary" href="{{ route('staff.edit', [$detail->id]) }}"><i class="fa fa-edit"></i></a>
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
    <tr class="10">
        <td class="text-center" colspan="4"> {!! lang('messages.no_data_found') !!} </td>
    </tr>
@endif
</tbody>