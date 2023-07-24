<?php

namespace App\Profile\Domains\Repositories;
use App\Profile\Domains\Entities\Follows;
use Illuminate\Database\QueryException;

class UnfollowRepository
{
  public function delete($data)
  {
    try {
      $result = Follows::where('from_user', $data->id)
        ->where('to_user', $data->follow_id)
        ->delete();
    } catch (QueryException $e) {
      $errMsg = $e->getMessage();
      return response($errMsg);
    }
    return $result;
  }
}

?>
