<?php

use Illuminate\Database\Seeder;
use App\Post;

class postSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = ['football', 'game', 'health', 'phons'];
        $count = 0;
        foreach ($posts as $post) {
            $count++;
            Post::create([
                'title' => $post,
                'body'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis lacinia hendrerit magna, ut fringilla metus varius ac. Donec eu nisi sit amet nisi molestie placerat in at nibh. Vivamus in pulvinar turpis. Sed luctus pulvinar urna vel gravida. Interdum et malesuada fames ac ante ipsum primis in faucibus. Phasellus in tincidunt risus. Interdum et malesuada fames ac ante ipsum primis in faucibus.',
                'user_id' => $count,
            ]);
        } //-- end foreach
    } //-- end run function
} //-- end seeder
