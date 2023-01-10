<?php

namespace App\Library\FeedReader;

use SimpleXMLElement;

interface FeedInterface
{
    // loosely-coupled
    public function __construct(SimpleXMLElement $content);

    public function getContentAsArray(): array;
}
