<?php
/**
 * Lesti_Fpc (http:gordonlesti.com/lestifpc)
 *
 * PHP version 5
 *
 * @link      https://github.com/GordonLesti/Lesti_Fpc
 * @package   Lesti_Fpc
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright Copyright (c) 2013-2016 Gordon Lesti (http://gordonlesti.com)
 * @license   http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

/**
 * Class Lesti_Fpc_Test_TestCase
 */
abstract class Lesti_Fpc_Test_TestCase extends EcomDev_PHPUnit_Test_Case_Controller
{
    protected Lesti_Fpc_Model_Fpc $_fpc;
    /** @var array|false */
    protected $_cacheOptions;
    protected Mage_Core_Model_Cache $_cache;

    protected function setUp(): void
    {
        parent::setUp();
        $this->_fpc = Mage::getSingleton('fpc/fpc');
        $this->_fpc->clean();
        // disable all caches expected fpc
        $this->_cache = Mage::app()->getCacheInstance();
        $this->_cacheOptions = Mage::getResourceSingleton('core/cache')
            ->getAllOptions();
        $cacheOptions = $this->_cacheOptions;
        foreach (array_keys($cacheOptions) as $cache) {
            $cacheOptions[$cache] = $cache == 'fpc' ? 1 : 0;
        }
        if (!array_key_exists('fpc', $cacheOptions)) {
            $cacheOptions['fpc'] = 1;
        }
        $this->_cache->saveOptions($cacheOptions);
        $cacheReflector = new ReflectionClass(Mage_Core_Model_Cache::class);
        $initOptionsMethod = $cacheReflector->getMethod('_initOptions');
        $initOptionsMethod->setAccessible(true);
        $initOptionsMethod->invokeArgs($this->_cache, array());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->_cache->saveOptions($this->_cacheOptions);
        // unregister fpc
        Mage::unregister('_singleton/fpc/fpc');
        Mage::getSingleton('customer/session')->logout();
    }

    protected function clearBaseUrlProperty()
    {
        $storeReflector = new ReflectionClass(Mage_Core_Model_Store::class);
        $baseUrlCacheProperty = $storeReflector->getProperty('_baseUrlCache');
        $baseUrlCacheProperty->setAccessible(true);
        $baseUrlCacheProperty->setValue(Mage::app()->getStore(), array());
    }

    protected function setFullActionName(string $routeName, string $controllerName, string $actionName)
    {
        Mage::app()->getRequest()->setRouteName($routeName);
        Mage::app()->getRequest()->setControllerName($controllerName);
        Mage::app()->getRequest()->setActionName($actionName);
    }
}
