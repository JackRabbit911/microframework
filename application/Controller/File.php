<?php

declare(strict_types=1);

namespace App\Controller;

use HttpSoft\Response\JsonResponse;
use Sys\Controller\BaseController;
use Sys\Response\FileResponse;

class File extends BaseController
{
    public function __invoke($file)
    {
        $prefix = '../storage/uploads/';
        $file = $prefix . $file;

        if (!is_file($file)) {
            $data = [
                'success' => false,
                'message' => "File: $file not found",
            ];

            return new JsonResponse($data, 404);
        }

        return new FileResponse($file);
    }
}
