<?php

class Magentowizard_Breadcrumbs_Model_Observer extends Mage_Core_Model_Observer
{
    public function addCategoryToBreadcrumbs(Varien_Event_Observer $observer)
    {
        if (Mage::registry('current_category')) {
            return;
        }

        $product = $observer->getProduct();

        $product->setDoNotUseCategoryId(false);
        $categoryIds = $product->getCategoryIds();

        if (count($categoryIds)) {
            $categories = Mage::getModel('catalog/category')->getCollection()
                ->addAttributeToFilter('entity_id', $categoryIds)
                ->addAttributeToFilter('is_active', 1);

            $categories->getSelect()->order('level DESC')->limit(1);

            Mage::register('current_category', $categories->getFirstItem());
        }
    }
}