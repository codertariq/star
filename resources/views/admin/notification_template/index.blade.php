@php
//arrtibutes : form= true, false; modal= false, full, normal, lg, xs, sm; ;list = true, false
$data['attribute'] = ['form' => true, 'list' => false, 'modal' => false];
$data['breadcrumbs'] = 'notification-templates.index';
$data['create'] = 'modal';
$data['icon'] = 'icon-bubble-notification';
$data['page'] = __('page.notification_templates');
$data['page_title'] = __('page.notification_templates_title');
$data['permission'] = 'user.';
$data['route'] = 'admin.notification-templates.';
$data['page_index'] = 'admin.notification-templates.index';
@endphp
@extends('layouts.app')
@section('title', __('service.notification_templates'))
@section('page_header')
{{ Breadcrumbs::render(gv($data, 'breadcrumbs', 'home')) }}
@stop
@section('content')
<!-- Main content -->
<div class="content">
    {!! Form::open(['url' => route('admin.notification-templates.store'), 'method' => 'post', 'id' => 'content_form' ]) !!}
    <div class="alert alert-warning alert-styled-left alert-arrow-left alert-dismissible">
            <h4>@lang('service.available_tags'):</h4>
            <p>{{implode(', ', $tags)}}</p>
    </div>
    <div class="card border-success" id="table_card">
        <div class="card-header header-elements-inline text-success-800 border-bottom-success alpha-info ">
            <h5 class="card-title">
            @if(gv($data, 'icon'))
            <i class="{{ $data['icon'] }} mr-2"></i>
            @endif
            {{ __('service.customer_notifications')}}
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <strong>@lang('service.extra_tags'):</strong> {invoice_url}
                    <br><br>
                    @include('admin.notification_template.partials.tabs', ['templates' => $customer_notifications])
                </div>
            </div>
        </div>
    </div>
    <div class="card border-success" id="table_card">
        <div class="card-header header-elements-inline text-success-800 border-bottom-success alpha-info ">
            <h5 class="card-title">
            @if(gv($data, 'icon'))
            <i class="{{ $data['icon'] }} mr-2"></i>
            @endif
            {{  __('service.supplier_notifications') }}
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    @include('admin.notification_template.partials.tabs', ['templates' => $supplier_notifications])
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-right">
            <button type="submit" class="btn btn-danger pull-right">@lang('messages.save')</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>
<!-- /.content -->
@stop
@push('js')
<script src="{{ asset('global_assets/js/plugins/editors/summernote/summernote.min.js') }}"></script>
<script src="{{ asset('js/pages/admin/notification_template.js') }}"></script>
<script>
    _componentUniform();
$('.summernote').summernote({
toolbar: [
['style', ['bold', 'italic', 'underline', 'clear']],
['font', ['strikethrough', 'superscript', 'subscript']],
['fontsize', ['fontsize']],
['color', ['color']],
['para', ['ul', 'ol', 'paragraph']],
['height', ['height']]
]
});
</script>
@endpush