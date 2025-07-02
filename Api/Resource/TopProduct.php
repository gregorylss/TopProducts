<?php

namespace TopProducts\Api\Resource;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;
use Thelia\Api\Bridge\Propel\Filter\SearchFilter;
use Thelia\Api\Resource\Product;
use Thelia\Api\Resource\PropelResourceInterface;
use Thelia\Api\Resource\PropelResourceTrait;
use Thelia\Api\Resource\ResourceAddonInterface;
use Thelia\Api\Resource\ResourceAddonTrait;
use TopProducts\Api\State\TopProductProvider;
use TopProducts\Model\Map\TopProductTableMap;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/admin/top-products',
            paginationEnabled: true,
            provider: TopProductProvider::class
        ),
    ],
    normalizationContext: ['groups' => [self::GROUP_ADMIN_READ]],
)]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/front/top-products',
            paginationEnabled: true,
            provider: TopProductProvider::class
        ),
    ],
    normalizationContext: ['groups' => [self::GROUP_FRONT_READ]]
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'id',
        'productId',
        'elementKey',
        'elementId',
        'selectionCode',
    ]
)]
class TopProduct implements PropelResourceInterface, ResourceAddonInterface
{
    use PropelResourceTrait;
    use ResourceAddonTrait;

    public const GROUP_ADMIN_READ = 'admin:top-product-read';
    public const GROUP_FRONT_READ = 'front:top-product-read';

    #[Groups([self::GROUP_ADMIN_READ, self::GROUP_FRONT_READ])]
    public ?int $id = null;

    #[Groups([Product::GROUP_ADMIN_READ, Product::GROUP_ADMIN_WRITE, Product::GROUP_FRONT_READ, Product::GROUP_FRONT_READ_SINGLE])]
    public ?int $productId = null;

    #[Groups([self::GROUP_ADMIN_READ, self::GROUP_FRONT_READ])]
    public ?string $elementKey = null;

    #[Groups([self::GROUP_ADMIN_READ, self::GROUP_FRONT_READ])]
    public ?int $elementId = null;

    #[Groups([self::GROUP_ADMIN_READ, self::GROUP_FRONT_READ])]
    public ?string $selectionCode = null;

    #[Groups([self::GROUP_ADMIN_READ, self::GROUP_FRONT_READ])]
    public ?int $position = null;

    #[Groups([self::GROUP_ADMIN_READ, self::GROUP_FRONT_READ])]
    public ?\DateTimeInterface $createdAt = null;

    #[Groups([self::GROUP_ADMIN_READ, self::GROUP_FRONT_READ])]
    public ?\DateTimeInterface $updatedAt = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getProductId(): ?int
    {
        return $this->productId;
    }

    public function setProductId(?int $productId): self
    {
        $this->productId = $productId;
        return $this;
    }

    public function getElementKey(): ?string
    {
        return $this->elementKey;
    }

    public function setElementKey(?string $elementKey): self
    {
        $this->elementKey = $elementKey;
        return $this;
    }

    public function getElementId(): ?int
    {
        return $this->elementId;
    }

    public function setElementId(?int $elementId): self
    {
        $this->elementId = $elementId;
        return $this;
    }

    public function getSelectionCode(): ?string
    {
        return $this->selectionCode;
    }

    public function setSelectionCode(?string $selectionCode): self
    {
        $this->selectionCode = $selectionCode;
        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return TableMap|null
     * @throws PropelException
     */
    #[Ignore]
    public static function getPropelRelatedTableMap(): ?TableMap
    {
        return TopProductTableMap::getTableMap();
    }

    #[Ignore] public static function getResourceParent(): string
    {
        return Product::class;
    }
}
