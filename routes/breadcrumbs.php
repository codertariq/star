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

Breadcrumbs::for ('contacts.index', function ($trail, $type) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('service.' . $type . 's'), route('admin.notification-templates.index'));
});

Breadcrumbs::for ('customer-group.index', function ($trail) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('page.customer_group'), route('admin.customer-group.index'));
});

Breadcrumbs::for ('units.index', function ($trail) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('page.unit'), route('admin.units.index'));
});

Breadcrumbs::for ('categories.index', function ($trail) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('page.category'), route('admin.categories.index'));
});

Breadcrumbs::for ('brands.index', function ($trail) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('page.brand'), route('admin.brands.index'));
});

Breadcrumbs::for ('variation-templates.index', function ($trail) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('page.variation_template'), route('admin.variation-templates.index'));
});

Breadcrumbs::for ('models.index', function ($trail) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('page.model'), route('admin.models.index'));
});

Breadcrumbs::for ('selling-price-group.index', function ($trail) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('page.selling_price_group'), route('admin.selling-price-group.index'));
});

Breadcrumbs::for ('products.create', function ($trail) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('page.product'), route('admin.products.index'));
	$trail->push(__('product.add_new_product'), route('admin.products.create'));
});

Breadcrumbs::for ('products.index', function ($trail) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('page.product'), route('admin.products.index'));
});

Breadcrumbs::for ('products.edit', function ($trail, $product) {
	$trail->push(__('page.home'), route('home'));
	$trail->push(__('page.product'), route('admin.products.index'));
	$trail->push($product->name, route('admin.products.edit', $product->id));
});