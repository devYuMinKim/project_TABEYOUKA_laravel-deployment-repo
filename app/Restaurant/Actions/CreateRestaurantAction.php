<?php

namespace App\Restaurant\Actions;

use Illuminate\Http\Request;
use App\Exceptions\RestaurantAlreadyExistsException;
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
    $this->validateRequest($request);

    $restaurant = $request->only(['id', 'score']);

    try {
      $response = $this->domain->createRestaurant($restaurant);
    } catch (RestaurantAlreadyExistsException $e) {
      return response()->json(['error' => '이미 식당이 존재합니다.'], 422);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);
    }

    return $this->responder->respond($response);
  }

  public function validateRequest(Request $request)
  {
    $request->validate([
      'id' => 'required|integer',
    ]);
  }
}
