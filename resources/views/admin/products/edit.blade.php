@extends('layouts.admin')

@section('content_header')
    <section class="content-header">
        <h1>
            {!! lang('common.edit_heading', lang('products.product')) !!} #{!! $result->product_name !!}
            <small>{!! lang('common.record_update') !!}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="javascript:void(0)" class="_back"><i class="fa fa-arrow-left"></i> {!! lang('common.back') !!}</a></li>
            <li><a href="{!! route('products.index') !!}">{!! lang('product_group.product_group') !!}</a></li>
            <li class="active">{!! lang('common.edit_heading', lang('products.product')) !!}</li>
        </ol>
    </section>
@stop

@section('content')
    <div id="page-wrapper">
        {{-- for message rendering --}}
        @include('layouts.messages')
        <div class="row">
            <div class="col-md-12 padding0">
                @include('admin.products.form_common')
            </div>
        </div>
    </div>
    <!-- /#page-wrapper -->
@stop
@section('script')
    <script type="text/javascript">
        $('#product-type').on('change', function() {
            var value = $(this).val();
            if (value == 4) {
                $('#product-group').removeClass('hidden');
            } else {
                $('#product-group').addClass('hidden');
            }
        });

        $('.has_excise').on('change', function() {
            var value = $(this).val();
            if (value == 0) {
                $(this).val(1);
                $('#excise_d').removeClass('hidden');
            } else {
                $(this).val(0);
                $('#excise_d').addClass('hidden');
            }
        });

        $('.has_vat').on('change', function() {
            var value = $(this).val();
            if (value == 0) {
                $(this).val(1);
                $('#vat_d').removeClass('hidden');
            } else {
                $(this).val(0);
                $('#vat_d').addClass('hidden');
            }
        });
    </script>
@stop
