<?php

namespace App\Services;

use GuzzleHttp\Client;

class RecruitApiService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            "base_uri" => "https://webservice.recruit.co.jp/hotpepper/",
        ]);
    }

    /**
     * 지역 코드를 기반으로 한 식당 검색 메서드
     * - 장르, 대형 지역, 중형 지역, 검색 키워드 선택 가능
     */
    public function searchRestaurantsByLocationCode(
        ?string $genre = null,
        ?string $large_area = null,
        ?string $middle_area = null,
        ?string $keyword = null
    ) {
        $params = [
            "key" => env("HOTPEPPER_KEY"),
            "format" => "json",
        ];

        if ($genre !== null) {
            $params["genre"] = $genre;
        }
        if ($large_area !== null) {
            $params["large_area"] = $large_area;
        }
        if ($middle_area !== null) {
            $params["middle_area"] = $middle_area;
        }
        if ($keyword !== null) {
            $params["keyword"] = $keyword;
        }

        $response = $this->client->get("gourmet/v1/", [
            "query" => $params,
        ]);

        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody(), true)["results"];
        }

        return null;
    }

    /**
     * 가게명으로 검색 메서드
     * - 입력된 가게명을 사용하여 검색 결과 반환
     */
    public function searchRestaurantsByName(string $name)
    {
        $params = [
            "key" => env("HOTPEPPER_KEY"),
            "keyword" => $name,
            "format" => "json",
        ];

        if (empty($name)) {
            return null;
        }

        try {
            $response = $this->client->get("gourmet/v1/", [
                "query" => $params,
            ]);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody(), true)["results"];
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return response()->json(
                [
                    "message" => "Request failed",
                    "error" => $e->getMessage(),
                ],
                400
            );
        }

        return null;
    }

    /**
     * 사용자의 위치를 기반으로 한 주변 식당 검색 메서드
     * - 위도, 경도에 기반하여 사용자 주변의 식당 검색이 가능
     * - 검색 키워드 선택 가능
     */
    public function searchRestaurantsByUserLocation(
        float $latitude,
        float $longitude,
        float $range,
        ?string $keyword = null
    ) {
        $params = [
            "key" => env("HOTPEPPER_KEY"),
            "lat" => $latitude,
            "lng" => $longitude,
            "range" => $range,
            "order" => 4,
            "format" => "json",
        ];

        if ($keyword !== null) {
            $params["keyword"] = $keyword;
        }

        $response = $this->client->get("gourmet/v1/", [
            "query" => $params,
        ]);

        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody(), true)["results"];
        }

        return null;
    }

    /**
     * 일치하는 장르의 인기 있는 가게를 가져오는 메서드
     */
    public function getPopularRestaurantsByGenre(?string $genre = null)
    {
        if ($genre === null) {
            $genreArray = range(1, 17);
            shuffle($genreArray);
            $randomGenre = array_shift($genreArray); // 랜덤한 장르 코드 선택
            $genre = "G" . str_pad($randomGenre, 3, "0", STR_PAD_LEFT);
        }

        $params = [
            "key" => env("HOTPEPPER_KEY"),
            "format" => "json",
            "genre" => $genre,
            "order" => 4, // 인기순 정렬
        ];

        $response = $this->client->get("gourmet/v1/", [
            "query" => $params,
        ]);

        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody(), true)["results"];
        }

        return null;
    }

    /**
     * 가게 아이디로 가게 정보를 가져오는 메서드
     */
    public function getRestaurantById(string $id)
    {
        $params = [
            "key" => env("HOTPEPPER_KEY"),
            "id" => $id,
            "format" => "json",
        ];

        $response = $this->client->get("gourmet/v1/", [
            "query" => $params,
        ]);

        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody(), true)["results"];
        }

        return null;
    }
}
