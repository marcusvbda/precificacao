<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\User;
use App\Http\Models\{
	Tenant
};
use DB;

class UsersSeeder extends Seeder
{
	public function run()
	{
		DB::statement('SET AUTOCOMMIT=0;');
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		$this->createTenant();
		$this->createUsers();
		DB::statement('SET AUTOCOMMIT=1;');
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		DB::statement('COMMIT;');
	}

	private function createTenant()
	{
		DB::table("tenants")->truncate();
		$this->tenant = Tenant::create([
			"name" => "Empresa de Teste",
			"data" => [
				"city" => "Marilia",
				"state" => "São Paulo"
			]
		]);
	}

	private function createUsers()
	{
		DB::table("users")->truncate();
		$user = new User();
		$user->name = "Administrador";
		$user->email = "root@root.com";
		$user->password = "root";
		$user->tenant_id = 1;
		$user->role = "super-admin";
		$user->save();
	}
}
