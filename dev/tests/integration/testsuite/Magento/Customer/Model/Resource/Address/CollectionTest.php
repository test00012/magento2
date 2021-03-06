<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */

/**
 * Tests for customer addresses collection
 */
namespace Magento\Customer\Model\Resource\Address;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testSetCustomerFilter()
    {
        $collection = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Customer\Model\Resource\Address\Collection'
        );
        $select = $collection->getSelect();
        $this->assertSame($collection, $collection->setCustomerFilter([1, 2]));
        $customer = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Customer\Model\Customer'
        );
        $collection->setCustomerFilter($customer);
        $customer->setId(3);
        $collection->setCustomerFilter($customer);
        $this->assertStringMatchesFormat(
            '%AWHERE%S(%Sparent_id%S IN(%S1%S, %S2%S))%SAND%S(%Sparent_id%S = %S-1%S)%SAND%S(%Sparent_id%S = %S3%S)%A',
            (string)$select
        );
    }
}
