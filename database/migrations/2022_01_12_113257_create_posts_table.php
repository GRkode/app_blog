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
            $table->string('title'); //le titre
            $table->string('slug')->unique();//titre formaté pour l'url
            $table->string('seo_title')->nullable();//le titre pour le SEO
            $table->text('excerpt');//text qui apparaît en résumé sur la page d’accueil
            $table->text('body');//corps de l'article
            $table->text('meta_description');//la description pour le SEO
            $table->text('meta_keywords');//les mots clés pour le SEO
            $table->boolean('is_active')->default(false);//pour savoir si l’article est publié
            $table->boolean('is_prenium')->default(false);//pour savoir si l’article est prénium
            $table->string('image')->nullable();//pour le nom de l’image réduite pour la page d’accueil
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
        Schema::dropIfExists('posts');
    }
}
