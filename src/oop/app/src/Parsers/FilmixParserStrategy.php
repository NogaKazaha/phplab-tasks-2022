<?php 

namespace src\oop\app\src\Parsers;

use src\oop\app\src\Models\Movie;

class FilmixParserStrategy implements ParserInterface {
    public function parseContent(string $siteContent)
    {
        $dom = new \DOMDocument();
        $dom->loadHTML($siteContent, LIBXML_NOWARNING | LIBXML_NOERROR);

        $title = $dom->getElementsByTagName('h1')->item(0)->nodeValue;
        
        $xpath = new \DOMXPath($dom);
        $poster = $xpath->query('//a[@class="fancybox"]/@href')->item(0)->nodeValue;
        $description = $xpath->query('//div[@class="full-story"]')->item(0)->nodeValue;

        $movie = new Movie();
        $movie->setTitle($title);
        $movie->setPoster($poster);
        $movie->setDescription($description);
        return $movie;
    }
}