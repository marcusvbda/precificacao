<?php

namespace App\Http\Resources;

use marcusvbda\vstack\Resource;
use App\Http\Models\Product;

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

	// public function table()
	// {
	// 	$columns = [];
	// 	$columns["code"] = ["label" => "Código", "sortable_index" => "id"];
	// 	$columns["name"] = ["label" => "Nome"];
	// 	$columns["f_new_badge"] = ["label" => "Mostrar cartão de 'novo'", "sortable_index" => "mew_badge"];
	// 	$columns["f_created_at_badge"] = ["label" => "Data", "sortable_index" => "created_at"];
	// 	return $columns;
	// }

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


	// public function fields()
	// {
	// 	$fields[] = new Text([
	// 		"label" => "Nome",
	// 		"field" => "name",
	// 		"description" => "Para identificação do módulo",
	// 		"required" => true,
	// 		"rules" => "max:255"
	// 	]);
	// 	$fields[] = new Text([
	// 		"label" => "Slug",
	// 		"field" => "slug",
	// 		"description" => "Para identificação do módulo",
	// 		"required" => true,
	// 		"rules" => "max:255"
	// 	]);
	// 	$cards[] = new Card("Informações Básicas", $fields);

	// 	$fields = [];
	// 	$fields[] = new Check([
	// 		"label" => "habilitar cartão de 'Novo'",
	// 		"field" => "new_badge",
	// 		"default" => true,
	// 		"required" => true
	// 	]);
	// 	$cards[] = new Card("Configurações", $fields);

	// 	return $cards;
	// }
}
