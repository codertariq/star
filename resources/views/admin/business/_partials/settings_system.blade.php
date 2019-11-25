<div class="pos-tab-content">
    <div class="row">
     {{--    <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('theme_color', __('service.theme_color')); !!}
                {!! Form::select('theme_color', $theme_colors,   $business->theme_color,
                ['class' => 'form-control select', 'placeholder' => __('messages.please_select'), 'style' => 'width: 100%;']); !!}
            </div>
        </div>
 --}}
        <div class="col-sm-4 my-auto">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    {!! Form::checkbox('enable_tooltip', 1, $business->enable_tooltip,
                    [ 'class' => 'form-check-input-styled', 'data-fouc', 'id' => 'enable_tooltip']) !!}  {{ __( 'business.show_help_text' ) }}
                </label>
            </div>
        </div>
    </div>
</div>