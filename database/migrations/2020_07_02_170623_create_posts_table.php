<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->bigInteger("category_id")->unsigned();
            $table->bigInteger("user_id")->unsigned();

            $table->string("title");
            $table->string("slug")->unique();
            $table->string('producer');
            $table->integer('year');
            $table->string('image_name');
            $table->string('trailer');

            $table->text("content_raw");
//            $table->text("content_html");

            $table->boolean("is_published")->default(false);
            $table->timestamp("published_at")->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("category_id")->references("id")->on("categories");
//            $table->index("is_published");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
