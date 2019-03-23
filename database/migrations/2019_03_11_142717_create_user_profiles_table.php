<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('first_name', 50);
            $table->string('middle_name', 50);
            $table->string('last_name', 50);
            $table->string('salutation', 50);
            $table->string('profile_image')->default('');
            $table->string('profile_image_tmb')->default('');
            $table->string('mobile_no', 13)->default('');
            $table->string('tel_no', 16)->default('');
            $table->string('address')->default('');
            $table->timestamps();

            $table->index('user_id', 'user_id_index');
            $table->foreign('user_id', 'user_id_foreign')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_profiles', function(Blueprint $table){
            $table->dropForeign('user_id_foreign');
            $table->dropIndex('user_id_index');
        });
        Schema::dropIfExists('user_profiles');
    }
}
