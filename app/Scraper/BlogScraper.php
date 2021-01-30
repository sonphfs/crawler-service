<?php

namespace App\Scraper;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Blog;

class BlogScraper
{

    public function scrape()
    {
        Log::info("===============START=============");
        $categories = $this->getCategories();
        $tenMinutesAgo = strtotime(\Carbon\Carbon::now()->subMinute(10));

        foreach($categories as $categoryId => $category) {

            $client = new Client();
            $crawler = $client->request('GET', $category["url"]);
    
            $crawler->filter('div.timeline div.story')->each(
                function (Crawler $node) use ($category, $categoryId, $tenMinutesAgo) {
                    if($this->hasNode($node->filter('h4.story__heading a'))) {
                        $title = $node->filter('h4.story__heading a')->text();
                        $link = $node->filter('h4.story__heading a')->attr('href');
                        $time = 0;
                        if($this->hasNode($node->filter('div.story__meta time'))) {
                            $dateTime = $node->filter('div.story__meta time')->attr("datetime");
                            $time = strtotime($dateTime);
                        }
                        if($time >= $tenMinutesAgo) {
                            $blog = $this->findByLink($link);
                            if(!isset($blog)) {
                                $blog = new Blog;
                                $blog->title = $title;
                                $blog->link = "https://baomoi.com".$link;
                                $blog->tag = $category["tag"];
                                $blog->category_id = $categoryId;
                                $blog->save();
                                Log::info("Crawl new blog: ", json_encode($blog));
                                var_dump("Store : ".$blog->id);
                            } else {
                                var_dump("Link is already exists!");
                            }
                        } else {
                            var_dump("Before 10 minutes!");
                        }
                    }
                    
                }
            );
        }
        Log::info("===============END=============");
    }

    public function hasNode($node)
    {
        return $node->count() > 0;
    }

    public function findByLink($link)
    {
        return Blog::where('link', 'like', "%$link")->first();
    }

    public function getLinks()
    {
        $links = Blog::all()->pluck('link');
        $hashLinks = [];
        foreach($links as $link) {
            $hashLinks[$link] = 1;
        }
        return $hashLinks;
    }

    public function getCategories()
    {
        return  [
            [
                "url" => "https://baomoi.com/bao-ha-tinh-ha-tinh/p/281.epi",
                "tag" => "https://baohatinh.vn/",
                "sourceUrl" => "https://baohatinh.vn/",
            ],
            [
                "url" => "https://baomoi.com/bao-ha-tinh-ha-tinh/p/281.epi",
                "tag" => "https://doanhnghiepvn.vn/",
                "sourceUrl" => "https://doanhnghiepvn.vn/"
            ],
            [
                "url" => "https://baomoi.com/doanh-nghiep-viet-nam-doanh-nghiep/p/304.epi",
                "tag" => "https://vietnamnet.vn/",
                "sourceUrl" => "https://vietnamnet.vn/"
            ],
            [
                "url" => "https://baomoi.com/bao-kinh-te-do-thi-kinh-te-do-thi/p/11.epi",
                "tag" => "http://kinhtedothi.vn/",
                "sourceUrl" => "http://kinhtedothi.vn/"
            ],
            [
                "url" => "https://baomoi.com/bao-quan-doi-nhan-dan-qdnd/p/16.epi",
                "tag" => "https://www.qdnd.vn/",
                "sourceUrl" => "https://www.qdnd.vn/"
            ],
            [
                "url" => "https://baomoi.com/zing-tri-thuc-truc-tuyen-zing/p/119.epi",
                "tag" => "https://zingnews.vn/",
                "sourceUrl" => "https://zingnews.vn/"
            ],
            [
                "url" => "https://baomoi.com/chuyen-trang-dien-dan-phap-luat-phap-luat-net-phap-luat-net/p/343.epi",
                "tag" => "https://phapluatnet.nguoiduatin.vn/",
                "sourceUrl" => "https://phapluatnet.nguoiduatin.vn/"
            ],
            [
                "url" => "https://baomoi.com/bao-cong-an-da-nang-cadn/p/173.epi",
                "tag" => "http://cadn.com.vn/",
                "sourceUrl" => "http://cadn.com.vn/"
            ],
            [
                "url" => "https://baomoi.com/bao-tin-tuc-ttxvn-tin-tuc-ttxvn/p/294.epi",
                "tag" => "https://baotintuc.vn/",
                "sourceUrl" => "https://baotintuc.vn/"
            ],
            [
                "url" => "https://baomoi.com/bao-van-hoa-van-hoa/p/125.epi",
                "tag" => "http://baovanhoa.vn/",
                "sourceUrl" => "http://baovanhoa.vn/"
            ],
            [
                "url" => "https://baomoi.com/bao-vov-vov/p/65.epi",
                "tag" => "https://vov.vn/",
                "sourceUrl" => "https://vov.vn/"
            ],
            [
                "url" => "https://baomoi.com/bao-nguoi-lao-dong-nguoi-lao-dong/p/15.epi",
                "tag" => "https://nld.com.vn/",
                "sourceUrl" => "https://nld.com.vn/"
            ],
            [
                "url" => "https://baomoi.com/bao-ha-noi-moi-ha-noi-moi/p/8.ep",
                "tag" => "http://hanoimoi.com.vn/",
                "sourceUrl" => "http://hanoimoi.com.vn/"
            ],
            [
                "url" => "https://baomoi.com/bao-tien-phong-tien-phong/p/20.epi",
                "tag" => "https://www.tienphong.vn/",
                "sourceUrl" => ""
            ],
            [
                "url" => "https://baomoi.com/bao-vtc-news-vtc-news/p/83.epi",
                "tag" => "https://vtc.vn/",
                "sourceUrl" => "https://vtc.vn/"
            ],
            [
                "url" => "https://baomoi.com/bao-vietnamplus-vietnamplus/p/293.epi",
                "tag" => "https://www.vietnamplus.vn/",
                "sourceUrl" => "https://www.vietnamplus.vn/"
            ],
            [
                "url" => "https://baomoi.com/bao-chinh-phu-chinh-phu/p/146.epi",
                "tag" => "http://baochinhphu.vn/",
                "sourceUrl" => "http://baochinhphu.vn/"
            ],
            
        ];
    }
}