<?php

namespace App\Factory;

use App\Entity\EvcProduct;
use App\Factory\ObjectManager;
use App\Repository\EvcCategoryRepository;
use App\Repository\EvcLangRepository;
use Symfony\Component\String\Slugger\AsciiSlugger;
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
    public function __construct(
        protected EvcLangRepository $langRepo,
        protected EvcCategoryRepository $categRepo
    )
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
        $slugger = new AsciiSlugger();

        $names = [];
        $descriptions = [];
        $slugs = [];
        $images = [];
        $langs = $this->langRepo->getActiveLangs();
        for($i = 0; $i < rand(1,5); $i++) {
            $imageId = rand(1,10);
            array_push($images,"test-{$imageId}.jpg");
        }
        foreach ($langs as $lang) {
            $name = self::faker()->words(self::faker()->numberBetween(1, 5),true);
            $slug = $slugger->slug($name)->lower();
            $names[$lang->getLangCode()] = $name;
            $slugs[$lang->getLangCode()] = $slug;
            $descriptions[$lang->getLangCode()] = self::faker()->words(self::faker()->numberBetween(5, 35),true);
        }
        return [
            'createdAt' => self::faker()->dateTime(),
            'prod_active' => 1,
            'prod_name' => $names,
            'prod_description' => $descriptions,
            'prod_price' => self::faker()->randomFloat(min: 100, max: 500000),
            'prod_url' => $slugs,
            'prod_image' => $images,
            'updatedAt' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        $categories = $this->categRepo->getRandomCategories();
        return $this
        ->afterInstantiate(function (EvcProduct $product, array $attributes) use ($categories): void {
            foreach ($categories as $category) {
                $product->addProdCategory($category);
            }
        });
    }
}
