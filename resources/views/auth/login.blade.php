@php
$data['attribute'] = ['form' => true];
$data['page_title'] = '';
@endphp
{{-- Main Layout for This Page --}}
@extends('layouts.app', ['data' => $data])
{{-- Page Title For This Page --}}
@section('title', __('page.login'))
@section('content')
<!-- Content area -->
<div class="content d-flex justify-content-center align-items-center">
	<div class="row">
		@if(Session::has('login_suspend'))
		<div class="col-md-12">
			<div class="alert alert-danger alert-styled-left alert-arrow-left alert-dismissible">
				<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
				{{ Session::get('login_suspend') }}
			</div>
		</div>
		@php
			Session::forget('login_suspend');
		@endphp
		@endif
		<div class="col-md-12 d-flex justify-content-center align-items-center">
			<!-- Login form -->
			{!! Form::open(['url' => route('login'), 'id' => 'content_form', 'class' => 'login-form']) !!}
			<div class="card mb-0">
				<div class="card-body">
					<div class="text-center mb-3">
						<i class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>
						<h5 class="mb-0">Login to your account</h5>
						<span class="d-block text-muted">Enter your credentials below</span>
					</div>
					<div class="form-group form-group-feedback form-group-feedback-left">
						{{ Form::text('email_or_username', null, [
						'placeholder' => __('form.email_or_username'),
						'id' => 'email_or_username',
						'class' => 'form-control',
						'autocomplete' => '_login_email_or_username',
						'data-parsley-required-message' => __('validation.required', ['attribute' => __('form.email_or_username')]),
						'autofocus', 'required'
						]) }}
						<div class="form-control-feedback">
							<i class="icon-user text-muted"></i>
						</div>
					</div>
					<div class="form-group form-group-feedback form-group-feedback-left">
						{{ Form::password('password', [
						'placeholder' => __('form.password'),
						'id' => 'password',
						'class' => 'form-control',
						'data-parsley-required-message' => __('validation.required', ['attribute' => __('form.password')]),
						'data-parsley-minlength-message' => __('validation.min.string', ['attribute' => __('form.password'), 'min' => 6]),
						'minLength' => 6,
						'required'
						]) }}
						<div class="form-control-feedback">
							<i class="icon-lock2 text-muted"></i>
						</div>
					</div>
					<div class="form-group">
						<button id="submit" type="submit" class="btn btn-primary btn-block">
						Submit
						</button>
					</div>
					@if (Route::has('password.request'))
					<div class="text-center">
						<a href="{{ route('password.request') }}">Forgot password?</a>
					</div>
					@endif
				</div>
			</div>
			{!! Form::close() !!}
			<!-- /login form -->
		</div>
	</div>
</div>
<!-- Content area -->
@stop
@push('js')
<script src="{{ asset('js/pages/auth/login.js') }}"></script>
@endpush