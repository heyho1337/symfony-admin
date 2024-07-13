<?php

namespace App\Factory;

use App\Entity\EvcProduct;
use App\Entity\EvcCategory;
use App\Factory\EvcCategoryFactory;
use App\Repository\EvcCategoryRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
/**
 * @extends PersistentProxyObjectFactory<EvcProduct>
 */
final class EvcProductFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(private EvcCategoryRepository $categRepo)
    {
    }

    public static function class(): string
    {
        return EvcProduct::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'prod_active' => 1,
            'prod_name' => self::faker()->text(75),
            'prod_price' => self::faker()->randomFloat(0,1000),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            ->afterInstantiate(function(EvcProduct $evcProduct): void {
				EvcCategoryFactory::createMany(30);
				$categories = $this->categRepo->getRandomCategories();
                foreach ($categories as $category) {
                    $evcProduct->addProdCategory($category);
                }
            });
    }
}
