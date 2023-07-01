<?php

namespace App\Restaurant\Actions;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Restaurant\Domain\Restaurant;
use App\Restaurant\Responders\CreateRestaurantResponder;

class CreateRestaurantAction
{
  protected $domain;
  protected $responder;

  public function __construct(
    Restaurant $domain,
    CreateRestaurantResponder $responder
  ) {
    $this->domain = $domain;
    $this->responder = $responder;
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

    $restaurant = $request->only(['id', 'score']);

    $response = $this->domain->createRestaurant($restaurant);

    return $this->responder->respond($response);
  }
}
