<?php

namespace App\EventListener;

use App\Entity\Interfaces\HasAmount;
use App\Entity\Interfaces\HasDiscount;
use App\Entity\Interfaces\HasInvoiceItem;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class SetAmountSubscriber  implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::PRE_PERSIST => 'updateTotal',
            EasyAdminEvents::PRE_UPDATE => 'updateTotal',
        ];
    }

    public function updateTotal(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if (!$entity instanceof HasAmount) {
            return;
        }

        $total = 0;

        if ($entity instanceof HasInvoiceItem) {
            foreach ($entity->items() as $item) {
                $total += $item->total();
            }
        }


        if ($entity instanceof HasDiscount) {
            foreach ($entity->discounts() as $discount) {
                $total -= $discount->total();
            }
        }

        $entity->setAmount($total);
    }

}