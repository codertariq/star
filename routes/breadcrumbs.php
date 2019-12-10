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

Breadcrumbs::for ('business.getBusinessSettings', function ($trail) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('page.settings'), route('admin.business.getBusinessSettings'));
});

Breadcrumbs::for ('business-location.index', function ($trail) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('page.business_location'), route('admin.business-location.index'));
});

Breadcrumbs::for ('invoice-schemes.index', function ($trail) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('page.invoice_schemes'), route('admin.invoice-schemes.index'));
});

Breadcrumbs::for ('invoice-layouts.index', function ($trail) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('page.invoice_layouts'), route('admin.invoice-layouts.index'));
});

Breadcrumbs::for ('invoice-layouts.create', function ($trail) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('page.invoice_layouts'), route('admin.invoice-layouts.index'));
	$trail->push(__('page.new', ['attribute' => __('page.invoice_layouts')]), route('admin.invoice-layouts.create'));
});

Breadcrumbs::for ('invoice-layouts.edit', function ($trail) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('page.invoice_layouts'), route('admin.invoice-layouts.index'));
	$trail->push(__('page.new', ['attribute' => __('page.invoice_layouts')]), route('admin.invoice-layouts.edit'));
});

Breadcrumbs::for ('barcodes.index', function ($trail) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('page.barcodes'), route('admin.barcodes.index'));
});

Breadcrumbs::for ('tax-rates.index', function ($trail) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('page.tax_rates'), route('admin.tax-rates.index'));
});

Breadcrumbs::for ('group-taxes.index', function ($trail) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('page.group_taxes'), route('admin.group-taxes.index'));
});

Breadcrumbs::for ('notification-templates.index', function ($trail) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('page.notification_templates'), route('admin.notification-templates.index'));
});