<?php

declare(strict_types=1);

namespace App\Controller;

use App\Email\Booking as BookingEmail;
use App\Entity\Airport;
use App\Entity\AirportTerminal;
use App\Entity\Booking;
use App\Form\BookingType;
use App\Form\Data\Airport as AirportData;
use App\Form\Data\AirportTerminal as AirportTerminalData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class BookingController extends AbstractController
{
    /**
     * @Route("/booking", name="booking")
     */
    public function index(AirportData $airportData, AirportTerminalData $airportTerminalData): Response
    {
        return $this->render('booking/index.html.twig', [
            'airport_data' => json_encode($airportData->getOptions(), JSON_FORCE_OBJECT),
            'airport_terminal_data' => json_encode($airportTerminalData->getOptions(), JSON_FORCE_OBJECT)
        ]);
    }

    /**
     * @Route("/booking/post", name="booking_post")
     */
    public function post(Request $request, BookingEmail $mailer): JsonResponse
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $errors[$error->getOrigin()->getName()] = $error->getMessage();
            }

            return new JsonResponse($errors, 400);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $airport = $entityManager->find(Airport::class, $booking->getAirportName());

        $booking->setAirportName($airport->getName());

        if ($booking->getAirportTerminal()) {
            $terminal = $entityManager->find(AirportTerminal::class, $booking->getAirportTerminal());
            $booking->setAirportTerminal($terminal->getLabel());
        }

        $entityManager->persist($booking);
        $entityManager->flush();

        $mailer->send($booking);

        return new JsonResponse();
    }
}
