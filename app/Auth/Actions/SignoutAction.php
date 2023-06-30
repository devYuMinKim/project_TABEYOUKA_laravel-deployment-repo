<?php

namespace App\Auth\Actions;

use App\Auth\Domains\Users;
use App\Auth\Responders\SignoutResponder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SignoutAction
{
    protected $users, $signoutResponder;

    public function __construct(
        Users $users,
        SignoutResponder $signoutResponder
    ) {
        $this->users = $users;
        $this->signoutResponder = $signoutResponder;
    }

    public function __invoke(Request $request)
    {
        try {
            $request->validate([
                "id" => "required",
            ]);
        } catch (ValidationException $e) {
            // 유효성 검사 실패 시
            $errors = $e->errors();
            return response()->json($errors, 422);
        }

        $result = $this->users->destroyUser($request->id);
        return $this->signoutResponder->signoutResponse($result);
    }
}

?>
