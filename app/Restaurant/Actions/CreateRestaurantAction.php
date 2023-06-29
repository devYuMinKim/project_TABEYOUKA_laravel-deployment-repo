<?php

namespace App\Restaurant\Actions;

use Illuminate\Http\Request;
use App\Restaurant\Domain\CreateRestaurantDomain;
use Illuminate\Validation\ValidationException;

class CreateRestaurantAction
{
  protected $domain;

  public function __construct(CreateRestaurantDomain $domain)
  {
    $this->domain = $domain;
  }

  public function __invoke(Request $request)
  {
    try {
      $request->validate([
        'id' => 'required|integer',
        'score' => 'integer',
      ]);
    } catch (ValidationException $e) {
      $errors = $e->errors();
      return response()->json($errors, 422);
    }

    $restaurant = $request->only([
      'id',
      'score',
    ]);

    return $this->domain->createRestaurant($restaurant);
  }
}