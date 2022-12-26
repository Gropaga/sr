<?php

declare(strict_types=1);

namespace App\Tests\Users\Infrastructure\Client;

use App\Users\Infrastructure\Client\GuzzleUsersClient;
use App\Users\Infrastructure\Client\UserDtoFactory;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Message\ResponseInterface;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class GuzzleUsersClientTest extends TestCase
{
    /**
     * @test
     */
    public function itThrowsExceptionOnEmptyResponse()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('No response received');

        $guzzleMock = $this->createMock(ClientInterface::class);
        $guzzleMock->method('get')->willReturn(null);

        $userDtoFactoryMock = $this->createMock(UserDtoFactory::class);

        $service = new GuzzleUsersClient(
            $guzzleMock,
            $userDtoFactoryMock,
            'www.resource.com'
        );

        $service->getFirstUser();
    }

    /**
     * @test
     */
    public function itThrowsExceptionEmptyBody()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('No body available');


        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getBody')->willReturn(null);

        $guzzleMock = $this->createMock(ClientInterface::class);
        $guzzleMock->method('get')->willReturn($responseMock);

        $userDtoFactoryMock = $this->createMock(UserDtoFactory::class);

        $service = new GuzzleUsersClient(
            $guzzleMock,
            $userDtoFactoryMock,
            'www.resource.com'
        );

        $service->getFirstUser();
    }
}