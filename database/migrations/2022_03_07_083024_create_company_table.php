<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Company;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 100);
            $table->integer('logo_company_id');
            $table->tinyInteger('is_active');
        });

        Company::insert([
            'company_name' => 'Zeberced Ltd',
            'logo_company_id' => 1,
            'is_active' => 1,
        ]);

        Company::insert([
            'company_name' => 'Katanpe',
            'logo_company_id' => 2,
            'is_active' => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company');
    }
}
