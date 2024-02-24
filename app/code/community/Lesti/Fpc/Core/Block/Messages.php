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

class Lesti_Fpc_Core_Block_Messages extends Mage_Core_Block_Messages
{
    public function getGroupedHtml(): string
    {
        $html = parent::getGroupedHtml();

        // Use single transport object instance for all blocks
        $transportObject = new Varien_Object();
        $transportObject->setHtml($html);
        Mage::dispatchEvent(
            'core_block_messages_get_grouped_html_after',
            ['block' => $this, 'transport' => $transportObject],
        );

        return $transportObject->getHtml();
    }
}