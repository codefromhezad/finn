<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBudgetEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_channels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('label');
        });

        DB::table('budget_channels')->insert( array('slug' => 'other', 'label' => 'Autre') );
        DB::table('budget_channels')->insert( array('slug' => 'carte-credit', 'label' => 'Carte bleue') );
        DB::table('budget_channels')->insert( array('slug' => 'retrait', 'label' => 'Retrait') );
        DB::table('budget_channels')->insert( array('slug' => 'prelevement', 'label' => 'Prélèvement') );
        DB::table('budget_channels')->insert( array('slug' => 'virement', 'label' => 'Virement') );

        Schema::create('budget_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->boolean('checked');
            $table->text('label');
            $table->decimal('amount', 10, 2);

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('channel_id')->unsigned();
            $table->foreign('channel_id')->references('id')->on('budget_channels');

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
        Schema::drop('budget_entries');
        Schema::drop('budget_channels');
    }
}
