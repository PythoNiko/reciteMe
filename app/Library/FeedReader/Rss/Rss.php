<?php

namespace App\Library\FeedReader\Rss;

use App\Library\FeedReader\FeedInterface;
use SimpleXMLElement;

class Rss implements FeedInterface
{
    private SimpleXMLElement $content;

    public function __construct(SimpleXMLElement $content)
    {
        $this->content = $content;
    }

    public function getContent(): SimpleXMLElement
    {
        return $this->content;
    }

    public function getContentAsArray(): array
    {
        // Transform XML object to Array
        $items = json_decode(json_encode($this->content), true);

        $generalFormat = [];
        foreach ($items['channel']['item'] as $item) {
            $generalFormat[] = [
                'title' => $item['title'],
                'link' => $item['link'],
                'guid' => $item['guid'],
                'description' => $item['description'],
                'pub_date' => $item['pubDate'],
            ];
        }

        return $generalFormat;
    }
}
