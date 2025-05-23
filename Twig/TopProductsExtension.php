<?php

namespace TopProducts\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use TopProducts\Model\TopProduct;
use TopProducts\Model\TopProductQuery;

class TopProductsExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('top_products', [$this, 'getTopProduct']),
        ];
    }

    public function getTopProducts(string $elementKey, int $elementId, string $selectionCode): string
    {
        $topProductResults = TopProductQuery::create()
            ->filterByElementKey($elementKey)
            ->filterByElementId($elementId)
            ->filterBySelectionCode($selectionCode)
            ->find();

        $topProducts = [];

        /** @var TopProduct $topProductResult */
        foreach ($topProductResults as $topProductResult) {
            $topProducts[] = $topProductResult->getProductId();
        }

        return implode(',', $topProducts);
    }
}
