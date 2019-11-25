
  <div class="row">
    @if(!empty($modules))
    <div class="col-sm-12">
    <h4>@lang('service.enable_disable_modules')</h4>
    </div>
    @foreach($modules as $k => $v)
     <div class="col-sm-6 my-auto">
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                {!! Form::checkbox('enabled_modules[]', $k, in_array($k, $enabled_modules) ,
                [ 'class' => 'form-check-input-styled', 'data-fouc']) !!}{{$v['name']}}
            </label>
            @if(!empty($v['tooltip'])) @show_tooltip($v['tooltip']) @endif
        </div>
    </div>
    @endforeach
    @endif
  </div>
