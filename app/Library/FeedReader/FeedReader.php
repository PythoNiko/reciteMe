<?php

namespace App\Library\FeedReader;

use App\Library\FeedReader\Atom\Atom;
use App\Library\FeedReader\Rss\Rss;
use Exception;

class FeedReader
{
    /**
     * @param string $url
     * @return Null|FeedInterface
     * @throws Exception
     */
    // Instantiate the relevant class to load the feeds based on the feed type.
    public static function load(string $url): ?FeedInterface
    {
        $data = null;
        try {
            $data = simplexml_load_file($url);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        switch ($data) {
            // RSS
            case isset($data->channel) and !empty($data->channel):
                return new Rss($data);

            // Atom
            case (
                $data &&
                !in_array('http://www.w3.org/2005/Atom', $data->getDocNamespaces(), true)
            ):
                return new Atom($data);

            // Feed type not detected.
            case ($data === false):
            default:
                return null;
        }
    }
}
