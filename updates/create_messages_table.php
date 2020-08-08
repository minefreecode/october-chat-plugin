<?php namespace Alekseypavlov\Chat\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('text');
            $table->integer('user_id')->unsigned();
            $table->index(['user_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alekseypavlov_chat_messages');
    }
}
