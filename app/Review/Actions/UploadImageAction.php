<?php

namespace App\Review\Actions;

use Illuminate\Http\Request;
use App\Review\Domain\Repositories\ReviewRepository as Repository;
use App\Review\Responders\UploadImageResponder as Responder;

class UploadImageAction
{
  public function __construct(
    protected Repository $repository,
    protected Responder $responder
  ) {
  }
  public function __invoke(Request $request)
  {
    $this->validateRequest($request);

    if (!$request->hasFile('image')) {
      return response()->json(['upload_file_not_found'], 400);
    }

    $image = $request->file('image');
    $review_id = $request->input('review_id');

    $response = $this->repository->uploadImage($image, $review_id);

    return $this->responder->respond($response);
  }

  public function validateRequest(Request $request)
  {
    $request->validate([
      'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'review_id' => 'required|integer',
    ]);
  }
}
