<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $nbrTags = 6; $nbrCategories = 3; $nbrPosts = 6; $nbrUsers = 5;
        //Create users
        User::withoutEvents(function () {
            // Create 1 admin
            User::factory()->create([
                'role' => 'admin',
            ]);
            // Create 3 users
            User::factory()->count(4)->create();
        });
        //create categories
        DB::table('categories')->insert([
            [
                'title' => 'Category 1',
                'slug' => 'category-1'
            ],
            [
                'title' => 'Category 2',
                'slug' => 'category-2'
            ],
            [
                'title' => 'Category 3',
                'slug' => 'category-3'
            ],
        ]);
        //create tags
        DB::table('tags')->insert([
            ['tag' => 'Tag1', 'slug' => 'tag1'],
            ['tag' => 'Tag2', 'slug' => 'tag2'],
            ['tag' => 'Tag3', 'slug' => 'tag3'],
            ['tag' => 'Tag4', 'slug' => 'tag4'],
            ['tag' => 'Tag5', 'slug' => 'tag5'],
            ['tag' => 'Tag6', 'slug' => 'tag6']
        ]);
        //create posts
        Post::withoutEvents(function () {
            foreach (range(1, 6) as $i) {
                Post::factory()->create([
                    'title' => 'Post ' . $i,
                    'slug' => 'post-' . $i,
                    'seo_title' => 'Post ' . $i,
                    'user_id' => 1,
                    'image' => 'img0' . $i . '.jpg',
                ]);
            }
        });
        // Tags attachment
        $posts = Post::all();
        foreach ($posts as $post) {
            if ($post->id === 6) {
                $numbers=[1,2,5,6];
                $n = 4;
            } else {
                $numbers = range (1, $nbrTags);
                shuffle ($numbers);
                $n = rand (2, 4);
            }
            for($i = 0; $i < $n; ++$i) {
                $post->tags()->attach($numbers[$i]);
            }
        }
        // Set categories
        foreach ($posts as $post) {
            if ($post->id === 6) {
                DB::table ('category_post')->insert ([
                    'category_id' => 1,
                    'post_id' => 6,
                ]);
            } else {
                $numbers = range (1, $nbrCategories);
                shuffle ($numbers);
                $n = rand (1, 2);
                for ($i = 0; $i < $n; ++$i) {
                    DB::table ('category_post')->insert ([
                        'category_id' => $numbers[$i],
                        'post_id' => $post->id,
                    ]);
                }
            }
        }
        //create comments
        foreach (range(1, $nbrPosts - 1) as $i) {
            Comment::factory()->create([
                'post_id' => $i,
                'user_id' => rand(1, $nbrUsers),
            ]);
        }
        $faker = \Faker\Factory::create();
        Comment::create([
            'post_id' => 2,
            'user_id' => 3,
            'body' => $faker->paragraph($nbSentences = 4, $variableNbSentences = true),

            'children' => [
                [
                    'post_id' => 2,
                    'user_id' => 4,
                    'body' => $faker->paragraph($nbSentences = 4, $variableNbSentences = true),

                    'children' => [
                        [
                            'post_id' => 2,
                            'user_id' => 2,
                            'body' => $faker->paragraph($nbSentences = 4, $variableNbSentences = true),
                        ],
                    ],
                ],
            ],
        ]);
        Comment::create([
            'post_id' => 2,
            'user_id' => 5,
            'body' => $faker->paragraph($nbSentences = 4, $variableNbSentences = true),

            'children' => [
                [
                    'post_id' => 2,
                    'user_id' => 3,
                    'body' => $faker->paragraph($nbSentences = 4, $variableNbSentences = true),
                ],
                [
                    'post_id' => 2,
                    'user_id' => 6,
                    'body' => $faker->paragraph($nbSentences = 4, $variableNbSentences = true),

                    'children' => [
                        [
                            'post_id' => 2,
                            'user_id' => 3,
                            'body' => $faker->paragraph($nbSentences = 4, $variableNbSentences = true),

                            'children' => [
                                [
                                    'post_id' => 2,
                                    'user_id' => 6,
                                    'body' => $faker->paragraph($nbSentences = 4, $variableNbSentences = true),
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
