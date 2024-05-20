<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('deliveryAddress');
            $table->string('image_path')->nullable();
        });
    }

    public function down()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->string('type')->nullable();
            $table->string('deliveryAddress')->nullable();
            $table->dropColumn('image_path');
        });
    }
}
