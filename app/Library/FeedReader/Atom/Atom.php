<?php

namespace App\Library\FeedReader\Atom;

use App\Library\FeedReader\FeedInterface;
use SimpleXMLElement;

class Atom implements FeedInterface
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
                'description' => $item['desc'],
                'date' => $item['pub_date'],
                // etc
                // ToDo: with more time would dedicate effort to refining what an atom feed contains and build accordingly
            ];
        }

        return $generalFormat;
    }
}
