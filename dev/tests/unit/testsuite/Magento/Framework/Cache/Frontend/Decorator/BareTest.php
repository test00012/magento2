<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */
namespace Magento\Framework\Cache\Frontend\Decorator;

class BareTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $method
     * @param array $params
     * @param mixed $expectedResult
     * @dataProvider proxyMethodDataProvider
     */
    public function testProxyMethod($method, $params, $expectedResult)
    {
        $frontendMock = $this->getMock('Magento\Framework\Cache\FrontendInterface');

        $object = new \Magento\Framework\Cache\Frontend\Decorator\Bare($frontendMock);
        $helper = new \Magento\TestFramework\Helper\ProxyTesting();
        $result = $helper->invokeWithExpectations($object, $frontendMock, $method, $params, $expectedResult);
        $this->assertSame($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function proxyMethodDataProvider()
    {
        return [
            ['test', ['record_id'], 111],
            ['load', ['record_id'], '111'],
            ['save', ['record_value', 'record_id', ['tag'], 555], true],
            ['remove', ['record_id'], true],
            ['clean', [\Zend_Cache::CLEANING_MODE_MATCHING_ANY_TAG, ['tag']], true],
            ['getBackend', [], $this->getMock('Zend_Cache_Backend')],
            ['getLowLevelFrontend', [], $this->getMock('Zend_Cache_Core')]
        ];
    }
}
