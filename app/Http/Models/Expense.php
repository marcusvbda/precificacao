<?php

namespace App\Http\Models;

use marcusvbda\vstack\Models\DefaultModel;
use App\Http\Models\Scopes\OrderByScope;

class Expense extends DefaultModel
{
    protected $table = "expenses";

    public $appends = ["f_value", "f_type"];

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OrderByScope(with(new static)->getTable()));
    }

    public function getFTypeAttribute()
    {
        if ($this->type == "percentage") {
            return "Porcentagem";
        }
        return "Valor Fixo";
    }

    public function getFValueAttribute()
    {
        $value = $this->value;
        if ($this->type == "percentage") {
            return $value . " %";
        }
        return "R$ " . $value;
    }
}
