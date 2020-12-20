<?php

use App\Forum;
use App\ForumComment;
use Illuminate\Database\Seeder;

class ForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Forum::class, 50)->create();
        factory(ForumComment::class, 100)->create();
    }
}
