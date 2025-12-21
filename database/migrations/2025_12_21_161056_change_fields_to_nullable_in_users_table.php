<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('contact_person', 255)->nullable()->change();
            $table->longText('companies')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->whereNull('contact_person')->update(['contact_person' => '']);
        DB::table('users')->whereNull('companies')->update(['companies' => '']);

        Schema::table('users', function (Blueprint $table) {
            $table->string('contact_person', 255)->nullable(false)->change();
            $table->longText('companies')->nullable(false)->change();
        });
    }
};
