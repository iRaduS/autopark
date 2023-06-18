<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserRoleRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UsersController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        $users = User::withTrashed()->paginate(10);

        return Inertia::render('Admin/Users/Users', compact('users'));
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
        } catch(\Exception $e) {
            return Redirect::back()->withErrors($e->getMessage());
        }

        return Redirect::back()->with([
            'success' => __('Utilizatorul a fost dezactivat cu succes.'),
        ]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(User $user)
    {
        try {
            $user->restore();
        } catch (\Exception $e) {
            return Redirect::back()->withErrors($e->getMessage());
        }

        return Redirect::back()->with([
           'success' => __('Utilizatorul a fost activat cu succes.'),
        ]);
    }

    /**
     * @param User $user
     */
    public function edit(User $editable)
    {
        return Inertia::render('Admin/Users/Edit', compact('editable'));
    }

    /**
     * @param User $user
     * @param UpdateUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        try {
            $user->update($request->only('name', 'email', 'title'));
        } catch(\Exception $e) {
            return Redirect::back()->withErrors($e->getMessage());
        }

        return Redirect::back()->with([
            'success' => __('Utilizatorul a fost actualizat cu succes.')
        ]);
    }

    /**
     * @param User $user
     */
    public function updateRoles(User $user, UpdateUserRoleRequest $request)
    {
        try {
            $user->syncRoles($request->role);

            if ($request->role === 'Basic') {
                $user->syncPermissions($request->perms);
            }
        } catch(\Exception $e) {
            return Redirect::back()->withErrors($e->getMessage());
        }

        return Redirect::back()->with([
            'success' => __('Utilizatorul a fost actualizat cu succes.')
        ]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDestroy(User $user)
    {
        try {
            $user->forceDelete();
        } catch(\Exception $e) {
            Return Redirect::back()->withErrors($e->getMessage());
        }
        return Redirect::route('admin.users')->with([
            'success' => __('Utilizatorul a fost permanent cu succes.')
        ]);
    }

    public function store(StoreUserRequest $request) {
        try {
            $user = User::create($request->only('name', 'email', 'title', 'password'));
            $user->syncRoles('Basic');
        } catch(\Exception $e) {
            return Redirect::back()->withErrors($e->getMessage());
        }

        return Redirect::back()->with([
            'success' => __('Utilizatorul a fost creat cu succes.')
        ]);
    }
}
