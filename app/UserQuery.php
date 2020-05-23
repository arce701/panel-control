<?php

namespace App;

class UserQuery extends QueryBuilder
{
    public function findByEmail($email)
    {
        return $this->where(compact('email'))->first();
    }

    public function withLastLogin()
    {
        $subSelect = Login::select('logins.created_at')
            ->whereColumn('logins.user_id', 'users.id')
            ->latest()
            ->limit(1);

        $this->addSelect([
            'last_login_at' => $subSelect,
        ]);
        return $this;
    }
}