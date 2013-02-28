<?php

use Illuminate\Database\Migrations\Migration;

class MenuCreateMenusTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'menus',
            function ($table) {
                $table->increments('id');
                $table->string('menu_name');
                $table->integer('item_order')->nullable();
                $table->string('item_type')->default('link'); // might need to be changed on l4 release
                $table->text('type_attrs')->nullable(); // json formatted
                $table->text('html_attrs')->nullable(); // json formatted
                $table->integer('user_id')->unsigned()->nullable(); // who created the menu item
                $table->text('notes')->nullable(); // who created the menu item
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('menus');
    }

}
