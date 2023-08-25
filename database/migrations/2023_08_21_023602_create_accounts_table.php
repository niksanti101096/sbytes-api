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
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('AccountId');
            $table->string('FirstName');
            $table->string('LastName');
            $table->string('Address');
            $table->integer('ContactNumber');
            $table->date('BirthDate');
            $table->string('Gender');
            $table->string('Email')->unique();
            $table->string('Password');
            $table->string('AccressType');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
