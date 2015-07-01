<?php

namespace App\Tools\Misc;

use Awjudd\FeedReader\Facades\FeedReader;

class Jenkins {

    public static function getFeed($endpoint = 'rssAll', $start = 0, $limit = 4) {
        $feed = FeedReader::read(env("JENKINS_URL") . '/' . $endpoint);
        $feed->enable_order_by_date();
        return $feed->get_items($start, $limit);
    }


}