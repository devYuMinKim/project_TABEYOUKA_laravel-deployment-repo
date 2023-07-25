<?php

namespace App\Profile\Actions;

use App\Profile\Domains\Repositories\GetRestaurantCoordinatesRepository as Repository;
use App\Profile\Responders\GetRestaurantCoordinatesResponder as Responder;
use Illuminate\Http\Request;

class GetRestaurantCoordinatesAction
{
  public function __construct(
    protected Responder $responder,
    protected Repository $repository
  ) {
  }

  public function __invoke(Request $request)
  {
    $request->validate([
      'user_id' => 'required',
    ]);

    $result = $this->repository->get($request->user_id);

    return $this->responder->respond($result);
  }
}

?>
