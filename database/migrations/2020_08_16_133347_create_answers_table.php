<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->longText('answer_body');
            
            $table->enum("result",['pending','wrong','right']);
            $table->enum("judge_by",['automatic','manual']);
            $table->foreignId("user_id");
            $table->foreignId("set_id");
            $table->foreignId("question_id");

            $table->softDeletes(); //softdeletes
            $table->timestamps();

           
            $table->foreign('question_id')
                    ->references('id')->on('questions')
                 ->onDelete('cascade');
            
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
        Schema::table('answers', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('answers');
    }
}
