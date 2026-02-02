<?php

declare(strict_types=1);

/*
 * This file is part of Alengo\Bundle\AlengoFormBundle.
 *
 * (c) alengo
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Alengo\Bundle\AlengoFormBundle\Controller;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Sulu\Bundle\PreviewBundle\Preview\Preview;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class FormDataController extends AbstractController
{
    private const DEFAULT_TEMPLATE = '@AlengoForm/FormData/default.html.twig';

    public function __construct(
        private readonly Environment $twig,
    ) {
    }

    public function indexAction(FormData $formData, array $attributes = [], bool $preview = false, bool $partial = false): Response
    {
        $templatePath = $this->resolveTemplatePath($formData);

        if ($partial) {
            $content = $this->renderBlockView(
                $templatePath,
                'content',
                ['formData' => $formData],
            );
        } elseif ($preview) {
            $content = $this->renderPreview(
                $templatePath,
                ['formData' => $formData],
            );
        } else {
            $content = $this->renderView(
                $templatePath,
                ['formData' => $formData],
            );
        }

        return new Response($content);
    }

    protected function renderPreview(string $view, array $parameters = []): string
    {
        $parameters['previewParentTemplate'] = $view;
        $parameters['previewContentReplacer'] = Preview::CONTENT_REPLACER;

        return $this->renderView('@SuluWebsite/Preview/preview.html.twig', $parameters);
    }

    protected function renderBlockView(string $template, string $block, array $attributes = []): string
    {
        $attributes = $this->twig->mergeGlobals($attributes);
        $twigTemplate = $this->twig->load($template);

        return $twigTemplate->renderBlock($block, $attributes);
    }

    private function resolveTemplatePath(FormData $formData): string
    {
        $category = $formData->getCategory();

        if (null === $category || '' === $category) {
            return self::DEFAULT_TEMPLATE;
        }

        $categoryTemplate = 'form/preview/' . $category . '.html.twig';

        if ($this->twig->getLoader()->exists($categoryTemplate)) {
            return $categoryTemplate;
        }

        return self::DEFAULT_TEMPLATE;
    }
}
