<?php
declare(strict_types=1);

namespace App\Dto\Request;

use App\Dto\Request\Transformer\AbstractRequestDtoTransformer;
use Symfony\Component\Validator\Constraints as Assert;

class LoginDto extends AbstractRequestDtoTransformer
{
    /**
     * 账号
     * @Assert\NotBlank(message="手机号不能为空")
     * @Assert\Length(min=11,max=14,exactMessage="手机号格式有误")
     */
    public string $phone;

    /**
     * 密码
     * @Assert\NotBlank(message="密码不能为空")
     * @Assert\Length(min=6,max=18,exactMessage="密码长度应为6~18为")
     */
    public string $password;

    /**
     * 记住密码
     */
    public bool $remeber = false;

}
