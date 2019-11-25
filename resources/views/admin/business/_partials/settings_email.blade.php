<div class="row">
    @if(!empty($allow_superadmin_email_settings))
    <div class="col-sm-12">
        <div class="form-group">
            <div class="checkbox">
                <br>
                <label>
                    {!! Form::checkbox('email_settings[use_superadmin_settings]', 1, !empty($email_settings['use_superadmin_settings']) ,
                    [ 'class' => 'input-icheck', 'id' => 'use_superadmin_settings']); !!} {{ __( 'service.use_superadmin_email_settings' ) }}
                </label>
            </div>
        </div>
    </div>
    @endif

        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('email_settings[mail_driver]', __('service.mail_driver') . ':') !!}
                {!! Form::select('email_settings[mail_driver]', $mail_drivers, !empty($email_settings['mail_driver']) ? $email_settings['mail_driver'] : 'smtp', ['class' => 'form-control select']); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('email_settings[mail_host]', __('service.mail_host') . ':') !!}
                {!! Form::text('email_settings[mail_host]', $email_settings['mail_host'], ['class' => 'form-control','placeholder' => __('service.mail_host')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('email_settings[mail_port]', __('service.mail_port') . ':') !!}
                {!! Form::text('email_settings[mail_port]', $email_settings['mail_port'], ['class' => 'form-control','placeholder' => __('service.mail_port')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('email_settings[mail_username]', __('service.mail_username') . ':') !!}
                {!! Form::text('email_settings[mail_username]', $email_settings['mail_username'], ['class' => 'form-control','placeholder' => __('service.mail_username')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('email_settings[mail_password]', __('service.mail_password') . ':') !!}
                <input type="password" name="email_settings[mail_password]" value="{{$email_settings['mail_password']}}" class="form-control" placeholder="{{__('service.mail_password')}}">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('email_settings[mail_encryption]', __('service.mail_encryption') . ':') !!}
                {!! Form::text('email_settings[mail_encryption]', $email_settings['mail_encryption'], ['class' => 'form-control','placeholder' => __('service.mail_encryption_place')]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('email_settings[mail_from_address]', __('service.mail_from_address') . ':') !!}
                {!! Form::email('email_settings[mail_from_address]', $email_settings['mail_from_address'], ['class' => 'form-control','placeholder' => __('service.mail_from_address') ]); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('email_settings[mail_from_name]', __('service.mail_from_name') . ':') !!}
                {!! Form::text('email_settings[mail_from_name]', $email_settings['mail_from_name'], ['class' => 'form-control','placeholder' => __('service.mail_from_name')]); !!}
            </div>
        </div>

</div>