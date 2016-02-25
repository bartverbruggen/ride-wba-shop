<?php

namespace ride\orm\entry;

use ride\application\orm\entry\ProductVariantEntry as OrmConcertEntry;

/**
 * ProductVariantEntry
 */
class ProductVariantEntry extends OrmConcertEntry {
    public function getTitle() {
        $titles = [];
        $size = $this->getSize();
        $color = $this->getColor();
        $material = $this->getMaterial();
        if ($size) {
            $titles[] = $this->getTaxonomyName($size);
        }
        if ($color) {
            $titles[] = $this->getTaxonomyName($color);
        }
        if ($material) {
            $titles[] = $this->getTaxonomyName($material);
        }

        return implode(' - ', $titles);
    }

    private function getTaxonomyName($item) {
        if (is_array($item)) {
            $item = reset($item);
        }
        return $item->getName();
    }
}
