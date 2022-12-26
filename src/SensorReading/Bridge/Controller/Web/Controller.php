<?php

declare(strict_types=1);

namespace App\SensorReading\Bridge\Controller\Web;

use App\SensorReading\Application\Command\AddApiReadingCommand;
use App\SensorReading\Bridge\Controller\Web\Form\SensorReadingRequestForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class Controller extends AbstractController
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/", name="landing_page")
     */
    public function index(): Response
    {
        $form = $this->createForm(SensorReadingRequestForm::class, null, [
            'action' => $this->generateUrl('add_sensor_reading'),
            'method' => 'POST',
        ]);

        return $this->renderForm('index.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/add-sensor-reading", name="add_sensor_reading")
     */
    public function addSensorReading(Request $request): Response
    {
        $form = $this->createForm(SensorReadingRequestForm::class);

        $form->handleRequest($request);

        // TODO implement form validation
        if (false === $form->isSubmitted()) {
            return $this->redirectToRoute('landing_page');
        }

        $ipAddress = $form->getData()['ip'];

        $this->commandBus->dispatch(new AddApiReadingCommand($ipAddress));

        return $this->redirectToRoute('landing_page');
    }
}
