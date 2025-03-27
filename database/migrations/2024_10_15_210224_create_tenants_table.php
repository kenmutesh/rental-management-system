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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('id_number')->unique();
            $table->string('kra_pin')->nullable();
            $table->string('employer_name')->nullable();
            $table->string('job_title')->nullable();
            $table->decimal('monthly_income', 10, 2)->nullable();
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('unit_id');
            $table->date('lease_start_date');
            $table->decimal('rent_amount', 10, 2);
            $table->decimal('security_deposit', 10, 2);
            $table->decimal('advance_rent', 10, 2);
            $table->string('payment_method');
            $table->boolean('apply_discount')->default(false);
            $table->string('discount_type')->nullable();
            $table->decimal('discount_value', 10, 2)->nullable();
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_phone');
            $table->text('notes')->nullable();
            $table->string('account_number')->nullable();
            $table->string('address')->nullable();
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('city')->nullable();
            $table->string('county')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('emergency_contact_relationship')->nullable();
            $table->timestamps();

            $table->foreign('property_id')->references('id')->on('properties');
            $table->foreign('unit_id')->references('id')->on('units');
        });

        // Employment details table
        Schema::create('employment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->string('employer_name');
            $table->string('job_title');
            $table->decimal('monthly_income', 10, 2);
            $table->string('employment_type')->nullable(); // permanent, contract, self-employed
            $table->date('employment_start_date')->nullable();
            $table->text('employer_address')->nullable();
            $table->string('employer_phone')->nullable();
            $table->string('employer_email')->nullable();
            $table->timestamps();
        });

        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->morphs('documentable'); // For tenant, lease, or property documents
            $table->string('type'); // id_copy, kra_pin, employment_letter, payslip, etc.
            $table->string('name');
            $table->string('path');
            $table->string('mime_type')->nullable();
            $table->integer('size')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
        Schema::dropIfExists('employment_details');
        Schema::dropIfExists('tenants');
    }
};
