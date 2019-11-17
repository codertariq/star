{{-- Main Layout for This Page --}}
@extends('layouts.app')
{{-- Page Title For This Page --}}
@section('title', __('page.reset_password'))
@section('content')
<!-- Content area -->
<div class="content d-flex justify-content-center align-items-center">
	<!-- Login form -->
	{!! Form::open(['url' => route('password.update'), 'id' => 'content_form', 'class' => 'login-form']) !!}
	<div class="card mb-0">
		<div class="card-body">
			<div class="text-center mb-3">
				<i class="icon-checkmark-circle icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>
				<h5 class="mb-0">Update Your Password</h5>
				<span class="d-block text-muted">Set Your new password</span>
			</div>
			<div class="form-group form-group-feedback form-group-feedback-left">
				{{ Form::hidden('token', $token) }}
				{{ Form::email('email', isset($email) ? $email : Null, [
				'placeholder' => __('form.email'),
				'id' => 'email',
				'class' => 'form-control',
				'autocomplete' => '_login_email_or_username',
				'data-parsley-required-message' => __('validation.required', ['attribute' => __('form.email')]),
				'data-parsley-type-message' => __('validation.email', ['attribute' => __('form.email')]),
				'required',
				!isset($email) ? 'autofocus' :''
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
				'data-parsley-minlength-message' => __('validation.min.string', ['attribute' => __('form.password'), 'min' => 8]),
				'minLength' => 8,
				'required',
				isset($email) ? 'autofocus' :''
				]) }}
				<div class="form-control-feedback">
					<i class="icon-lock2 text-muted"></i>
				</div>
			</div>
			<div class="form-group form-group-feedback form-group-feedback-left">
				{{ Form::password('password_confirmation', [
				'placeholder' => __('form.password_confirmation'),
				'id' => 'password_confirmation',
				'class' => 'form-control',
				'data-parsley-required-message' => __('validation.required', ['attribute' => __('form.password_confirmation')]),
				'data-parsley-minlength-message' => __('validation.min.string', ['attribute' => __('form.password_confirmation'), 'min' => 8]),
				'data-parsley-equalto-message' => __('validation.confirmed', ['attribute' => __('form.password')]),
				'minlength' => 8,
				'data-parsley-equalTo' => '#password',
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