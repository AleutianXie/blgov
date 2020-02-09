<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('enterprise_id');
            $table->unsignedSmallInteger('version')->nullable();
            $table->unsignedSmallInteger('status');
            $table->string('comment');
            $table->string('docs', 2048);
            $table->timestamp('report_at');
            $table->timestamps();
        });

        Schema::create('report_revision', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('report_id');
            $table->unsignedSmallInteger('version');
            $table->unsignedSmallInteger('status');
            $table->string('comment');
            $table->string('docs', 2048);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report');
        Schema::dropIfExists('report_revision');
    }
}
