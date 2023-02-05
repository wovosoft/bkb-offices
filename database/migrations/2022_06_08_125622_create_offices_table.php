<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Wovosoft\BkbOffices\Enums\ResidentAreas;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(config("bkb-offices.table_prefix") . 'offices', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("bn_name")->nullable();
            $table->string("code")
                ->unique()
                ->index();

            $table->string("hrms_code")->nullable();
            $table->string("city")->nullable();
            $table->string("phone")->nullable();
            $table->string("email")->nullable();
            $table->string("routing_no")->nullable();


            $table->string("address")->nullable();
            $table->unsignedInteger("recommended_manpower")->nullable();
            $table->text("description")->nullable();

            /**
             * Pointing parent to same table. Everything will be tree based
             * aliasing: office_id => parent_id
             */
            $table->foreignId("parent_id")
                ->nullable()
                ->references("id")
                ->on(config("bkb-offices.table_prefix") . 'offices')
                ->onUpdate("cascade")
                ->onDelete("set null");

            $table->string("type")->nullable();
            $table->enum('resident_area', ResidentAreas::values())->nullable();
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
        Schema::dropIfExists(config("bkb-offices.table_prefix") . 'offices');
    }
};
