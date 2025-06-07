<?php

declare(strict_types=1);

namespace App\Middleware;

use Attribute;
use Az\Validation\Middleware\ApiValidationMiddleware;

#[Attribute]
class AuthValidation extends ApiValidationMiddleware
{
    protected function setRules($request)
    {
        $this->validation->rule('email', 'required|email')
            ->rule('password', 'required|password');
    }
}
