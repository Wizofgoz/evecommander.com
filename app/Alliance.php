<?php

namespace App;

use App\Abstracts\Organization;
use App\Traits\HasSettings;
use App\Traits\HasSRP;
use App\Traits\ReceivesInvoices;

class Alliance extends Organization
{
    use HasSettings, HasSRP, ReceivesInvoices;

    /**
     * Get collection of subscribers for invoice events
     *
     * @return \Illuminate\Support\Collection
     */
    public function receivedInvoiceSubscribers()
    {
        $subscriberIds = $this->settings()->value['invoices']['received']['subscribers'];

        $subscribers = User::find($subscriberIds);

        // normalize single result case
        if ($subscribers instanceof User) {
            $subscribers = collect($subscribers);
        }

        return $subscribers;
    }
}
