<?php

namespace TopProducts\Service;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\Join;
use Thelia\Model\ProductQuery;
use Thelia\Model\Map\ProductTableMap;
use TopProducts\Model\Map\TopProductTableMap;

class TopProductQueryService
{
    public function getTopProducts(
        ?string $elementKey,
        array $elementIds = [],
        ?string $selectionCode = null,
        ?int $topProductId = null
    ): ProductQuery {
        $query = ProductQuery::create();

        // Join Product ↔ TopProduct
        $join = new Join();
        $join->addExplicitCondition(
            ProductTableMap::TABLE_NAME,
            'ID',
            null,
            TopProductTableMap::TABLE_NAME,
            'PRODUCT_ID',
            null
        );
        $join->setJoinType(Criteria::INNER_JOIN);
        $query->addJoinObject($join);

        // WHERE conditions
        if ($elementKey !== null) {
            $query->where(TopProductTableMap::ELEMENT_KEY . ' = ?', $elementKey, \PDO::PARAM_STR);
        }

        if (!empty($elementIds)) {
            $query->where(
                TopProductTableMap::ELEMENT_ID . ' IN (' . implode(',', array_map('intval', $elementIds)) . ')'
            );
        }

        if ($selectionCode !== null) {
            $query->where(TopProductTableMap::SELECTION_CODE . ' = ?', $selectionCode, \PDO::PARAM_STR);
        }

        if ($topProductId !== null) {
            $query->where(TopProductTableMap::ID . ' = ?', $topProductId, \PDO::PARAM_INT);
        }

        $query->withColumn(TopProductTableMap::POSITION, 'top_product_position');

        $query->clearOrderByColumns();
        $query->orderBy('top_product_position', Criteria::ASC);

        return $query;
    }
}
