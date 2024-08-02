<?php

namespace App\Factory;

use App\Entity\EvcCategory;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use App\Repository\EvcLangRepository;
use Symfony\Component\String\Slugger\AsciiSlugger;

/**
 * @extends PersistentProxyObjectFactory<EvcCategory>
 */
final class EvcCategoryFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(protected EvcLangRepository $langRepo)
    {
    }

    public static function class(): string
    {
        return EvcCategory::class;
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
        $langs = $this->langRepo->getActiveLangs();
        foreach ($langs as $lang) {
            $name = self::faker()->words(self::faker()->numberBetween(1, 5),true);
            $slug = $slugger->slug($name)->lower();
            $names[$lang->getLangCode()] = $name;
            $slugs[$lang->getLangCode()] = $slug;
            $descriptions[$lang->getLangCode()] = self::faker()->words(self::faker()->numberBetween(5, 35),true);
        }

        return [
            'category_active' => 1,
            'category_name' => $names,
            'createdAt' => self::faker()->dateTime(),
            'category_url' => $slugs,
            'category_description' => $descriptions,
            'updatedAt' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(EvcCategory $evcCategory): void {})
        ;
    }
}
