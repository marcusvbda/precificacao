<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $this->createMarketplaces();
        $this->createExpenseCenters();
        $this->createExpenses();
        $this->createProducts();
    }

    private function createExpenseCenters()
    {
        Schema::create('expense_centers', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string("name");
            $table->unsignedBigInteger('tenant_id');
            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    private function createExpenses()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string("name");
            $table->string("type");
            $table->decimal("value");
            $table->unsignedBigInteger('expense_center_id');
            $table->foreign('expense_center_id')
                ->references('id')
                ->on('expense_centers');
            $table->unsignedBigInteger('tenant_id');
            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    private function createMarketplaces()
    {
        Schema::create('marketplaces', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string("name");
            $table->unsignedBigInteger('tenant_id');
            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    private function createProducts()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string("name");
            $table->string("ean");
            $table->decimal("base_price")->default(0);
            $table->string("margin_type");
            $table->decimal("margin")->default(0);
            $table->unsignedBigInteger('tenant_id');
            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_marketplaces', function (Blueprint $table) {
            $table->unsignedBigInteger('marketplace_id');
            $table->foreign('marketplace_id')
                ->references('id')
                ->on('marketplaces');
            $table->unsignedBigInteger('tenant_id');
            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants');
            $table->primary(['marketplace_id', 'tenant_id']);
        });

        Schema::create('product_expense_centers', function (Blueprint $table) {
            $table->unsignedBigInteger('expense_center_id');
            $table->foreign('expense_center_id')
                ->references('id')
                ->on('expense_centers');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
            $table->primary(['product_id', 'expense_center_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_marketplaces');
        Schema::dropIfExists('product_expense_centers');
        Schema::dropIfExists('expense_centers');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('marketplaces');
        Schema::dropIfExists('products');
    }
};
