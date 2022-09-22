<?php

namespace App\Http\Resources;

use marcusvbda\vstack\Resource;
use App\Http\Models\Marketplace;
use marcusvbda\vstack\Fields\Card;
use marcusvbda\vstack\Fields\Text;

class Marketplaces extends Resource
{
	public $model = Marketplace::class;

	public function globallySearchable()
	{
		return false;
	}

	public function label()
	{
		return "Marketplaces";
	}

	public function singularLabel()
	{
		return "Marketplace";
	}

	public function icon()
	{
		return "el-icon-collection-tag";
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
		return hasPermissionTo("create-marketplaces");
	}

	public function canUpdate()
	{
		return hasPermissionTo("edit-marketplaces");
	}

	public function canDelete()
	{
		return hasPermissionTo("destroy-marketplaces");
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
		return hasPermissionTo("viewlist-marketplaces");
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
			"description" => "Para identificação do marketplace",
			"rules" => ["required", "max:255"]
		]);

		$cards[] = new Card("Informações Básicas", $fields);

		return $cards;
	}
}
