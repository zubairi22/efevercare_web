<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleCreateRequest;
use App\Http\Requests\Role\RoleUpdateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Master/Role/Index', [
            'roles' => Role::with('permissions')->get(),
            'permissions' => Permission::pluck('name')
        ]);
    }

    public function store(RoleCreateRequest $request): RedirectResponse
    {
        $role = Role::create($request->validated());
        $role->syncPermissions($request->input('permissions'));

        return Redirect::route('master.roles.index')->banner('Tambah Role Berhasil.');
    }

    public function update(RoleUpdateRequest $request, Role $role): RedirectResponse
    {
        $role->update($request->validated());
        $role->syncPermissions($request->input('permissions'));

        return Redirect::route('master.roles.index')->banner('Update Role Berhasil.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();

        return Redirect::back()->banner('Hapus Role Berhasil.');
    }
}
