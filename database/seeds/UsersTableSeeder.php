<?php

use App\Models\Business;
use App\Models\BusinessLocation;
use App\Models\InvoiceLayout;
use App\Models\InvoiceScheme;
use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		$user = User::create([
			'prefix' => 'Mr.',
			'first_name' => 'Tariqul',
			'last_name' => 'Islam',
			'username' => 'tariqulislamrc',
			'email' => 'tariqulislamrc@gmail.com',
			'password' => bcrypt('Tariq1232'),
		]);

		$business = Business::create([
			'name' => 'Satt Pos',
			'currency_id' => 134,
			'owner_id' => $user->id,
			'keyboard_shortcuts' => '{"pos":{"express_checkout":"shift+e","pay_n_ckeckout":"shift+p","draft":"shift+d","cancel":"shift+c","recent_product_quantity":"f2","edit_discount":"shift+i","edit_order_tax":"shift+t","add_payment_row":"shift+r","finalize_payment":"shift+f","add_new_product":"f4"}}',
			'ref_no_prefixes' => '{"purchase":"PO","purchase_return":null,"stock_transfer":"ST","stock_adjustment":"SA","sell_return":"CN","expense":"EP","contacts":"CO","purchase_payment":"PP","sell_payment":"SP","expense_payment":null,"business_location":"BL","username":null,"subscription":null}',
		]);

		$user->business_id = $business->id;
		$user->save();

		$role = Role::create([
			'name' => 'Admin#' . $business->id,
			'guard_name' => 'web',
			'business_id' => $business->id,
			'is_default' => 1,
		]);

		$user->assignRole($role->id);

		$layout = InvoiceLayout::create([
			'business_id' => $business->id,
			'name' => 'Default',
		]);
		$scheme = InvoiceScheme::create([
			'business_id' => $business->id,
			'name' => 'Default',
			'scheme_type' => 'year',
		]);

		BusinessLocation::create([
			'business_id' => $business->id,
			'name' => 'Satt Pos',
			'location_id' => 'BL0001',
			'landmark' => 'Talaimari',
			'invoice_scheme_id' => $scheme->id,
			'invoice_layout_id' => $layout->id,
		]);

	}
}
