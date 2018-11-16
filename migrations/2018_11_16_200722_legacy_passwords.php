<?php
/**
 * Create database support for legacy passwords
 */
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class LegacyPasswords
 */
class LegacyPasswords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_legacy_passwords', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->json('passwordData');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_legacy_passwords');
    }
}
