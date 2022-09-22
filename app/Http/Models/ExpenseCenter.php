<?php

namespace App\Http\Models;

use marcusvbda\vstack\Models\DefaultModel;
use App\Http\Models\Scopes\OrderByScope;

class ExpenseCenter extends DefaultModel
{
    protected $table = "expense_centers";

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OrderByScope(with(new static)->getTable()));
    }

    public function expenses()
    {
        return $this->belongsToMany(Expense::class, "product_expense_centers", "expense_center_id", "expense_id");
    }
}
