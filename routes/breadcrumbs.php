<?php

Breadcrumbs::for ('home', function ($trail) {
	$trail->push(__('page.home'), route('home'));
});

Breadcrumbs::for ('user.index', function ($trail) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('page.user'), route('admin.user.index'));
});

Breadcrumbs::for ('role.index', function ($trail) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('page.role'), route('admin.role.index'));
});

Breadcrumbs::for ('sales-commission-agents.index', function ($trail) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('service.sales_commission_agents'), route('admin.sales-commission-agents.index'));
});