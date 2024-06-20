<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Insert predefined projects
        DB::table('projects')->insert([
            ['name' => 'AMS Web'],
            ['name' => 'AMS Wcf'],
            ['name' => 'Dashboard'],
            ['name' => 'IVR Service'],
            ['name' => 'Scheduler Web'],
            ['name' => 'Scheduler Wcf'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}

