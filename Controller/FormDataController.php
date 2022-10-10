<?php

namespace Alengo\Bundle\AlengoFormBundle\Controller;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Sulu\Bundle\PreviewBundle\Preview\Preview;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class FormDataController extends AbstractController
{
    #[Route('/form_data', name: 'form_data')]
    public function indexAction(FormData $formData, $attributes = [], $preview = false, $partial = false): Response
    {
        if (!$formData) {
            throw new NotFoundHttpException();
        }

        if ($partial) {
            $content = $this->renderBlock(
                'formData/index.html.twig',
                'content',
                ['formData' => $formData]
            );
        } elseif ($preview) {
            $content = $this->renderPreview(
                'formData/index.html.twig',
                ['formData' => $formData]
            );
        } else {
            $content = $this->renderView(
                'formData/index.html.twig',
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
        $twig = $this->get('twig');
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