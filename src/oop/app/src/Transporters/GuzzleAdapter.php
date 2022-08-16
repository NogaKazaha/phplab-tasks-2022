<?php 

namespace src\oop\app\src\Transporters;

class GuzzleAdapter implements TransportInterface
{
    public function getContent(string $url): string
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        return $response->getBody()->getContents();
    }
}