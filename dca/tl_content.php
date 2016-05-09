<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * @package Gallery Creator
 * @link    http://www.contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


$GLOBALS['TL_DCA']['tl_content']['palettes']['serviceLink'] = 'name,type,headline;{template_legend:hide},customTpl;{icon_legend},faIcon,iconClass;{text_legend},serviceLinkText;{button_legend},buttonText,buttonClass,buttonJumpTo;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['headlineExtended'] = 'name,type,headline;{template_legend:hide},customTpl;{text_legend},text;{button_legend},buttonText,buttonClass,buttonJumpTo;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';


/**
 * Add fields to tl_content
 */

$GLOBALS['TL_DCA']['tl_content']['fields']['layoutClass'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['layoutClass'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => array('maxlength' => 200),
    'sql' => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['iconClass'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['iconClass'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => array('maxlength' => 200),
    'sql' => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['faIcon'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['faIcon'],
    'exclude' => true,
    'search' => true,
    'input_field_callback' => array('ce_serviceLink', 'generatePicker'),
    'inputType' => 'radio',
    'eval' => array('doNotShow' => true),
    'sql' => "varchar(255) NOT NULL default ''"
);


$GLOBALS['TL_DCA']['tl_content']['fields']['buttonClass'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['buttonClass'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => array('maxlength' => 200),
    'sql' => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['serviceLinkText'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['text'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'textarea',
    'eval' => array('mandatory' => false, 'rte' => 'tinyMCE', 'helpwizard' => true),
    'explanation' => 'insertTags',
    'sql' => "mediumtext NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['buttonText'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['buttonText'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => array('maxlength' => 200),
    'sql' => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['iconClass'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['iconClass'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => array('maxlength' => 200),
    'sql' => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['buttonJumpTo'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['buttonJumpTo'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => array('mandatory' => true, 'rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 255, 'fieldType' => 'radio', 'filesOnly' => true, 'tl_class' => 'w50 wizard'),
    'wizard' => array
    (
        array('tl_content', 'pagePicker')
    ),
    'sql' => "varchar(255) NOT NULL default ''"
);


class ce_serviceLink extends Backend
{
    public function __construct()
    {
        parent::__construct();
    }

    public function generatePicker($dc)
    {

        if (Input::post('FORM_SUBMIT'))
        {
            if (Input::post('faIcon') != '')
            {
                $ContentModel = \ContentModel::findByPk($dc->id);
                $ContentModel->faIcon = Input::post('faIcon');
                $ContentModel->save();
            }
        }
        // Load Font Awesome
        $GLOBALS['TL_CSS'][] = "//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css";

        // Build radio-button-list
        $html = '<fieldset id="ctrl_faIcon" class="tl_radio_container">';
        $html .= '<h3><label>Icon picker</label></h3>';

        $html .= '<div id="iconBox" style="border:1px solid #aaa;height:400px;overflow: scroll;">';
        $html .= '<table>';
        $i = 0;
        $m = 0;
        foreach ($GLOBALS['font-awesome-classes'] as $strClass)
        {
            if ($i == 0)
            {
                $html .= '<tr>';
            }
            $checked = $dc->activeRecord->faIcon == $strClass ? ' checked="checked"' : '';
            $cssClass = $dc->activeRecord->faIcon == $strClass ? ' class="checked"' : '';
            $color = $dc->activeRecord->faIcon == $strClass ? 'color:#fff;' : '';
            $bgcolor = $dc->activeRecord->faIcon == $strClass ? 'background-color:#bbb;' : '';

            $html .= '<td style="line-height:2em;padding:5px;' . $bgcolor . $color . '"><input' . $cssClass . ' id="faIcon_' . $m . '" type="radio" name="faIcon" value="' . $strClass . '"' . $checked . '><span class="fa fa-2x ' . $strClass . '"></span> <span>' . $strClass . '</span></td>';

            $i++;
            if ($i == 4)
            {
                $html .= '</tr>';
                $i = 0;
            }
            $m++;
        }
        $html .= '</table>';
        $html .= '</div>';
        $html .= '<p class="tl_help tl_tip" title="">' . $GLOBALS['TL_LANG']['tl_content']['faIcon'][1] . '</p>';

        // Javascript (Mootools)
        $html .= '
        <script>
            window.addEvent("domready", function(event) {
                var myFx = new Fx.Scroll(document.id("iconBox")).toElement( $$("input.checked")[0]);
                $$("#iconBox input").addEvent("click", function(event){
                    $$("#iconBox input").each(function(el){
                        el.removeClass("checked");
                        el.getParent("td").setStyles({
                            "background-color": "inherit",
                            "color": "inherit"
                        });
                    });
                    this.getParent("td").setStyles({
                        "background-color": "#bbb",
                        "color": "#fff"
                    });

                });
            });
        </script>
        ';

        return $html;

    }

}