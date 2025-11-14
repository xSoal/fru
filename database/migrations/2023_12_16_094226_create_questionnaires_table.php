<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questionnaires', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sex')->default(0);
            $table->integer('post_id')->default(0);
            $table->string('project')->nullable();
            $table->text('pasport')->nullable();
            $table->string('inn')->nullable();
            $table->text('zagran_pasport')->nullable();
            $table->string('birthday')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('education')->nullable();
            $table->string('address')->nullable();
            $table->string('residential_addresses')->nullable();
            $table->string('family_status')->nullable();
            $table->text('children')->nullable();
            $table->text('preferential_documents')->nullable();
            $table->integer('reservist')->default(0);
            $table->string('iban')->nullable();
            $table->integer('employment')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questionnaires');
    }
};
