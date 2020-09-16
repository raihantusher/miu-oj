<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->longText('body');

            $table->mediumText('answer_code');
            $table->mediumText('test_input');
            $table->mediumText('test_output');
            $table->foreignId("user_id");
            $table->foreignId("set_id");

            $table->timestamps();

            
            $table->foreign('set_id')
                 ->references('id')->on('sets')
              ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
