<?php

namespace App\Http\Resources;

use App\Http\Models\Expense;
use marcusvbda\vstack\Resource;
use App\Http\Models\ExpenseCenter;
use marcusvbda\vstack\Fields\BelongsTo;
use marcusvbda\vstack\Fields\Card;
use marcusvbda\vstack\Fields\CustomComponent;
use marcusvbda\vstack\Fields\ResourceTree;
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
		if (request()->page_type == "create") {
			$fields[] = $this->getFieldAlert(["description" => "Para ter acesso a edição de despesas, finalize o cadastro deste centro de custo."]);
		} else {
			$fields[] = new ResourceTree([
				'parent_resource' => 'centros-de-custo',
				'resource' => 'despesas',
				'relation' => 'expenses',
				'foreign_key' => 'expense_center_id',
				'template' => '<expense-title-label></expense-title-label>'
			]);
		}
		$cards[] = new Card("Configurações", $fields);

		return $cards;
	}

	private function getFieldAlert($options)
	{
		$title = data_get($options, "title", "Atenção !!");
		$type = data_get($options, "type", "warning");
		$description = data_get($options, "description");
		$alert = '<el-alert
                        type="' . $type . '"
                        show-icon
                        :closable="false"
                    >
                        <div>
                            <b>' . $title . '</b>
                        </div>
                        <div>' . $description . '</div>
                    </el-alert>';
		return new CustomComponent(str_replace("{type}", $type, $alert));
	}

	public function secondCrudBtn()
	{
		return [
			"size" => "small",
			"field" => "save",
			"type" => "success",
			"content" => "<div class='d-flex flex-row'>
							<i class='el-icon-success mr-2'></i>
							Salvar
						</div>"
		];
	}

	public function firstCrudBtn()
	{
		return false;
	}
}
