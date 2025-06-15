<?php

declare(strict_types=1);

namespace App\Model;

use Sys\Model\MysqlModel;

class ModelUser extends MysqlModel
{
    public function get(int $limit, int $offset, ?int $sex)
    {
        $table = $this->qb->table('users')
            ->select('name', 'dob', 'sex');

        if ($sex !== null) {
            $table->where('sex' , '=', $sex);
        }

        if ($limit) {
            $table->limit($limit);
        }

        if ($offset) {
            $table->offset($offset);
        }
            
        return $table->get();
    }

    public function getTotal()
    {
        return $table = $this->qb->table('users')->count();
    }
}
