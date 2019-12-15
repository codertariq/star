<img src="{{ asset('table_menu_loader.gif') }}" id="delete_loading_{{$model->id}}" style="display: none;">
<div class="list-icons" id="action_menu_{{$model->id}}">
	<div class="dropdown">
		<a href="#" class="list-icons-item" data-toggle="dropdown">
			<i class="icon-menu9"></i>
		</a>
		<div class="dropdown-menu dropdown-menu-right">

			@can($action['permission'].'update')
			<span class="dropdown-item" data-element="form" id="content_managment" data-url="{{ route($action['route'].'edit', $model->id )}}"><i class="icon-pencil7"></i> {{ __('service.edit') }}</span>
		@endcan
			@if(!$model->is_default)
			@can($action['permission'].'.delete')
			<span class="dropdown-item" id="delete_item" data-id="{{ $model->id }}" data-url="{{ route($action['route'].'destroy', $model->id )}}"><i class="icon-trash"></i> {{ __('service.delete') }} </button></span>
			@endcan
			@endif
			@if(!$model->is_default)
			@can($action['permission'].'.set_default')
			<span class="dropdown-item"  id="set_default" data-id="{{ $model->id }}" data-url="{{ route($action['route'].'set_default', $model->id )}}"><i class="icon-cog"></i> {{ __('invoice.set_default') }} </button></span>
			@endcan
			@endif
		</div>
	</div>
</div>