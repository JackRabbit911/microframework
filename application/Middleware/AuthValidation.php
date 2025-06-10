<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Model\ModelAuth;
use Az\Validation\Middleware\ApiValidationMiddleware;
use Attribute;

#[Attribute]
class AuthValidation extends ApiValidationMiddleware
{
    public function __construct(private ModelAuth $model){}

    protected function setRules($request)
    {
        $this->validation->rule('email', 'required|email')
            ->rule('password', 'required|password')
            ->rule('password', [$this->model, 'isPairEmailPswd'], ':email')
            ->addMsgPath(APPPATH . 'config/messages');
    }
}
