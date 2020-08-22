<thead>
<tr>
    <th align="center" width="6%">{!! lang('common.sr_no') !!}</th>
    <th width="50%">{!! lang('products.product_name') !!}</th>
    <th width="15%">{!! lang('products.product_code') !!}</th>
    <th width="15%">{!! lang('hsn_code.hsn_code') !!}</th>
    <th width="15%">{!! lang('unit.unit') !!}</th>
    <th width="15%">{!! lang('tax.gst') !!}</th>
    <th width="15%">{!! lang('products.cost') !!}</th>
    <th width="15%">{!! lang('products.discount') !!}</th>
    <th width="15%">{!! lang('tax.cgst_rate') !!}</th>
    <th width="15%">{!! lang('tax.sgst_rate') !!}</th>
    <th width="15%">{!! lang('tax.igst_rate') !!}</th>
    <th width="50%">{!! lang('products.minimum_level') !!}</th>
    <th width="50%">{!! lang('products.reorder_level') !!}</th>
    <th width="50%">{!! lang('products.maximum_level') !!}</th>
    <th width="50%">{!! lang('products.description') !!}</th>
</tr>
</thead>
<tbody>
<?php $index = 1; ?>
@if(count($data) > 0)
    @foreach($data as $productId => $detail)
        <tr>
            <td> {!! $index++ !!} </td>
            <td>{!! $detail->product_name !!}</td>
            <td>{!! $detail->product_code  !!}</td>
            <td>{!! $detail->hsn_code !!}</td>
            <td>{!! $detail->unit_name !!}</td>
            <td>{!! $detail->tax !!}</td>
            <td>{!! $detail->cost !!}</td>
            <td>{!! $detail->discount !!}</td>
            <td>{!! $detail->cgst_rate  !!}</td>
            <td>{!! $detail->sgst_rate !!}</td>
            <td>{!! $detail->igst_rate !!}</td>
            <td>{!! $detail->minimum_level !!}</td>
            <td>{!! $detail->reorder_level !!}</td>
            <td>{!! $detail->maximum_level !!}</td>
            <td>{!! $detail->description !!}</td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="15" align="center"> {!! lang('messages.no_data_found') !!}  </td>
    </tr>
@endif
</tbody>