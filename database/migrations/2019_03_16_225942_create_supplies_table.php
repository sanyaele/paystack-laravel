<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference');
            $table->string('supplier_id');
            $table->string('item');
            $table->enum('status', ['initiated','supplied','paid','cancelled','returned']);
            $table->enum('confirm_pay',['No','Yes']);
            $table->text('quantity_desc');
            $table->integer('amount');
            $table->enum('supply_type',['prepaid','postpaid']);
            $table->enum('paid',['yes','no']);;
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
        Schema::dropIfExists('supplies');
    }
}
