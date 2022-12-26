<?php

declare(strict_types=1);

namespace App\Tests\Users\Infrastructure\Notifier;

use App\Users\Domain\NotificationStatusEnum;
use App\Users\Infrastructure\Notifier\SmsNotifierService;
use GuzzleHttp\Message\ResponseInterface;
use PHPUnit\Framework\TestCase;

final class SmsNotifierServiceTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldReturnSentEnumEvent()
    {
        $service = new SmsNotifierService();

        $result = $service->sendNotification(
            'message',
            'name',
            'email',
            'phone'
        );

        $this->assertTrue($result->equals(NotificationStatusEnum::SENT()));
    }
}