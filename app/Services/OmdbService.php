<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OmdbService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('OMDB_API_KEY');
        $this->baseUrl = 'http://www.omdbapi.com/';
    }

    public function searchMovies($title, $page = 1)
    {
        $response = Http::get($this->baseUrl, [
            'apikey' => $this->apiKey,
            's' => $title,
            'page' => $page,
        ]);

        return $response->successful() && isset($response['Search'])
            ? $response->json()
            : ['Search' => [], 'totalResults' => 0, 'Response' => 'False', 'Error' => $response['Error'] ?? 'No results found'];
    }

    public function getMovieDetails($id)
    {
        $response = Http::get($this->baseUrl, [
            'apikey' => $this->apiKey,
            'i' => $id,
            'plot' => 'full',
        ]);

        return $response->successful() && $response['Response'] === 'True'
            ? $response->json()
            : null;
    }
}
