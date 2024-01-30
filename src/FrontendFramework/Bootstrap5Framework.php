<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBootstrap5Bundle\FrontendFramework;

use HeimrichHannot\TwigTemplatesBundle\Event\BeforeRenderCallback;
use HeimrichHannot\TwigTemplatesBundle\Event\PrepareTemplateCallback;
use HeimrichHannot\TwigTemplatesBundle\FrontendFramework\FrontendFrameworkInterface;
use HeimrichHannot\UtilsBundle\Util\Utils;

class Bootstrap5Framework implements FrontendFrameworkInterface
{
    private Utils $utils;

    /**
     * Bootstrap5Framework constructor.
     */
    public function __construct(Utils $utils)
    {
        $this->utils = $utils;
    }

    public static function getIdentifier(): string
    {
        return 'bs5';
    }

    public function prepare(PrepareTemplateCallback $callback): PrepareTemplateCallback
    {
        $templateName = $callback->getTemplateName();
        $templateData = $callback->getData();
        $this->prepareAccordions($templateName, $templateData);
        $callback->setData($templateData);

        return $callback;
    }

    public function beforeRender(BeforeRenderCallback $callback): BeforeRenderCallback
    {
        return $callback;
    }

    public static function getLabel(): string
    {
        return 'huh.twig.templates.framework.'.static::getIdentifier();
    }

    protected function prepareAccordions(string &$templateName, array &$data)
    {
        if (str_starts_with($templateName, 'ce_accordionSingle')) {
            $this->utils->accordion()->structureAccordionSingle($data);
        } elseif (str_starts_with($templateName, 'ce_accordionStart') || str_starts_with($templateName, 'ce_accordionStop')) {
            $this->utils->accordion()->structureAccordionStartStop($data);
        }
    }
}
