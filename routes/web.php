<?php

use App\Http\Controllers\Auth\UsersController;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

Route::get('', function () {
	return redirect("/admin"); //temporário até termos uma landing page
});

require "partials/auth.php";
Route::group(['middleware' => ['auth']], function () {
	Route::group(['prefix' => "admin"], function () {
		require "partials/home.php";
		require "partials/users.php";
		Route::group(['middleware' => ['root-auth']], function () {
			Route::get('log-viewer', [LogViewerController::class, 'index']);
		});
	});
});

Route::get('user_invite/{tenant_id}/{invite_md5}', [UsersController::class, 'userCreate'])->middleware(['hashids:tenant_id'])->name("user.create");
Route::post('user_invite/{tenant_id}/{invite_md5}', [UsersController::class, 'userConfirm'])->middleware(['hashids:tenant_id'])->name("user.confirm");
