<?php

namespace TopProducts\Api\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use TopProducts\Service\TopProductQueryService;

readonly class TopProductProvider implements ProviderInterface
{
    public function __construct(
        private TopProductQueryService $queryService,
        private RequestStack           $requestStack
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): iterable
    {
        $request = $this->requestStack->getCurrentRequest();

        $elementKey = $request->query->get('elementKey');
        $elementIds = $request->query->all('elementId') ?? [];
        $selectionCode = $request->query->get('selectionCode');
        $topProductId = $request->query->get('productId');

        $query = $this->queryService->getTopProducts(
            $elementKey,
            $elementIds,
            $selectionCode,
            $topProductId !== null ? (int) $topProductId : null
        );

        return iterator_to_array($query->find());
    }
}
