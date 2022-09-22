<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Http\Acl;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		if (config("app.force_https")) {
			URL::forceScheme('https');
		}
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */

	public function boot()
	{
		Schema::defaultStringLength(191);
		Paginator::useBootstrap();

		$this->loadMigrationsFrom(base_path('database/migrations'), 'migrations');

		Blade::directive('canViewList', function ($resources) {
			$resources = str_replace(['"', "'"], '', $resources);
			$resources = explode(',', $resources);
			foreach ($resources as $resource) {
				$resourceClass = "\\App\\Http\\Resources\\" . trim($resource);
				if ($resourceClass::getStaticMethod('canViewList')) {
					return "<?php if (true): ?>";
				}
			}
			return "<?php if (false): ?>";
		});

		Blade::directive('endCanViewList', function () {
			return "<?php endif; ?>";
		});
	}
}
