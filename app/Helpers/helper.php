<?php

CONST ATTR = ['modal' => ['full', 'normal', 'lg']];
CONST ANIMATE = false;

function active_link($route_or_path, $class = 'active') {
	if (request()->route()->getName() == $route_or_path) {
		return $class;
	}

	if (request()->is($route_or_path)) {
		return $class;
	}
	return false;
}

function nav_item_open($data, $index, $default_class = 'nav-item-open') {
	return in_array($index, $data) ? $default_class : false;
}

function gv($params, $keys, $default = Null) {
	return (isset($params[$keys]) AND $params[$keys]) ? $params[$keys] : $default;
}

function gbv($params, $keys) {
	return (isset($params[$keys]) AND $params[$keys]) ? 1 : 0;
}

function gov($property, $object) {
	$array = explode('->', $property);

	if (count($array) > 1) {
		foreach (explode('->', $n) as $property) {
			$value = gov($property, $value);
		}
	}

	return $object->{$property};
}

function check_https() {
	if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
		return 'https';
	}
	return 'http';
}

function app_url() {
	return check_https() . '://' . $_SERVER['HTTP_HOST'];
}

function getRemoteIPAddress() {
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		return $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	return array_key_exists('REMOTE_ADDR', $_SERVER) ? $_SERVER['REMOTE_ADDR'] : null;
}

function getClientIp() {
	$ips = getRemoteIPAddress();
	$ips = explode(',', $ips);
	return !empty($ips[0]) ? $ips[0] : \Request::getClientIp();
}

function getUserRoleName($user_id) {
	$user = App\User::findOrFail($user_id);

	$roles = $user->getRoleNames();

	$role_name = '';

	if (!empty($roles[0])) {
		$array = explode('#', $roles[0], 2);
		$role_name = !empty($array[0]) ? $array[0] : '';
	}
	return $role_name;
}

function productSerialForSelect($product_id, $variation_id) {

	$serial = \App\ModelsProductSerial::where('product_id', $product_id)->where('variation_id', $variation_id)->where('sell_line_id', Null)->get(['id', 'serial_no']);

	$serial_no = [];
	foreach ($serial as $value) {
		$serial_no[$value->serial_no] = $value->serial_no;
	}

	return $serial_no;
}

function productSerialForShow($product_id, $purchase_line_id, $variation_id) {

	$serial = \App\Models\ProductSerial::where('product_id', $product_id)->where('purchase_line_id', $purchase_line_id)->where('sell_line_id', Null)->where('variation_id', $variation_id)->get(['serial_no']);

	$serial_no = [];
	foreach ($serial as $value) {
		$serial_no[] = $value->serial_no;
	}

	return implode(',', $serial_no);
}