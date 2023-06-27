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

  // 검색 메서드(장르, 대형 지역, 중형 지역 선택 가능)
  public function searchRestaurantsByLocationCode(?string $genre = null, ?string $large_area = null, ?string $middle_area = null) {
    $params = [
      'key' => 'd79ce7978212ebd8',
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

  // 검색 메서드(가게명)
  public function searchRestaurantsByKeyword(string $keyword) {
    $params = [
      'key' => 'd79ce7978212ebd8',
      'keyword' => $keyword,
      'format' => 'json',
    ];

    $response = $this->client->get('shop/v1/', [
      'query' => $params
    ]);

    if ($response->getStatusCode() === 200) {
      return json_decode($response->getBody(), true)['results'];
    }

    return null;
  }
}