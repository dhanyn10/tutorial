<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');

            // response dari API
            $table->boolean('status')->default(true);
            $table->string('status_message');

            // informasi kontak
            $table->string('contact_id');
            $table->string('contact_number');
            $table->string('contact_name');

            $table->text('message');

            $table->dateTime('sent_at');
            $table->timestamps();

            $table->index(['contact_name', 'contact_number']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
