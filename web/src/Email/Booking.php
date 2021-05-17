<?php

declare(strict_types=1);

namespace App\Email;

use App\Entity\Booking as BookingEntity;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Serializer\SerializerInterface;

class Booking
{
    const FROM = 'hello@example.com';
    const TO = 'customer@example.com';

    /**
     * @param MailerInterface $mailer
     */
    private $mailer;

    /**
     * @param SerializerInterface $serializer
     */
    private $serializer;

    public function __construct(MailerInterface $mailer, SerializerInterface $serializer)
    {
        $this->mailer = $mailer;
        $this->serializer = $serializer;
    }

    public function send(BookingEntity $booking): void
    {
        $email = (new Email())
            ->from(self::FROM)
            ->to(self::TO)
            ->subject('Your booking request was received!')
            ->html($this->getDataHtml($booking));

        $this->mailer->send($email);
    }

    private function getDataHtml(BookingEntity $booking): string
    {
        $data = $this->getSerializedData($booking);
        $html = '<ul>';

        foreach ($data as $key => $field) {
            $key = preg_replace('~(\p{Ll})(\p{Lu})~u','${1} ${2}', $key);
            $key = ucwords($key);

            $html .= '<li><span>' . $key . '</span>:&nbsp;' . $field . '</li>';
        }

        $html .= '</ul>';

        return $html;
    }

    private function getSerializedData(BookingEntity $booking): array
    {
        $data = $this->serializer->normalize($booking);

        $data['dateOfArrival'] = date('M j, Y, g:i A', strtotime($data['dateOfArrival']));
        unset($data['id']);

        return $data;
    }
}
