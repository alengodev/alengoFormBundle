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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FormDataController extends AbstractController
{
    public function indexAction(FormData $formData, $attributes = [], $preview = false, $partial = false): Response
    {
        if (!$formData->getCategory()) {
            $templatePath = '@AlengoForm/FormData/default.html.twig';
        } else {
            $templatePath = '/form/preview/'.$formData->getCategory().'.html.twig';
        }

        if (!$formData) {
            throw new NotFoundHttpException();
        }

        if ($partial) {
            $content = $this->renderBlock(
                $templatePath,
                'content',
                ['formData' => $formData]
            );
        } elseif ($preview) {
            $content = $this->renderPreview(
                $templatePath,
                ['formData' => $formData]
            );
        } else {
            $content = $this->renderView(
                $templatePath,
                ['formData' => $formData]
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

    /**
     * Returns rendered part of template specified by block.
     *
     * @param mixed $template
     * @param mixed $block
     * @param mixed $attributes
     */
    protected function renderBlock($template, $block, $attributes = [])
    {
        $twig = $this->container->get('twig');
        $attributes = $twig->mergeGlobals($attributes);

        $template = $twig->load($template);

        $level = ob_get_level();
        ob_start();

        try {
            $rendered = $template->renderBlock($block, $attributes);
            ob_end_clean();

            return $rendered;
        } catch (\Exception $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }

            throw $e;
        }
    }
}
