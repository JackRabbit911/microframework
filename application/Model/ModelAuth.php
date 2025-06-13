<?php

declare(strict_types=1);

namespace App\Model;

use App\DTO\User;
use Pecee\Pixie\QueryBuilder\IQueryBuilderHandler;
use Sys\Model\MysqlModel;

class ModelAuth extends MysqlModel
{
    private User $user;

    public function __construct(protected IQueryBuilderHandler $qb)
    {
        parent::__construct($qb);
    }

    public function isPairEmailPswd(string $password, string $email): bool
    {
        $user = $this->qb->table('users')
            ->select('id', 'name', 'password')
            ->find($email, 'email');

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user->password)) {
            $this->user = User::fromObject($user);
            return true;
        } else {
            return false;
        }
    }

    public function find(int|string $id, string $column = 'id'): ?User
    {
        $user = $this->qb->table('users')
            ->select('id', 'name')
            ->find($id, $column);

        return ($user) ? User::fromObject($user) : null;
    }

    public function get()
    {
        return $this->user ?? null;
    }
}
