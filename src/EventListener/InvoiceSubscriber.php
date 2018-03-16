<?php

namespace App\EventListener;

use App\Entity\Invoice;
use App\Repository\InvoiceRepository;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class InvoiceSubscriber implements EventSubscriberInterface
{

    private $invoices;

    public function __construct(InvoiceRepository $invoices)
    {
        $this->invoices = $invoices;
    }

    public static function getSubscribedEvents()
    {
        return [
            'easy_admin.pre_persist' => 'generateCode'
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
            var_dump($code);
        } while ($this->invoices->existsWithCodeEndingBy(sprintf('-%03d%%', $count)));

        $entity->setCode($code);
    }
}
