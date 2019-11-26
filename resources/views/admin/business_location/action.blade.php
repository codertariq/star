<img src="{{ asset('table_menu_loader.gif') }}" id="delete_loading_{{$model->id}}" style="display: none;">
<div class="list-icons" id="action_menu_{{$model->id}}">
	<div class="dropdown">
		<a href="#" class="list-icons-item" data-toggle="dropdown">
			<i class="icon-menu9"></i>
		</a>
		<div class="dropdown-menu dropdown-menu-right">
			@if(!in_array('show', $action['action_exeption']))
			@can($action['permission'].'view')
			<span class="dropdown-item" id="content_managment" data-url="{{ route($action['route'].'show', $model->id )}}"><i class="icon-eye"></i>{{ __('service.view') }}</span>
			@endcan
			@endif
			@if(!in_array('edit', $action['action_exeption']))
			@can($action['permission'].'update')
			<span class="dropdown-item" data-element="form" id="content_managment" data-url="{{ route($action['route'].'edit', $model->id )}}"><i class="icon-pencil7"></i> {{ __('service.edit') }}</span>
			@endcan
			@endif
			@if(!in_array('destroy', $action['action_exeption']))
			@can($action['permission'].'.delete')
			<span class="dropdown-item" id="delete_item" data-id="{{ $model->id }}" data-url="{{ route($action['route'].'destroy', $model->id )}}"><i class="icon-trash"></i> {{ __('service.delete') }} </button></span>
			@endcan
			@endif
			@if(!in_array('settings', $action['action_exeption']))
			@can($action['permission'].'.settings')
			<span class="dropdown-item" id="content_managment" data-id="{{ $model->id }}" data-url="{{ route($action['route'].'settings', $model->id )}}"><i class="icon-cog"></i> {{ __('service.settings') }} </button></span>
			@endcan
			@endif
		</div>
	</div>
</div>