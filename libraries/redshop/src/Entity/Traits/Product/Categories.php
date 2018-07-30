<?php
/**
 * @package     Redshop\Entity\Traits\Product
 * @subpackage  Categories
 *
 * @copyright   Copyright (C) 2012 - 2017 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later, see LICENSE.
 */

namespace Redshop\Entity\Traits\Product;

/**
 * Trait Categories
 * @package Redshop\Entity\Traits\Product
 *
 * @since   2.1.0
 */
trait Categories
{
	/**
	 * @var   \RedshopEntitiesCollection  Collections of categories
	 *
	 * @since 2.1.0
	 */
	protected $categories = null;

	/**
	 * @param   boolean $reload Force reload even it's cached
	 *
	 * @return  \RedshopEntitiesCollection
	 *
	 * @since   2.1.0
	 */
	public function getCategories($reload = false)
	{
		if (null === $this->categories || $reload === true)
		{
			$this->loadCategories();
		}

		return $this->categories;
	}

	/**
	 * Method for set categories to this product
	 *
	 * @param   array   $ids            Array of categories' ids
	 * @param   boolean $removeAssigned Remove all assigned categories
	 *
	 * @return  mixed                     A database cursor resource on success, boolean false on failure.
	 * @since   2.1.0
	 */
	public function setCategories($ids, $removeAssigned = false)
	{
		// Merge with assigned categories
		if ($removeAssigned === false)
		{
			$categoryIds = array_merge($this->getCategories()->ids(), $ids);
		}
		else
		{
			// Or just reset it with new ids
			$categoryIds = $ids;
		}

		$categoryIds = array_unique($categoryIds);

		$db = \JFactory::getDbo();

		// Delete old assigned categories
		$query = $db->getQuery(true)
			->delete($db->qn('#__redshop_product_category_xref'))
			->where($db->qn('product_id') . ' = ' . (int) $this->get('product_id'));
		$db->setQuery($query)->execute();

		// Assign new category
		$query->clear()
			->insert($db->qn('#__redshop_product_category_xref'))
			->columns($db->qn(array('category_id', 'product_id')));

		foreach ($categoryIds as $id)
		{
			$query->values((int) $id . ' , ' . (int) $this->get('product_id'));
		}

		if (!$db->setQuery($query)->execute())
		{
			return false;
		}

		// Reload new categories for this product
		$this->loadCategories();

		return true;
	}

	/**
	 * Method for check if this product exist in category.
	 *
	 * @param   integer $id ID of category
	 *
	 * @return  boolean
	 * @since   2.1.0
	 */
	public function inCategory($id)
	{
		return in_array($id, is_array($this->getCategories()->ids()) ? $this->getCategories()->ids() : array());
	}

	/**
	 * Method for load child categories
	 *
	 * @return  self
	 *
	 * @since   2.1.0
	 */
	protected function loadCategories()
	{
		if (!$this->hasId())
		{
			return $this;
		}

		$this->categories = new \RedshopEntitiesCollection;

		$db    = \JFactory::getDbo();
		$query = $db->getQuery(true)
			->select($db->qn('category_id'))
			->from($db->qn('#__redshop_product_category_xref'))
			->where($db->qn('product_id') . ' = ' . (int) $this->getId());

		$results = $db->setQuery($query)->loadColumn();

		if (empty($results))
		{
			return $this;
		}

		foreach ($results as $categoryId)
		{
			$this->categories->add(\RedshopEntityCategory::getInstance($categoryId));
		}

		return $this;
	}
}
