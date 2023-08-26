<?php

namespace App\Services\Crawler;

class CrawlerService implements CrawlerServiceInterface
{

    /**
     * @param string $url
     * 
     * verify string is a url
     * 
     * @return bool
     */
    public function isValidUrl(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }


    /**
     * @param string $url
     * 
     * crawl and extract internal hyperlinks
     * 
     * @return array|NULL
     */
    public function crawlHomePage(string $url): ?array
    {
        $client = new \GuzzleHttp\Client;

        $res = $client->request('GET', $url);

        // Use regular expression to extract internal links
        preg_match_all('/<a[^>]+href="([^">]+)"[^>]*>/i', $res->getBody(), $matches);

        foreach ($matches[1] as $link) {
            //extract internal links
            if (strpos($link, $url) == 0) {
                //return full link
                $internalLinks[] = $url . $link;
            }
        }

        return $internalLinks;
    }
}
