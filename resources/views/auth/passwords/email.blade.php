{{-- Main Layout for This Page --}}
@extends('layouts.app')
{{-- Page Title For This Page --}}
@section('title', __('page.forgot_password'))
@section('content')
<!-- Content area -->
<div class="content d-flex justify-content-center align-items-center">
	<!-- Login form -->
	{!! Form::open(['url' => route('password.email'), 'id' => 'content_form', 'class' => 'login-form']) !!}
	<div class="card mb-0">
		<div class="card-body">
			<div class="text-center mb-3">
				<i class="icon-spinner11 icon-2x text-warning border-warning border-3 rounded-round p-3 mb-3 mt-1"></i>
				<h5 class="mb-0">Password recovery</h5>
				<span class="d-block text-muted">We'll send you instructions in email</span>
			</div>
			<div class="form-group form-group-feedback form-group-feedback-left">
				{{ Form::email('email', null, [
				'placeholder' => __('form.email'),
				'id' => 'email',
				'class' => 'form-control',
				'autocomplete' => '_login_email',
				'data-parsley-required-message' => __('validation.required', ['attribute' => __('form.email')]),
				'data-parsley-type-message' => __('validation.email', ['attribute' => __('form.email')]),
				'autofocus', 'required'
				]) }}
				<div class="form-control-feedback">
					<i class="icon-user text-muted"></i>
				</div>
			</div>

			<div class="form-group">
				<button id="submit" type="submit" class="btn btn-primary btn-block">
				Submit
				</button>
			</div>
			@if (Route::has('login'))
			<div class="text-center">
				<a href="{{ route('login') }}">Back To Login?</a>
			</div>
			@endif
		</div>
	</div>
	{!! Form::close() !!}
	<!-- /login form -->
</div>
<!-- Content area -->
@stop
@push('js')
<script src="{{ asset('js/pages/auth/login.js') }}"></script>
@endpush