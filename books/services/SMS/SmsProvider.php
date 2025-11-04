<?php
declare(strict_types=1);

namespace books\services\SMS;

use books\services\SMS\interface\SmsInterface;

final class SmsProvider implements SmsInterface
{
    public function send(string $phone): void
    {
        echo "тут реализуем отправку ";
    }
}