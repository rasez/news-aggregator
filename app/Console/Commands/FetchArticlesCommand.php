<?php

namespace App\Console\Commands;

use App\Http\Services\ArticleFetcherService;
use Illuminate\Console\Command;

class FetchArticlesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch articles from selected sources and store them in the database.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(ArticleFetcherService $articleFetcher)
    {
        $this->info('Fetching articles...');

        // Implement the logic to fetch articles using the ArticleFetcherService
        $articleFetcher->fetchAndStoreArticles();

        $this->info('Articles fetched and stored successfully.');
    }
}
