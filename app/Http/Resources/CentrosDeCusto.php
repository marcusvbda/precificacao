<?php

namespace App\Http\Resources;

use App\Http\Models\Expense;
use marcusvbda\vstack\Resource;
use App\Http\Models\ExpenseCenter;
use marcusvbda\vstack\Fields\BelongsTo;
use marcusvbda\vstack\Fields\Card;
use marcusvbda\vstack\Fields\CustomComponent;
use marcusvbda\vstack\Fields\Text;

class CentrosDeCusto extends Resource
{
	public $model = ExpenseCenter::class;

	public function globallySearchable()
	{
		return false;
	}

	public function label()
	{
		return "Centro de Custos";
	}

	public function singularLabel()
	{
		return "Centro de Custo";
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
			"description" => "Para identificação do centro de custo",
			"required" => true,
			"rules" => "max:255"
		]);
		$cards[] = new Card("Informações Básicas", $fields);

		$fields = [];
		$fields[] = new BelongsTo([
			'label' => 'Despesas',
			'description' => 'Despesas que deseja relacionar a este centro de custo',
			'field' => 'expense_ids',
			'multiple' => true,
			'model' => Expense::class
		]);

		$fields[] = new CustomComponent("<expense-preview :form='form'></expense-preview>");
		$cards[] = new Card("Configurações", $fields);

		return $cards;
	}

	public function storeMethod($id, $data)
	{
		$expense_ids = data_get($data, "data.expense_ids", []);
		if (isset($data["data"]["expense_ids"])) {
			unset($data["data"]["expense_ids"]);
		}
		$result = parent::storeMethod($id, $data);

		$model = data_get($result, "model");
		$model->expenses()->sync($expense_ids);

		return $result;
	}
}
