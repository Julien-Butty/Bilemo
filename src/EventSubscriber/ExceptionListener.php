<?php
///**
// * Created by PhpStorm.
// * User: julienbutty
// * Date: 20/05/2018
// * Time: 21:36
// */

namespace App\EventSubscriber;


use JMS\Serializer\Serializer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use App\Normalizer\NormalizerInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionListener implements EventSubscriberInterface
{
    private $serializer;
    private $normalizers;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function processException(GetResponseForExceptionEvent $event)
    {
        $result = null;

//        foreach ($this->normalizers as $normalizer) {
//            if ($normalizer->supports($exception)) {
//                $result = $normalizer->normalize($event->getException());
//                break;
//            }
//        }
        if (null == $result) {
            $result['code'] = Response::HTTP_BAD_REQUEST;

            $result['body'] = [
                'code'=> Response::HTTP_BAD_REQUEST,
                'message' => $event->getException()->getMessage()
            ];
        }
        $body = $this->serializer->serialize($result['body'],'json');
        $event->setResponse(new Response($body, $result['code']));
    }

    public function addNormalizer(NormalizerInterface $normalizer)
    {
        $this->normalizers[] = $normalizer;
    }

    public static function getSubscribedEvents()
    {
        return [KernelEvents::EXCEPTION => [['processException', 255]]];
    }


}