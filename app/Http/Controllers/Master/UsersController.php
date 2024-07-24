<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\Testing\Concerns\Has;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Master/User/Index', [
            'users' => User::filter(Request::only('search'))->with('roles')->paginate(15),
            'roles' => Role::all()
        ]);
    }

    public function store(UserCreateRequest $request): RedirectResponse
    {
        $validate = $request->validated();
        $validate['password'] = Hash::make($validate['password']);

        $user = User::create($validate);
        $user->assignRole(Role::findById($request->input('role')));

        return Redirect::route('master.users.index')->banner('Tambah Pengguna Berhasil.');
    }

    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $user->update($request->only('name', 'email'));
        $user->syncRoles(Role::findById($request->input('role')));

        return Redirect::route('master.users.index')->banner('Update Pengguna Berhasil.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return Redirect::back()->banner('Hapus Pengguna Berhasil.');
    }
}
