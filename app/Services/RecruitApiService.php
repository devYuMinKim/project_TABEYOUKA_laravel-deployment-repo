<?php

namespace App\Services;

use GuzzleHttp\Client;

class RecruitApiService
{
  protected $client;

  public function __construct()
  {
    $this->client = new Client([
      'base_uri' => 'https://webservice.recruit.co.jp/hotpepper/'
    ]);
  }

  /**
   * 주변 식당 검색 메서드 (장르, 대형 지역, 중형 지역 선택 가능)
   */
  public function searchRestaurantsByLocationCode(?string $genre = null, ?string $large_area = null, ?string $middle_area = null)
  {
    $params = [
      'key' => env('APP_KEY'),
      'format' => 'json',
    ];

    if ($genre !== null) {
      $params['genre'] = $genre;
    }

    if ($large_area !== null) {
      $params['large_area'] = $large_area;
    }

    if ($middle_area !== null) {
      $params['middle_area'] = $middle_area;
    }

    $response = $this->client->get('gourmet/v1/', [
      'query' => $params
    ]);

    if ($response->getStatusCode() === 200) {
      return json_decode($response->getBody(), true)['results'];
    }

    return null;
  }

  /**
   * 가게명으로 검색 메서드
   */
  public function searchRestaurantsByName(string $name)
  {
      $params = [
          'key' => env('APP_KEY'),
          'keyword' => $name,
          'format' => 'json',
      ];

      if (empty($name)) {
        return null;
      }

      try {
        $response = $this->client->get('gourmet/v1/', [
          'query' => $params
        ]);
  
        if ($response->getStatusCode() === 200) {
          return json_decode($response->getBody(), true)['results'];
        }
      } catch (\GuzzleHttp\Exception\RequestException $e) {
        return response()->json([
          'message' => 'Request failed',
          'error' => $e->getMessage()
        ], 400);
      }
  
      return null;
  }

  /**
   * 사용자 위치기반 주변 식당 검색 메서드
   */
  public function searchRestaurantsByUserLocation(float $latitude, float $longitude, float $range, ?string $keyword = null)
  {
    $params = [
      'key' => env('APP_KEY'),
      'lat' => $latitude,
      'lng' => $longitude,
      'range' => $range,
      'order' => 4,
      'format' => 'json',
    ];

    if ($keyword !== null) {
      $params['keyword'] = $keyword;
    }

    $response = $this->client->get('gourmet/v1/', [
      'query' => $params
    ]);

    if ($response->getStatusCode() === 200) {
      return json_decode($response->getBody(), true)['results'];
    }

    return null;
  }
}