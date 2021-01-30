<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CrawlBlogCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $bot = new \App\Scraper\BlogScraper();
            $bot->scrape();
        } catch(Exception $e) {
            report($e);
        }
    }
}
