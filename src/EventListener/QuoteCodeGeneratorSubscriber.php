<?php

namespace App\EventListener;

use App\Entity\Quote;
use App\Repository\QuoteRepository;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class QuoteCodeGeneratorSubscriber implements EventSubscriberInterface
{

    private $quotes;

    public function __construct(QuoteRepository $quotes)
    {
        $this->quotes = $quotes;
    }

    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::PRE_PERSIST => 'generateCode'
        ];
    }

    public function generateCode(GenericEvent $args)
    {
        $entity = $args->getSubject();
        if (!$entity instanceof Quote || $entity->code() !== null) {
            return;
        }

        $count = $this->quotes->count([]);
        $code = null;

        do {
            ++$count;
            $code = sprintf('D-DULAC-%s-%03d', $entity->createdAt()->format('Ym'), $count);
        } while ($this->quotes->existsWithCodeEndingBy(sprintf('-%03d%%', $count)));

        $entity->setCode($code);
    }
}
