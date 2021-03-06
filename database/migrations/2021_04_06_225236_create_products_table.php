<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id')->index();
            $table->integer('contact_id')->nullable()->index();
            $table->string('name', 25);
            $table->integer('quantity');
            $table->string('description', 50)->nullable();
            $table->float('unit_cost');
            $table->float('total_cost');
            $table->string('material', 25)->nullable();
            $table->string('unity', 25)->nullable();
            $table->string('color', 25)->nullable();
            $table->string('classification', 50)->nullable();
            $table->string('notes', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
