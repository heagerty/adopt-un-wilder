<?php


namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;



class Codewars
{


    public function getKata(string $codewarsId) : ?array
    {

        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://www.codewars.com/api/v1/users/'.$codewarsId.'/code-challenges/completed?page=0');


        $content = $response->toArray();
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

        $content = $response->toArray();

        $honor = $content['honor'];

        return $honor;
    }



    public function getLanguages(string $codewarsId) : ?Array
    {

        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://www.codewars.com/api/v1/users/'.$codewarsId);

        $content = $response->toArray();

        $ranks = $content['ranks'];
        $languages = $ranks['languages'];

        return $languages;
    }



}