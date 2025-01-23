<?php
namespace App\Services;

use GuzzleHttp\Client;

class GoogleBooksService
{
    protected $client;

     public function __construct()
{
    $this->client = new Client();
}

public function searchBooks($query)
{
    $response = $this->client->get('https://www.googleapis.com/books/v1/volumes', [
        'query' => [
            'q' => $query,
            'key' => env('GOOGLE_API_KEY')
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}

