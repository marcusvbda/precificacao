<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $this->createMarketplaces();
        $this->createExpenses();
        $this->createExpenseCenters();
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

        Schema::create('expense_centers_expenses', function (Blueprint $table) {
            $table->unsignedBigInteger('expenses_id');
            $table->foreign('expenses_id')
                ->references('id')
                ->on('expenses');
            $table->unsignedBigInteger('expense_center_id');
            $table->foreign('expense_center_id')
                ->references('id')
                ->on('expense_centers');
            $table->primary(['expenses_id', 'expense_center_id']);
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
            $table->integer("value");
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
            $table->unsignedBigInteger('tenant_id');
            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants');
            $table->primary(['tenant_id', 'expense_center_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('expense_centers_expenses');
        Schema::dropIfExists('expense_centers');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('product_marketplaces');
        Schema::dropIfExists('product_expense_centers');
        Schema::dropIfExists('marketplaces');
        Schema::dropIfExists('products');
    }
};
