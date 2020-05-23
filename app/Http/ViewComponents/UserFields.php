<?php

namespace App\Http\ViewComponents;

use App\Profession;
use App\Skill;
use App\User;
use Illuminate\Contracts\Support\Htmlable;

class UserFields implements Htmlable
{
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function toHtml()
    {
        return view('users._fields', [
            'professions' => Profession::orderBy('title', 'asc')->get(),
            'skills' => Skill::orderBy('name', 'asc')->get(),
            'roles' => trans('users.roles'),
            'user' => $this->user
        ]);
    }
}