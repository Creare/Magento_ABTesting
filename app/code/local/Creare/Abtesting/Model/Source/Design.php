<?php

class Creare_Abtesting_Model_Source_Design
{
    public function toOptionArray()
    {
        return Mage::getSingleton('core/design_source_design')->getAllOptions();
    }
}
