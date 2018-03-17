<?php

namespace App\EventListener;

use App\Entity\Quote;
use Doctrine\Common\PropertyChangedListener;

class QuoteAcceptedListener implements PropertyChangedListener
{
    private function removeBudget(Quote $quote)
    {
        $project = $quote->project();
        $project->setBudget($project->budget() - $quote->amount());
    }

    private function addBudget(Quote $quote)
    {
        $project = $quote->project();
        $project->setBudget($project->budget() + $quote->amount());
    }

    public function propertyChanged($sender, $propertyName, $oldValue, $newValue)
    {
        if (!$sender instanceof Quote || $propertyName != 'accepted') {
            return;
        }

        $quote = $sender;
        if ($newValue === true) {
            $this->addBudget($quote);
        } else {
            $this->removeBudget($quote);
        }
    }
}