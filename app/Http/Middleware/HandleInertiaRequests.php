<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share($request)
    {
        $menus = Menu::whereNull('parent_id')->orderBy('sort')->get();

        if (Auth::check()) {
            $userPermissions = Auth::user()->getAllPermissions()->pluck('id')->toArray();
            $filteredMenus = $menus->filter(function ($menu) use ($userPermissions) {
                foreach ($menu->permissions as $permission) {
                    if (in_array($permission->id, $userPermissions)) {
                        return true;
                    }
                }
                return false;
            });
            $sidebarMenus = $filteredMenus->values();
        } else {
            $sidebarMenus = collect();
        }

        return array_merge(parent::share($request), [
            'sidebarMenus' => $sidebarMenus,
            'can' => $request->user() ? $request->user()->getPermissionsViaRoles()->pluck('name') : null
        ]);
    }
}
