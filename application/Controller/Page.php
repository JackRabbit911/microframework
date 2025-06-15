<?php

declare(strict_types=1);

namespace App\Controller;

use App\Enum\Gender;
use App\Model\ModelUser;
use HttpSoft\Response\JsonResponse;
use Sys\Controller\BaseController;

class Page extends BaseController
{
    public function __construct(private ModelUser $model){}

    public function users()
    {
        $sex_value = $this->request->getQueryParams()['sex'] ?? null;
        $sex = Gender::search($sex_value);

        $list = $this->model->get(0, 0, $sex);

        return new JsonResponse([
            'success' => true,
            'list' => $list
        ]);
    }

    public function total()
    {
        $total = $this->model->getTotal();

        return new JsonResponse([
            'success' => true,
            'total' => $total,
        ]);
    }


}
