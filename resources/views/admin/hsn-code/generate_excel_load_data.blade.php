<thead>
<tr>
    <th align="center" width="6%">{!! lang('common.sr_no') !!}</th>
    <th width="15%">{!! lang('hsn_code.hsn_code') !!}</th>
</tr>
</thead>
<tbody>
<?php $index = 1; ?>
@if(count($data) > 0)
    @foreach($data as $detail)
        <tr>
            <td> {!! $index++ !!} </td>
            <td>{!! $detail->hsn_code  !!}</td>

        </tr>
    @endforeach
@else
    <tr>
        <td colspan="2" align="center"> {!! lang('messages.no_data_found') !!}  </td>
    </tr>
@endif
</tbody>