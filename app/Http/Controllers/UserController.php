<?php

namespace App\Http\Controllers;

use App\Http\Forms\UserForm;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Skill;
use App\Sortable;
use App\User;
use App\Filters\UserFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request, UserFilter $filters, Sortable $sortable)
    {
        $users = User::query()
            ->with('team', 'skills', 'profile.profession')
            ->withLastLogin()
            ->onlyTrashedIf($request->routeIs('users.trashed'))
            ->applyFilters()
            ->orderByDesc('created_at')
            ->paginate();

        $sortable->appends($users->parameters());

        return view('users.index', [
            'users' => $users,
            'view' => $request->routeIs('users.index') ? 'index' : 'trash',
            'skills' => Skill::orderBy('name')->get(),
            'checkedSkills' => collect(request('skills')),
            'sortable' => $sortable,
        ]);
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function create()
    {
        return new UserForm('users.create', new User());
    }

    public function store(CreateUserRequest $request)
    {
        $request->createUser();

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return new UserForm('users.edit', $user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $request->updateUser($user);

        return redirect()->route('users.show', ['user' => $user]);
    }

    public function trash(User $user)
    {
        $user->delete();
        $user->profile()->delete();

        DB::table('user_skill')
            ->where('user_id', $user->id)
            ->update(['deleted_at' => now()]);

        return redirect()->route('users.index');
    }

    function destroy($id)
    {
        $user = User::onlyTrashed()->where('id', $id)->firstOrFail();
        $user->forceDelete();

        return redirect()->route('users.trashed');
    }
}
