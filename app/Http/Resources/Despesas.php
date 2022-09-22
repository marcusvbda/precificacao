<?php

namespace App\Http\Resources;

use marcusvbda\vstack\Resource;
use App\Http\Models\Expense;
use marcusvbda\vstack\Fields\BelongsTo;
use marcusvbda\vstack\Fields\Card;
use marcusvbda\vstack\Fields\Radio;
use marcusvbda\vstack\Fields\Text;

class Despesas extends Resource
{
	public $model = Expense::class;

	public function globallySearchable()
	{
		return false;
	}

	public function label()
	{
		return "Despesas";
	}

	public function singularLabel()
	{
		return "Despesa";
	}

	public function icon()
	{
		return "el-icon-price-tag";
	}

	public function search()
	{
		return ["name"];
	}

	public function table()
	{
		$columns = [];
		$columns["code"] = ["label" => "Código", "sortable_index" => "id"];
		$columns["name"] = ["label" => "Nome"];
		$columns["f_value"] = ["label" => "Valor", "sortable_index" => "value"];
		$columns["f_created_at_badge"] = ["label" => "Data", "sortable_index" => "created_at"];
		return $columns;
	}

	public function canClone()
	{
		return false;
	}

	public function canCreate()
	{
		return hasPermissionTo("create-expenses");
	}

	public function canUpdate()
	{
		return hasPermissionTo("edit-expenses");
	}

	public function canDelete()
	{
		return hasPermissionTo("destroy-expenses");
	}

	public function canImport()
	{
		return false;
	}

	public function canExport()
	{
		return false;
	}

	public function canViewList()
	{
		return hasPermissionTo("viewlist-expenses");
	}

	public function canView()
	{
		return false;
	}


	public function fields()
	{
		$fields[] = new Text([
			"label" => "Nome",
			"field" => "name",
			"description" => "Para identificação da despesa",
			"rules" => ["required", "max:255"]
		]);

		$cards[] = new Card("Informações Básicas", $fields);

		$fields = [];
		$fields[] = new Radio([
			"label" => "Tipo",
			"field" => "type",
			"description" => "Tipo de calculo",
			"default" => "fixed",
			"rules" => ["required"],
			"options" => [
				["value" => "fixed", "label" => "Valor Fixo"],
				["value" => "percentage", "label" => "Porcentagem"],
			]
		]);
		$fields[] = new Text([
			"label" => "Valor",
			"type" => "number",
			"step" => .01,
			"field" => "value",
			"rules" => ["required"],
		]);
		$cards[] = new Card("Configurações", $fields);

		return $cards;
	}
}
