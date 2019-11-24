<div class="row">
	<div class="col-md-12">
		<h4>@lang('service.more_info')</h4>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<p><strong>@lang( 'service.dob' ):</strong> @if(!empty($model->dob)) {{@format_date($model->dob)}} @endif</p>
		<p><strong>@lang( 'service.marital_status' ):</strong> @if(!empty($model->marital_status)) @lang('service.' .$model->marital_status) @endif</p>
		<p><strong>@lang( 'service.blood_group' ):</strong> {{$model->blood_group ?? ''}}</p>
		<p><strong>@lang( 'service.contact_no' ):</strong> {{$model->contact_number ?? ''}}</p>
	</div>
	<div class="col-md-4">
		<p><strong>@lang( 'service.fb_link' ):</strong> {{$model->fb_link ?? ''}}</p>
		<p><strong>@lang( 'service.twitter_link' ):</strong> {{$model->twitter_link ?? ''}}</p>
		<p><strong>@lang( 'service.social_media', ['number' => 1] ):</strong> {{$model->social_media_1 ?? ''}}</p>
		<p><strong>@lang( 'service.social_media', ['number' => 2] ):</strong> {{$model->social_media_2 ?? ''}}</p>
	</div>
	<div class="col-md-4">
		<p><strong>@lang( 'service.custom_field', ['number' => 1] ):</strong> {{$model->custom_field_1 ?? ''}}</p>
		<p><strong>@lang( 'service.custom_field', ['number' => 2] ):</strong> {{$model->custom_field_2 ?? ''}}</p>
		<p><strong>@lang( 'service.custom_field', ['number' => 3] ):</strong> {{$model->custom_field_3 ?? ''}}</p>
		<p><strong>@lang( 'service.custom_field', ['number' => 4] ):</strong> {{$model->custom_field_4 ?? ''}}</p>
	</div>

	<div class="col-md-4">
		<p><strong>@lang('service.id_proof_name'):</strong>
		{{$model->id_proof_name ?? ''}}</p>
	</div>
	<div class="col-md-4">
		<p><strong>@lang('service.id_proof_number'):</strong>
		{{$model->id_proof_number ?? ''}}</p>
	</div>
	</div>
	<hr>
	<div class="row">
	<div class="col-md-6">
		<strong>@lang('service.permanent_address'):</strong><br>
		<p>{{$model->permanent_address ?? ''}}</p>
	</div>
	<div class="col-md-6">
		<strong>@lang('service.current_address'):</strong><br>
		<p>{{$model->current_address ?? ''}}</p>
	</div>
</div>
<hr>
<div class="row">
	<div class="col-md-12">
		<h4>@lang('service.bank_details'):</h4>
	</div>
	@php
	$bank_details = !empty($model->bank_details) ? json_decode($model->bank_details, true) : [];
	@endphp
	<div class="col-md-4">
		<p><strong>@lang('service.account_holder_name'):</strong> {{$bank_details['account_holder_name'] ?? ''}}</p>
		<p><strong>@lang('service.account_number'):</strong> {{$bank_details['account_number'] ?? ''}}</p>
	</div>
	<div class="col-md-4">
		<p><strong>@lang('service.bank_name'):</strong> {{$bank_details['bank_name'] ?? ''}}</p>
		<p><strong>@lang('service.bank_code'):</strong> {{$bank_details['bank_code'] ?? ''}}</p>
	</div>
	<div class="col-md-4">
		<p><strong>@lang('service.branch'):</strong> {{$bank_details['branch'] ?? ''}}</p>
		<p><strong>@lang('service.tax_payer_id'):</strong> {{$bank_details['tax_payer_id'] ?? ''}}</p>
	</div>
</div>
</div>