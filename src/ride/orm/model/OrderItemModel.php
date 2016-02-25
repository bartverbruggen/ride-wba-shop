<?php

namespace ride\orm\model;

use ride\library\orm\entry\Entry;
use ride\library\StringHelper;
use ride\library\orm\model\GenericModel;

class OrderItemModel extends GenericModel {
    protected function saveEntry($entry) {
        $entry->setPrice($entry->getProduct()->getPrice());
        $entry->setProductName($entry->getProduct()->getTitle());
        $entry->setVATRate($entry->getProduct()->getVATRate()->getRate());

        parent::saveEntry($entry);
    }

}
