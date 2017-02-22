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
        $GLOBALS['TL_CSS'][] = "https://maxcdn.bootstrapcdn.com/font-awesome/" . SERVICE_LINK_FONTAWESOME_VERSION. "/css/font-awesome.min.css";
        $arrFaIds = $this->getFaIds();
        // Build radio-button-list
        $html = '<fieldset id="ctrl_faIcon" class="tl_radio_container">';
        $html .= '<h3><label>Icon picker</label></h3>';

        $html .= '<div id="iconBox" style="border:1px solid #aaa;height:600px;overflow: scroll;">';
        $html .= '<div style="position:relative;display:flex;flex-wrap:wrap">';
        $i = 0;
        foreach ($arrFaIds as $strClass)
        {
            $checked = $cssClass = $color = $bgcolor = '';
            if($dc->activeRecord->faIcon == 'fa-' . $strClass)
            {
                $checked = ' checked="checked"';
                $cssClass = ' class="checked"';
                $color = 'color:#fff;';
                $bgcolor = 'background-color:#ebfdd7;';
            }

            $html .= '<div style="width:22%;line-height:2em;padding:5px;' . $bgcolor . $color . '" title="fa-' . $strClass . '" class="font-awesome-icon-item" data-faClass="fa-' . $strClass . '"><input' . $cssClass . ' id="faIcon_' . $i . '" type="radio" name="faIcon" style="display:inline-block;margin-right:4px;" value="fa-' . $strClass . '"' . $checked . '><span style="display:inline-block; color:#333;" class="fa fa-2x fa-fw ' . 'fa-' . $strClass . '"></span> <div style="display:inline-block;margin-left:4px;">' . StringUtil::substr($strClass, 15) . '</div></div>';

            $i++;
        }
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<p class="tl_help tl_tip" title="">' . $GLOBALS['TL_LANG']['tl_content']['faIcon'][1] . '</p>';

        // Javascript (Mootools)
        $html .= '
        <script>
            window.addEvent("domready", function(event) {
                if($$("input.checked").length){
                    // Scroll to selected icon
                    var myFx = new Fx.Scroll(document.id("iconBox")).toElement($$("input.checked")[0]);
                }
                $$("#iconBox input").addEvent("click", function(event){
                    $$("#iconBox input").each(function(el){
                        el.removeClass("checked");
                        el.getParent("div").setStyles({
                            "background-color": "inherit",
                            "color": "inherit"
                        });
                    });
                    this.getParent("div").setStyles({
                        "background-color": "#ebfdd7"
                    });
                });

                // Creating the filter input
                var filterInput = new Element("input", {
                    "type": "text",
                    "placeholder": "filter",
                    "class": "tl_text fa-class-filter",
                    id: "faClassFilter",
                    events: {
                        input: function(){
                            var strFilter = this.getProperty("value").trim(" ");
                            var itemCollection = $$(".font-awesome-icon-item");
                            itemCollection.each(function(el){
                                el.setStyle("display","block");
                                if(strFilter != "")
                                {
                                    if(el.getProperty("data-faClass").contains(strFilter) === false)
                                    {
                                        el.setStyle("display","none");
                                    }
                                }
                            });
                        }
                    }
                });
                // Add a label
                filterInput.inject("ctrl_faIcon", "before");
                var elLabel = Elements.from("<label><h3>' . $GLOBALS['TL_LANG']['tl_content']['faIconFilter'] . '</h3></label>");
                elLabel.inject("faClassFilter", "before");


            });
        </script>
        ';

        return $html;

    }

    /**
     * Get all FontAwesomeClasses as array from icons.yml
     * Download this file at:
     * https://raw.githubusercontent.com/FortAwesome/Font-Awesome/v4.7.0/src/3.2.1/icons.yml
     * @return array
     */
    protected function getFaIds()
    {
        $ymlFileSRC = dirname(__DIR__) . '/yml/icons.yml';
        $strYml = file_get_contents($ymlFileSRC);
        $pattern = '/id:([\s]*)(.*)([\s]*)/';
        if(preg_match_all ($pattern, $strYml, $matches))
        {
            return $matches[2];
        }
        return array();

    }

}