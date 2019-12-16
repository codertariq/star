<img src="{{ asset('table_menu_loader.gif') }}" id="delete_loading_{{$model->id}}" style="display: none;">
<div class="list-icons" id="action_menu_{{$model->id}}">
	<div class="dropdown">
		<a href="#" class="list-icons-item" data-toggle="dropdown">
			<i class="icon-menu9"></i>
		</a>
		<div class="dropdown-menu dropdown-menu-right">
			<span class="dropdown-item" id="content_managment" data-url="{{ route($action['route'].'view', $model->id )}}"><i class="icon-eye"></i>{{ __('service.view') }}</span>
			@can($action['permission'].'update')
			<a class="dropdown-item"  href="{{ route($action['route'].'edit', $model->id )}}"><i class="icon-pencil7"></i> {{ __('service.edit') }}</a>
		@endcan
			@if(!$model->is_default)
			@can($action['permission'].'.delete')
			<span class="dropdown-item" id="delete_item" data-id="{{ $model->id }}" data-url="{{ route($action['route'].'destroy', $model->id )}}"><i class="icon-trash"></i> {{ __('service.delete') }} </button></span>
			@endcan
			@endif
		</div>
	</div>
</div>