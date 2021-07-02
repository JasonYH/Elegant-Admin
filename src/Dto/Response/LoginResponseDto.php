<?php
declare(strict_types=1);

namespace App\Dto\Response;

class LoginResponseDto extends UserInfoResponseDto
{
    public string $token;

    public string $loginTime;
}
