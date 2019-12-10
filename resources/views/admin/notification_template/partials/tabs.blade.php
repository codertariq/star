<!-- Custom Tabs -->
<ul class="nav nav-tabs nav-tabs-bottom">
    @foreach($templates as $key => $value)
    <li class="nav-item @if($loop->index == 0) active @endif">
        <a href="#cn_{{$key}}" class="nav-link @if($loop->index == 0) active @endif" data-toggle="tab">
        {{$value['name']}} </a>
    </li>
    @endforeach
</ul>
<div class="tab-content">
    @foreach($templates as $key => $value)
    <div class="tab-pane fade show @if($loop->index == 0) active @endif" id="cn_{{$key}}">
        @if(!empty($value['extra_tags']))
        <strong>@lang('service.available_tags'):</strong>
        <p class="text-primary">{{implode(', ', $value['extra_tags'])}}</p>
        @endif
        @if(!empty($value['help_text']))
        <p class="help-block">{{$value['help_text']}}</p>
        @endif
        <div class="form-group">
            {!! Form::label($key . '_subject',
            __('service.email_subject').':') !!}
            {!! Form::text('template_data[' . $key . '][subject]',
            $value['subject'], ['class' => 'form-control'
            , 'placeholder' => __('service.email_subject'), 'id' => $key . '_subject']); !!}
        </div>
        <div class="form-group">
            {!! Form::label($key . '_email_body',
            __('service.email_body').':') !!}
            {!! Form::textarea('template_data[' . $key . '][email_body]',
            $value['email_body'], ['class' => 'form-control summernote'
            , 'placeholder' => __('service.email_body'), 'id' => $key . '_email_body', 'rows' => 6]); !!}
        </div>
        <div class="form-group">
            {!! Form::label($key . '_sms_body',
            __('service.sms_body').':') !!}
            {!! Form::textarea('template_data[' . $key . '][sms_body]',
            $value['sms_body'], ['class' => 'form-control'
            , 'placeholder' => __('service.sms_body'), 'id' => $key . '_sms_body', 'rows' => 6]); !!}
        </div>
        @if($key == 'new_sale')
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                {!! Form::checkbox('template_data[' . $key . '][auto_send]', 1, $value['auto_send'], ['class' => 'form-check-input-styled']); !!} @lang('service.autosend_email')
            </label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                {!! Form::checkbox('template_data[' . $key . '][auto_send_sms]', 1, $value['auto_send_sms'], ['class' => 'form-check-input-styled']); !!} @lang('service.autosend_sms')
            </label>
        </div>
        @endif
    </div>
    @endforeach
</div>