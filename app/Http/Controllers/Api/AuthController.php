<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;
use App\Services\OAuthService;

class AuthController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:4',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $data = $request->only(['name', 'email', 'password']);

        /** @var User $user */
        $user = User::create(array_merge($data, [
            'password' => Hash::make($request->password)
        ]));

        return $user->only([
            'id',
            'name',
            'email',
        ]);
    }

    public function index(Request $request)
    {
        return User::query()->orderBy('id')->get()->all();
    }

    public function show(Request $request, $id)
    {
        $request->merge(['id' => $id])->validate(['id' => 'required|int|exists:users,id']);

        return User::query()->where('id', $id)->first();
    }

    public function destroy(Request $request, $id)
    {
        $request->merge(['id' => $id])->validate(['id' => 'required|int|exists:users,id']);

        User::query()->where('id', $id)->delete();

        return response()->noContent();
    }

    public function patch(Request $request, $id)
    {
        $request
        ->merge(['id' => $id])
        ->validate([
            'name' => 'nullable|string|min:4',
            'email' => 'nullable|email',
            'password' => 'nullable|min:8',
        ]);

        $data = $request->only(['name', 'email', 'password']);

        $user = User::query()->where('id', $id)->first();

        $user->fill($data);

        $user->save();

        return $user->refresh();
    }
}
