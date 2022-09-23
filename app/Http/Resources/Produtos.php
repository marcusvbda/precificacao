<?php

namespace App\Http\Resources;

use App\Http\Models\ExpenseCenter;
use marcusvbda\vstack\Resource;
use App\Http\Models\Product;
use marcusvbda\vstack\Fields\BelongsTo;
use marcusvbda\vstack\Fields\Card;
use marcusvbda\vstack\Fields\CustomComponent;
use marcusvbda\vstack\Fields\Radio;
use marcusvbda\vstack\Fields\Text;

class Produtos extends Resource
{
	public $model = Product::class;

	public function globallySearchable()
	{
		return false;
	}

	public function label()
	{
		return "Produtos";
	}

	public function singularLabel()
	{
		return "Produto";
	}

	public function icon()
	{
		return "el-icon-brush";
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
		$columns["f_created_at_badge"] = ["label" => "Data", "sortable_index" => "created_at"];
		return $columns;
	}

	public function canClone()
	{
		return false;
	}

	public function canCreate()
	{
		return hasPermissionTo("create-products");
	}

	public function canUpdate()
	{
		return hasPermissionTo("edit-products");
	}

	public function canDelete()
	{
		return hasPermissionTo("destroy-products");
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
		return hasPermissionTo("viewlist-products");
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
			"description" => "Para identificação do produto",
			"rules" => ["required", "max:255"],
		]);
		$fields[] = new Text([
			"label" => "Ean",
			"field" => "ean",
			"description" => "Código único do produto",
			"rules" => ["required", "max:255"],
		]);
		$cards[] = new Card("Informações Básicas", $fields);

		$fields = [];
		$fields[] = new Text([
			"label" => "Preço",
			"description" => "Preço base do produto",
			"type" => "number",
			"step" => .01,
			"field" => "base_price",
			"default" => 0,
			"rules" => ["required", "max:9999999999"],
		]);
		$fields[] = new Radio([
			"label" => "Tipo de Margem",
			"field" => "margin_type",
			"description" => "Tipo de calculo da margem",
			"default" => "fixed",
			"rules" => ["required"],
			"options" => [
				["value" => "fixed", "label" => "Valor Fixo"],
				["value" => "percentage", "label" => "Porcentagem"],
			]
		]);
		$fields[] = new Text([
			"label" => "Margem",
			"description" => "Margem de lucro do produto",
			"type" => "number",
			"step" => .01,
			"field" => "margin",
			"default" => 0,
			"rules" => ["required", "max:9999999999"],
		]);
		$fields[] = new BelongsTo([
			'label' => 'Centro de custo',
			'description' => 'Centro de custo que deseja utilizar para calcular a precificação do produto',
			'field' => 'expense_center_ids',
			'multiple' => true,
			'model' => ExpenseCenter::class
		]);

		$fields[] = new CustomComponent("<expense-center-preview :form='form'></expense-center-preview>");
		$cards[] = new Card("Configurações", $fields);

		return $cards;
	}

	public function storeMethod($id, $data)
	{
		$expense_center_ids = data_get($data, "data.expense_center_ids", []);
		if (isset($data["data"]["expense_center_ids"])) {
			unset($data["data"]["expense_center_ids"]);
		}
		$result = parent::storeMethod($id, $data);

		$model = data_get($result, "model");
		$model->expenseCenter()->sync($expense_center_ids);

		return $result;
	}
}
