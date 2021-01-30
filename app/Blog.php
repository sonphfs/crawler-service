<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class Blog extends Model
{
    public function scrape()
    {
        $url = 'https://baomoi.com/tin-moi.epi';

        $client = new Client();

        $crawler = $client->request('GET', $url);

        $crawler->filter('div.timeline div.story')->each(
            function (Crawler $node) {
                $title = $node->filter('h4.story__heading a')->text();

                $link = "";

                $product = new Blog;
                $product->name = $name;
                $product->price = $price;
                $product->rate = $rate;
                $product->save();
            }
        );
    }
}
