<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recurring_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 50)->unique();
            $table->unsignedTinyInteger('recurring_type_id');
            $table->unsignedTinyInteger('intervals');
            $table->unsignedInteger('total_amount');
            $table->unsignedSmallInteger('currency_id');
            $table->unsignedTinyInteger('expense_category_id')->nullable();
            $table->string('description', 50);
            $table->dateTime('start_date');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes();
        });

        Schema::table('recurring_expenses', function (Blueprint $table) {
            $table->foreign('recurring_type_id')->references('id')->on('recurring_types')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('currency_id')->references('id')->on('currencies')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('expense_category_id')->references('id')->on('expense_categories')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recurring_expenses', function (Blueprint $table) {
            $table->dropForeign(['recurring_type_id']);
            $table->dropForeign(['currency_id']);
            $table->dropForeign(['expense_category_id']);
        });

        Schema::dropIfExists('recurring_expenses');
    }
};
