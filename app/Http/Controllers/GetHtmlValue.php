<?php

namespace App\Http\Controllers;

use Symfony\Component\DomCrawler\Crawler;

class GetHtmlValue
{
    public function test()
    {
        $html = "123.html";
        $crawler = new Crawler();
        $crawler->addHtmlContent($html);
//        $aa = $crawler->filter('.content__list')->children();
        $aa = $crawler->filterXPath('//div')->nodeName();
        print_r($aa);exit();

        $document = new \DOMDocument();
        $document->loadHTML($html);
        $a = $document->getElementById('search')->lastChild;
        print_r($a);
        exit();
    }
}