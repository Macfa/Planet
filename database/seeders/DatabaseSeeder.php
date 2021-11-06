<?php

namespace Database\Seeders;

use App\Models\Channel;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        factory(App\User::class, 50)->create();
        User::factory()->times(30)
            ->create();
        Channel::factory()->times(10)->create();
        Post::factory()->times(30)->has(Comment::factory()->count(30), 'comments')->create();
//        Comment::factory()->times(20)->create();
        // \App\Models\User::factory(10)->create();
    }
}
