<?php


namespace App\Service;


class Slugify
{


    public function generate(string $input) : string
    {

        $slug = preg_replace("/\p{P}/", "", $input);
        $slug = trim($slug);
        $slug = str_replace(' ', '-', $slug);
        while (strpos($slug, '--') !== false) {
            $slug = str_replace('--', '-', $slug);;
        }
        $slug = iconv('UTF-8','ASCII//TRANSLIT//IGNORE',$slug);
        $slug = strtolower($slug);



        return $slug;
    }


}