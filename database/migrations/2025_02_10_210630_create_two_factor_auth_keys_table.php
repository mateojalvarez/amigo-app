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
        Schema::create('two_factor_auth_keys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('secret', 64)->unique();
            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();
        });

        Schema::table('two_factor_auth_keys', function (Blueprint $table) {
            $table->foreign('user_id', 'two_factor_auth_keys_users')
                ->references('id')
                ->on('users')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('two_factor_auth_keys', function (Blueprint $table) {
            $table->dropForeign('two_factor_auth_keys_users');
        });

        Schema::dropIfExists('two_factor_auth_keys');
    }
};
