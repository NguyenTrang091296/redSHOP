<?php
/**
 * @package     redSHOP
 * @subpackage  Models
 *
 * @copyright   Copyright (C) 2008 - 2012 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class integrationModelintegration extends JModel
{
    function __construct()
    {
        parent::__construct();
    }

    /*
      *  download googlebase xml file
      */
    function gbasedownload()
    {
        $file_path = JPATH_COMPONENT_SITE . DS . "assets" . DS . "document" . DS . "gbase" . DS . "product.xml";
        if (!file_exists($file_path))
        {
            return false;
        }

        $xml_code = implode("", file($file_path));

        header("Content-Type: application/rss+xml");
        header('Content-Encoding: UTF-8');
        header('Content-Disposition: attachment; filename="product.xml"');
        echo  $xml_code;
        exit;
    }
}
