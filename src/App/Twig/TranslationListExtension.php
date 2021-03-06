<?php

declare(strict_types=1);

namespace App\Twig;

use App\DefaultLocaleResolver;
use Harentius\BlogBundle\Entity\Article;
use Harentius\BlogBundle\Entity\TranslationRepository;
use Harentius\BlogBundle\Twig\TranslationListExtension as BaseTranslationListExtensionAlias;

class TranslationListExtension extends BaseTranslationListExtensionAlias
{
    /**
     * @var TranslationRepository
     */
    private $translationRepository;

    /**
     * @var DefaultLocaleResolver
     */
    private $defaultLocaleResolver;

    /**
     * @param TranslationRepository $translationRepository
     * @param DefaultLocaleResolver $localeResolver
     * @param string $primaryLocale
     */
    public function __construct(
        TranslationRepository $translationRepository,
        DefaultLocaleResolver $localeResolver,
        string $primaryLocale
    ) {
        parent::__construct($translationRepository, $primaryLocale);
        $this->translationRepository = $translationRepository;
        $this->defaultLocaleResolver = $localeResolver;
    }

    /**
     * @param Article $article
     * @return array
     */
    public function translationsList(Article $article): array
    {
        $translations = $this->translationRepository->findTranslations($article);

        return array_merge([$this->defaultLocaleResolver->resolveLocale($article)], $translations);
    }
}
