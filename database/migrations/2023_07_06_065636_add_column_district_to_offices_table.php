<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Wovosoft\BdGeocode\Models\District;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(config("bkb-offices.table_prefix") . 'offices', function (Blueprint $table) {
            $table->foreignId("district_id")
                ->nullable()
                ->references('id')
                ->on(District::getTableName())
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string("ctr_branch_name")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(config("bkb-offices.table_prefix") . 'offices', function (Blueprint $table) {
            $table->dropColumn("district_id");
            $table->dropColumn("ctr_branch_name");
        });
    }
};
