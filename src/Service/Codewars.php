<?php


namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;



class Codewars
{


    public function getKata(string $codewarsId) : ?array
    {

        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://www.codewars.com/api/v1/users/'.$codewarsId.'/code-challenges/completed?page=0');

        //$statusCode = $response->getStatusCode();
        // $statusCode = 200
        //$contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        //$content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        $arrayOfKata = $content['data'];

        $kata = [];

        foreach ($arrayOfKata as $kataInArray) {
            $kata[] = $kataInArray['name'];
        }


        return $kata;
    }

    public function getHonor(string $codewarsId) : ?int
    {

        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://www.codewars.com/api/v1/users/'.$codewarsId);

        //$statusCode = $response->getStatusCode();
        // $statusCode = 200
        //$contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        //$content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        $honor = $content['honor'];

        return $honor;
    }


    public function getLanguages(string $codewarsId) : ?Array
    {

        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://www.codewars.com/api/v1/users/'.$codewarsId);

        //$statusCode = $response->getStatusCode();
        // $statusCode = 200
        //$contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        //$content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        $ranks = $content['ranks'];
        $languages = $ranks['languages'];

        return $languages;
    }


}