<?php

namespace App\EventListener;

use App\Entity\Invoice;
use App\Repository\InvoiceRepository;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class InvoiceCodeGeneratorSubscriber implements EventSubscriberInterface
{

    private $invoices;

    public function __construct(InvoiceRepository $invoices)
    {
        $this->invoices = $invoices;
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
        if (!$entity instanceof Invoice || $entity->code() !== null) {
            return;
        }

        $count = $this->invoices->count([]);
        $code = null;

        do {
            ++$count;
            $code = sprintf('F-DULAC-%s-%03d', $entity->createdAt()->format('Ym'), $count);
        } while ($this->invoices->existsWithCodeEndingBy(sprintf('-%03d%%', $count)));

        $entity->setCode($code);
    }
}
