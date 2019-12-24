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
			@if (auth()->user()->can('product.create'))
			@if ($model->enable_stock == 1)
			<span id="content_managment"  data-url="{{ route('admin.opening-stock.create', $model->id) }}" class="dropdown-item" data-element="form"><i class="fa fa-database"></i>  {{ __("service.add_edit_opening_stock")  }}</span>
			@endif
			@endif
		</div>
	</div>
</div>