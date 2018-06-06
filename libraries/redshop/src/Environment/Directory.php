<?php
/**
 * @package     RedShop
 * @subpackage  Helper
 *
 * @copyright   Copyright (C) 2008 - 2017 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Redshop\Environment;

defined('_JEXEC') or die;

/**
 * @package     Redshop\Environment
 *
 * @since       2.1.0
 */
class Directory extends \JFolder
{
	/**
	 * @param   string $path Directory path
	 *
	 * @return  boolean
	 *
	 * @since   2.1.0
	 */
	public static function create($path)
	{
		if (self::exists($path))
		{
			return true;
		}

		if (!self::create($path))
		{
			return false;
		}

		if (!\JFile::exists($path . '/index.html'))
		{
			// Avoid 'pass by reference' error in J1.6+
			$content = '<html><body bgcolor="#ffffff"></body></html>';

			return \JFile::write($path . '/index.html', $content);
		}

		return true;
	}

	/**
	 * @param   string $dir Directory
	 *
	 * @return  array
	 *
	 * @since   2.1.0
	 */
	public static function count($dir)
	{
		$totalFile = 0;
		$totalDir  = 0;

		if (!is_dir($dir))
		{
			return array($totalFile, $totalDir);
		}

		$d = dir($dir);

		while (false !== ($entry = $d->read()))
		{
			if (substr($entry, 0, 1) != '.' && JFile::exists($dir . DIRECTORY_SEPARATOR . $entry)
				&& strpos($entry, '.html') === false && strpos($entry, '.php') === false
			)
			{
				$totalFile++;
			}

			if (substr($entry, 0, 1) != '.' && is_dir($dir . DIRECTORY_SEPARATOR . $entry))
			{
				$totalDir++;
			}
		}

		$d->close();

		return array($totalFile, $totalDir);
	}
}
