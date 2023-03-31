<?php

class Magentowizard_Breadcrumbs_Model_Observer extends Mage_Core_Model_Observer
{
    public function addCategoryToBreadcrumbs(Varien_Event_Observer $observer)
    {
        if (Mage::registry('current_category')) {
            return;
        }

        $product = $observer->getProduct();
        $categoryIds = $product->getCategoryIds();

        if (!empty($categoryIds)) {
            $categories = Mage::getModel('catalog/category')->getCollection()
                ->addAttributeToFilter('entity_id', $categoryIds)
                ->addAttributeToFilter('is_active', 1)
                ->addAttributeToSort('level', 'DESC')
                ->setPageSize(1)
                ->getFirstItem();

            Mage::register('current_category', $categories);
        }
    }
}
