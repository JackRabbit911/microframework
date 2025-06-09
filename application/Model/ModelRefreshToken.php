<?php

declare(strict_types=1);

namespace App\Model;

use PDO;
use Pecee\Pixie\QueryBuilder\IQueryBuilderHandler;
use Sys\Model\MysqlModel;

class ModelRefreshToken extends MysqlModel
{
    private string $table = 'refresh_tokens';

    public function __construct(protected IQueryBuilderHandler $qb)
    {
        parent::__construct($qb);
    }

    public function create(array $data)
    {
        $this->qb->table($this->table)->insert($data);
    }

    public function read(string $token, string $user_agent, int $lifetime)
    {
        $expire = date('Y-m-d h:i:s', time() - $lifetime);

        return $this->qb->table($this->table)
            ->select('token', 'user_id', 'updated')
            ->where('user_agent', '=', $user_agent)
            ->where('updated', '>', $expire)
            ->find($token, 'token');
    }

    public function update(string $token, array $data): void
    {
        $this->qb->table($this->table)
            ->where('token', '=', $token)
            ->update($data);
    }

    public function delete(string $token): void
    {
        $this->qb->table($this->table)
            ->where('token', '=', $token)
            ->delete();
    }
}
