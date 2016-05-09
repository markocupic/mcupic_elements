<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace MCupic;


/**
 * Front end content element "service_link".
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class ServiceLink extends \ContentElement
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_servicelink';

    /**
     * Check whether the target page and the article are published
     * @return string
     */
    public function generate()
    {

        if ($this->buttonJumpTo === '')
        {
            return '';
        }

        return parent::generate();

    }


    /**
     * Generate the content element
     */
    protected function compile()
    {
        global $objPage;

        // Clean the RTE output
        if ($objPage->outputFormat == 'xhtml')
        {
            $this->text = \StringUtil::toXhtml($this->text);
        }
        else
        {
            $this->text = \StringUtil::toHtml5($this->text);
        }


        $this->Template->serviceLinkText = \StringUtil::encodeEmail($this->serviceLinkText);
        $this->Template->buttonJumpTo = $this->buttonJumpTo;

    }
}