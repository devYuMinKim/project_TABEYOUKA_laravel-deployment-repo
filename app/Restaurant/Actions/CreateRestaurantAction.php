<?php

namespace App\Restaurant\Actions;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Restaurant\Domain\Restaurant;
use App\Restaurant\Responders\CreateRestaurantResponder;

class CreateRestaurantAction
{
  public function __construct(
    protected Restaurant $domain,
    protected CreateRestaurantResponder $responder
  ) {
  }

  public function __invoke(Request $request)
  {
    try {
      $request->validate([
        'id' => 'required|integer',
      ]);
    } catch (ValidationException $e) {
      $errors = $e->errors();
      return response()->json($errors, 422);
    }

    $restaurant = $request->only(['id']);

    $response = $this->domain->createRestaurant($restaurant);

    return $this->responder->respond($response);
  }
}
