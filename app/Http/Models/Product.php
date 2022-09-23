<?php

namespace App\Http\Models;

use marcusvbda\vstack\Models\DefaultModel;
use App\Http\Models\Scopes\OrderByScope;

class Product extends DefaultModel
{
	protected $table = "products";

	public static function boot()
	{
		parent::boot();
		static::addGlobalScope(new OrderByScope(with(new static)->getTable()));
	}

	public function expenseCenter()
	{
		return $this->belongsToMany(ExpenseCenter::class, "product_expense_centers", "product_id", "expense_center_id");
	}

	public function getExpenseCenterIdsAttribute()
	{
		return $this->expenseCenter()->pluck("id")->ToArray();
	}
}
