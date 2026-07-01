<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Post;
use Illuminate\Support\Facades\Http;


class SyncPosts extends Command
{
 
    protected $signature = 'posts:sync';
    protected $description = 'Sync posts from external API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get(env('API_URL'));

        if (!$response->ok()) {
            $this->error('API error');
            return;
        }
 
        $apiPosts = $response->json();
       
        foreach ($apiPosts as $apiPost) {

            Post::updateOrCreate(
                ['api_id' => $apiPost['post_id']],
                [
                    'title'   => $apiPost['title'],
                    'content' => $apiPost['content'],
                    'image'   => $apiPost['image'],
                ]
            );
        }

        $this->info('Posts synced successfully');
    }
}
