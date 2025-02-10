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
        Schema::create('groups_expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('group_id');
            $table->unsignedBigInteger('expense_id');
            $table->foreign('group_id')->references('id')->on('groups')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            $table->foreign('expense_id')->references('id')->on('expenses')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('groups_expenses', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropForeign(['expense_id']);
        });

        Schema::dropIfExists('group_expense');
    }
};
