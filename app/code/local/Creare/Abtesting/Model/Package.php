<?php

class Creare_Abtesting_Model_Package extends Mage_Core_Model_Design_Package
{
    public function getTheme($type)
    {
        if (empty($this->_theme[$type])) {
            $this->_theme[$type] = Mage::getStoreConfig('design/theme/' . $type, $this->getStore());
            if ($type !== 'default' && empty($this->_theme[$type])) {
                $this->_theme[$type] = $this->getTheme('default');
                if (empty($this->_theme[$type])) {
                    $this->_theme[$type] = self::DEFAULT_THEME;
                }

                // "locale", "layout", "template"
            }
        }

        // + "default", "skin"

        // set exception value for theme, if defined in config
        $customThemeType = $this->_checkUserAgentAgainstRegexps("design/theme/{$type}_ua_regexp");
        if ($customThemeType) {
            $this->_theme[$type] = $customThemeType;
        }

        /* Our cookie code */

        $cookie = Mage::getModel('core/cookie')->get('abtesting');
        $temp = Mage::getSingleton('core/session')->getAbTesting();

        if (Mage::getStoreConfig('abtesting/accounts/active')) {
            if (!Mage::getSingleton('core/session')->getAbTestingTheme()) {
                $replace = Mage::getSingleton('core/design_package')->getPackageName() . "/";
                if (!$cookie) {
                    $test = (mt_rand(0,1)==0) ? "a":"b";
                    Mage::getModel('core/cookie')->set('abtesting', $test);
                    Mage::getSingleton('core/session')->setAbTesting('yes'); // temporarily set this to yes - so as not to double up this code
                    if ($test == "a") {
                        $code = Mage::getStoreConfig('abtesting/accounts/acode');
                        Mage::getSingleton('core/session')->setAbTest('a');
                        if ($code && !empty($code)) {
                            $this->_theme[$type] = str_replace($replace, "", Mage::getStoreConfig('abtesting/accounts/adesign'));
                        }
                    } else {
                        $code = Mage::getStoreConfig('abtesting/accounts/bcode');
                        Mage::getSingleton('core/session')->setAbTest('b');
                        if ($code && !empty($code)) {
                            $this->_theme[$type] = str_replace($replace, "", Mage::getStoreConfig('abtesting/accounts/bdesign'));
                        }
                    }
                } else {
                    $test = $cookie;
                    if ($test == "a") {
                        $code = Mage::getStoreConfig('abtesting/accounts/acode');
                        if ($code && !empty($code)) {
                            $this->_theme[$type] = str_replace($replace, "", Mage::getStoreConfig('abtesting/accounts/adesign'));
                        }
                    } else {
                        $code = Mage::getStoreConfig('abtesting/accounts/bcode');
                        if ($code && !empty($code)) {
                            $this->_theme[$type] = str_replace($replace, "", Mage::getStoreConfig('abtesting/accounts/bdesign'));
                        }
                    }
                }
                Mage::getSingleton('core/session')->setAbTestingTheme($this->_theme[$type]);
            } else {
                $this->_theme[$type] = Mage::getSingleton('core/session')->getAbTestingTheme();
            }
        }

        /* end our cookie code */

        return $this->_theme[$type];
    }

}
