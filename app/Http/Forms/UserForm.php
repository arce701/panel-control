<?php

namespace App\Http\Forms;

use App\Profession;
use App\Skill;
use App\User;
use Illuminate\Contracts\Support\Responsable;

class UserForm implements Responsable
{
    private $view;
    private $user;

    public function __construct($view, User $user)
    {
        $this->view = $view;
        $this->user = $user;
    }

    public function toResponse($request)
    {
        return view($this->view, [
            'user' => $this->user,
            'professions' => Profession::orderBy('title', 'asc')->get(),
            'skills' => Skill::orderBy('name', 'asc')->get(),
            'roles' => trans('users.roles'),
        ]);
    }
}