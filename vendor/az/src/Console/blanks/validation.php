<?=$php?>


declare(strict_types=1);

namespace <?=$namespace?>;

use Az\Validation\Middleware\ValidationMiddleware;
use Psr\Http\Message\ServerRequestInterface;

class <?=$classname?> extends ValidationMiddleware
{
    protected function setRules($request)
    {
        $this->validation->rule('fieldname', 'required|minLength(8)');
    }
}
