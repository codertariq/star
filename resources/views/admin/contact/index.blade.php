@php
//arrtibutes : form= true, false; modal= false, full, normal, lg, xs, sm; ;list = true, false
$data['attribute'] = ['form' => true, 'list' => true, 'modal' => 'full'];
$data['breadcrumbs'] = 'contacts.index';
$data['create'] = 'modal';
$data['icon'] = 'icon-make-group';
$data['page'] =__('service.'.$type.'s');
$data['page_title'] = __( 'contact.manage_your_contact', ['contacts' =>  __('service.'.$type.'s') ]);
$data['permission'] = 'user.';
$data['route'] = 'admin.contacts.';
$data['page_index'] = 'admin.contacts.index';
@endphp
{{-- Main Layout for This Page --}}
@extends('layouts.app', ['data' => $data])
{{-- Page Title For This Page --}}
@section('title', $data['page_title'])
@section('page_header')
{{ Breadcrumbs::render(gv($data, 'breadcrumbs', 'home'), $type) }}
@stop
@section('content')
<div class="content">
    <div class="card border-success" id="table_card">
        <div class="card-header header-elements-inline text-success-800 border-bottom-success alpha-info ">
            <h5 class="card-title">
            @if(gv($data, 'icon'))
            <i class="{{ $data['icon'] }} mr-2"></i>
            @endif
            {{ $data['page_title'] }}
            @if(isset($data['route']) and Route::has($data['route'].'create'))
            @if($data['create'] == 'modal' and gv($data['attribute'], 'modal') and in_array($data['attribute']['modal'], ATTR['modal']))
            <button type="button" class="btn btn-success btn-sm rounded-round ml-1" id="content_managment" data-url="{{ route($data['route'].'create', ['type' => $type]) }}" data-element="form">
            <i class="icon-stack-plus mr-1"></i>
            {{ __('page.new', ['attribute' => gv($data, 'page', __('page.home'))]) }}
            </button>
            @elseif($data['create'] == 'link')
            <a class="btn btn-success btn-sm rounded-round ml-1" href="{{ route($data['route'].'create',['type' => $type]) }}">
                <i class="icon-stack-plus mr-1"></i>
                {{ __('page.new', ['attribute' => gv($data, 'page', __('page.home'))]) }}
            </a>
            @endif
            @endif
            </h5>
            <div class="header-elements">
                <div class="list-icons">
                    @if (gv($data['attribute'], 'list'))
                    <a class="list-icons-item" data-action="reload" id="reload"></a>
                    @endif
                    <a class="list-icons-item" data-action="fullscreen"></a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <input type="hidden" value="{{$type}}" id="contact_type">
            <table class="table content_management_datatable table-striped" data-url="@if(isset($data['route']) and Route::has($data['route'].'create')){{ route($data['route'].'index', ['get' => 'datatable', 'type' => $type]) }}@endif" id="contact_table">
                <thead>
                    <tr>
                        <th></th>
                        <th>@lang('service.contact_id')</th>
                        @if($type == 'supplier')
                        <th>@lang('business.business_name')</th>
                        <th>@lang('contact.name')</th>
                        <th>@lang('contact.contact')</th>
                        <th>@lang('contact.total_purchase_due')</th>
                        <th>@lang('service.total_purchase_return_due')</th>
                        @elseif( $type == 'customer')
                        <th>@lang('user.name')</th>
                        <th>@lang('service.customer_group')</th>
                        <th>@lang('business.address')</th>
                        <th>@lang('contact.contact')</th>
                        <th>@lang('contact.total_sale_due')</th>
                        <th>@lang('service.total_sell_return_due')</th>
                        @endif
                        <th class="text-center">@lang('page.actions')</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                <tr class="bg-gray font-17 text-center footer-total">
                    <td @if($type == 'supplier') colspan="5" @elseif( $type == 'customer') colspan="6" @endif><strong>@lang('sale.total'):</strong></td>
                    <td><span class="display_currency" id="footer_contact_due" data-currency_symbol ="true"></span></td>
                    <td><span class="display_currency" id="footer_contact_return_due" data-currency_symbol ="true"></span></td>
                    <td></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@stop
@push('js')
<script src="{{ asset('js/pages/admin/contact.js') }}"></script>
@endpush