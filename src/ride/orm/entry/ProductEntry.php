<?php

namespace ride\orm\entry;

use ride\application\orm\entry\ProductEntry as OrmConcertEntry;

/**
 * ProductEntry
 */
class ProductEntry extends OrmConcertEntry {
    public function getPriceWithVAT() {
        $price = $this->getPrice();
        $vat = $this->getVATRate()->getRate();

        return $price *= ($vat / 100 + 1);
    }

    public function getVariantOptions() {
        $variants = $this->getVariants();
        $variantOptions = [];

        foreach ($variants as $variant) {
            foreach ($variant->getSize() as $id => $size) {
                $variantOptions['size'][$id] = $size->getName();
            }
            foreach ($variant->getColor() as $id => $color) {
                $variantOptions['color'][$id] = $color->getName();
            }
            foreach ($variant->getMaterial() as $id => $material) {
                $variantOptions['material'][$id] = $material->getName();
            }
        }

        return $variantOptions;
    }
}
