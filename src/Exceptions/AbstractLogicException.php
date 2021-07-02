<?php
declare(strict_types=1);

namespace App\Exceptions;

abstract class AbstractLogicException extends \LogicException
{
    public $code;

    public $message;

    public $httpStatusCode;


    // 参数错误
    public const PARAMETER_ERROR = -1;
    // 未授权
    public const UNAUTHORIZED_ERROR = -401;
    // 无权限
    public const PAYMENT_ERROR = -402;
    // 不存在
    public const NOTFOUND_ERROR = -404;

}
