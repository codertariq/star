@php
$data['page'] = __('page.user');
$data['route'] = 'admin.user.';
@endphp
<div class="row">
    <div class="col-md-12">
        @isset($model)
        {!! Form::model($model, ['route' => [$data['route'].'update', $model->id], 'class' => 'form-validate-jquery', 'id' => 'content_form', 'method' => 'PUT', 'files' => true]) !!}
        @else
        {!! Form::open(['route' => $data['route'].'store', 'class' => 'form-validate-jquery', 'id' => 'content_form', 'files' => true, 'method' => 'POST']) !!}
        @endif
        <fieldset class="mb-3">
            <legend class="text-uppercase font-size-sm font-weight-bold">{{isset($model) ? __('service.update', ['attribute' => gv($data, 'page')]) : __('service.new', ['attribute' => gv($data, 'page')])}} <span class="text-danger">*</span> <small> {{ __('service.required', ['attribute' => gv($data, 'page')]) }} </small></legend>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {{ Form::label('description', __('service.description', ['attribute' => gv($data, 'page')]) , ['class' => 'col-form-label']) }}
                        {{ Form::textarea('description', Null, ['class' => 'form-control', 'placeholder' =>  __('service.description', ['attribute' => gv($data, 'page')]), 'style' => 'resize: none;', 'rows' => '3']) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="form-check form-check-switchery form-check-inline form-check-right">
                            <label for="" class="form-check-label">{{ __('service.status', ['attribute' => gv($data, 'page')]) }}</label>
                            <input type="checkbox" name="status" id="status" value="1" class="form-check-input-switchery mt-3" data-fouc {{ (isset($model) and $model) ? $model->status ? 'checked' : '' : 'checked' }}>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    {{ Form::submit(__('service.submit', ['attribute' => gv($data, 'page')]), ['class' => 'btn btn-primary ml-3l', 'id' => 'submit']) }}
                    {{--   <button type="button" class="btn btn-link" id="submiting" style="display: none;" disabled="">{{ __('service.submiting', ['attribute' => gv($data, 'page')]) }} <img src="{{ asset('asset/ajaxloader.gif') }}"></button> --}}
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> {{  __('service.close', ['attribute' => gv($data, 'page')]) }} </button>
                </div>
            </div>
        </fieldset>
        {!! Form::close() !!}
    </div>
</div>
<script>
_componentInputSwitchery();
if ($('.modal-dialog-scrollable').length > 0) {
    console.log('Tariq');
    _componentPerfectScrollbar('.modal-body');
}
</script>
