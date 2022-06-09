<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("bn_name")->nullable();
            $table->string("code")->nullable();
            $table->string("address")->nullable();
            $table->unsignedInteger("recommended_manpower")->nullable();
            $table->text("description")->nullable();

            /**
             * Pointing parent to same table. Everything will be tree based
             * aliasing: office_id => parent_id
             */
            $table->unsignedBigInteger("parent_id")->nullable();
            $table->unsignedBigInteger("office_type_id")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('offices');
    }
};
