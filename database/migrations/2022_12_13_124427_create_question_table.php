<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->text("urlToken");
            $table->json("questions");
            $table->text("password")->nullable(); // if password is set it will show up in the url ex: "https://gyp.nl/form/formTokenId?token='blabladitismijnpassword'"
            $table->integer("maxAnswers")->nullable(); // max answers that can be submitted
            $table->char("timeOpened", 30)->nullable(); // time the question is opened -- cant upload any answers after that
            $table->char("timeClosed", 30)->nullable(); // time the question is closed -- cant upload any answers after that
            // timeOpened/timeClosed is a char so that way we can store "Y-m-d H:i:sO"/"YYYY-MM-DD HH:II:SS+HHMM"/"2023-02-08 11:11:00+0100"
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
        Schema::dropIfExists('question');
    }
}
