<?php

namespace App\Http\Models;

use marcusvbda\vstack\Models\DefaultModel;
use App\Http\Models\Scopes\OrderByScope;

class Marketplace extends DefaultModel
{
	protected $table = "marketplaces";

	public static function boot()
	{
		parent::boot();
		static::addGlobalScope(new OrderByScope(with(new static)->getTable()));
	}
}
