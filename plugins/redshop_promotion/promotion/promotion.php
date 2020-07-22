<?php
/**
 * @package     redSHOP
 * @subpackage  Plugin
 *
 * @copyright   Copyright (C) 2008 - 2020 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

/**
 * Plugin Redshop_PromotionPromotion
 *
 * @since __DEPLOY_VERSION__
 */
class PlgRedshop_PromotionPromotion extends JPlugin
{
    protected $db;
    protected $app;
    protected $query;
    protected $form;
    protected $layoutFolder;

    /**
     * Constructor
     *
     * @param   object  $subject  The object to observe
     * @param   array   $config   An array that holds the plugin configuration
     *
     * @since    __DEPLOY_VERSION__
     */
    public function __construct(&$subject, $config)
    {
        parent::__construct($subject, $config);

        $this->loadLanguage();
        $this->app = JFactory::getApplication();
        $this->db = JFactory::getDbo();
        $this->query = $this->db->getQuery(true);
        $this->layoutFolder = JPATH_PLUGINS . '/' . $this->_type . '/' . $this->_name . '/layouts';
        $this->form = JForm::getInstance("promotions", __DIR__ . "/forms/promotion.xml", []);
    }

    public function onSavePromotion() {

    }

    public function onLoadPromotion() {

    }

    public function onDeletePromotion() {

    }

    /**
     * @return string
     * @since __DEPLOY_VERSION__
     */
    public function onRenderBackEndLayoutConditions() {
        $layout = new JLayoutFile('conditions', $this->layoutFolder);
        return $layout->render(['form' => $this->form]);
    }

    /**
     * @return string
     * @since __DEPLOY_VERSION__
     */
    public function onRenderBackEndLayoutAwards() {
        $layout = new JLayoutFile('awards', $this->layoutFolder);
        return $layout->render(['form' => $this->form]);
    }
}