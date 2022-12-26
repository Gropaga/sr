<?php

declare(strict_types=1);

namespace App\SensorReading\Bridge\Controller\Rest;

use App\SensorReading\Application\Command\AddReadingCommand;
use App\SensorReading\Application\Command\Dto\SensorReadingDto;
use App\SensorReading\Application\Query\GetMeanTemperatureForAllSensorsService;
use App\SensorReading\Application\Query\GetMeanTemperatureService;
use JsonException;
use Decimal\Decimal;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

/**
 * @Route("/api/sensor-readings")
 * @OA\Tag(name="Sensor readings endpoints")
 */
final class Controller
{
    private MessageBusInterface $commandBus;
    private GetMeanTemperatureService $getMiddleTemperature;
    private GetMeanTemperatureForAllSensorsService $getMiddleTemperatureForAllSensorsService;

    public function __construct(
        MessageBusInterface $commandBus,
        GetMeanTemperatureService $getMiddleTemperature,
        GetMeanTemperatureForAllSensorsService $getMiddleTemperatureForAllSensorsService
    )
    {
        $this->commandBus = $commandBus;
        $this->getMiddleTemperature = $getMiddleTemperature;
        $this->getMiddleTemperatureForAllSensorsService = $getMiddleTemperatureForAllSensorsService;
    }

    /**
     * @Route("/add", methods={"POST"})
     * @throws JsonException
     */
    public function add(Request $request): JsonResponse
    {
        // TODO implement $requestData validation
        $requestArray = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $reading = $requestArray['reading'];

        $sensorReadingDto = new SensorReadingDto();
        $sensorReadingDto->sensorId = $reading['sensor_uuid'];
        $sensorReadingDto->temperature = new Decimal($reading['temperature']);

        $this->commandBus->dispatch(new AddReadingCommand($sensorReadingDto));

        return new JsonResponse(['OK']);
    }

    /**
     * @Route("/all", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        return new JsonResponse(
            data: $this->getMiddleTemperatureForAllSensorsService->exec(),
            json: true,
        );
    }

    /**
     * @Route("/get/{sensorId}", methods={"GET"})
     */
    public function get(string $sensorId): JsonResponse
    {
        return new JsonResponse(
            data: $this->getMiddleTemperature->exec($sensorId),
            json: true,
        );
    }
}
