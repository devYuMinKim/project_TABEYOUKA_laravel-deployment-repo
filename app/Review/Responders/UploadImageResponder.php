<?php

namespace App\Review\Responders;

class UploadImageResponder
{
  public function respond($result)
  {
    return response()->json($result, 201);
  }
}
