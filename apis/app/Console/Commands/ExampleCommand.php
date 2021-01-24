<?php
namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;

class ExampleCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "delete:posts";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Delete all posts";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $posts = Post::getPosts();
           
            if (!$posts) {
            $this->info("No posts exist");
                return;
            }
            foreach ($posts as $post) {
                $post->delete();
            }
            $this->info("All posts have been deleted");
        } catch (Exception $e) {
            $this->error("An error occurred");
        }
    }
}