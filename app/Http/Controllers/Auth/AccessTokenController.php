<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

final class AccessTokenController extends Controller
{
    private const PARAM_TOKEN_NAME = 'token_name';

    public function create(LoginRequest $request)
    {
        $request->authenticate();

        $validator = Validator::make($request->input(), [
            self::PARAM_TOKEN_NAME => 'required',
        ]);

        $validator->validate();

        $controller = $this;

        $validator->after(static function($validator) use ($request, $controller) {
            $token = $controller->findTokenByName($request->user(), $request->{self::PARAM_TOKEN_NAME});

            if ($token instanceof PersonalAccessToken) {
                $validator->errors()->add(
                    self::PARAM_TOKEN_NAME, "Token with name '{$request->{self::PARAM_TOKEN_NAME}}' already exists"
                );
            }
        });
        $validator->validate();

        $token = $request->user()->createToken($request->{self::PARAM_TOKEN_NAME});

        return $token->plainTextToken;
    }

    public function revokeAll(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->noContent();
    }

    public function revokeCurrent(Request $request): Response
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }

    private function findTokenByName(User $user, string $name): ?PersonalAccessToken
    {
        $token = $user->tokens()->where('name', $name)->first();

        return $token instanceof PersonalAccessToken ? $token : null;
    }
}
