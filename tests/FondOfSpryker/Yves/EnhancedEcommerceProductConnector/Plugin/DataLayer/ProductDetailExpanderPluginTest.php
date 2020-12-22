<?php

namespace FondOfSpryker\Yves\EnhancedEcommerceProductConnector\Plugin\DataLayer;

use Codeception\Test\Unit;
use FondOfSpryker\Yves\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorFactory;
use FondOfSpryker\Yves\GoogleTagManagerProductConnector\Expander\DataLayerExpanderInterface;

class ProductDetailExpanderPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Yves\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorFactory
     */
    protected $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Yves\EnhancedEcommerceProductConnector\Expander\DataLayerExpanderInterface
     */
    protected $expanderMock;

    /**
     * @var \FondOfSpryker\Yves\EnhancedEcommerceExtension\Dependency\EnhancedEcommerceDataLayerExpanderPluginInterface
     */
    protected $plugin;

    /**
     * @var array
     */
    protected $twigVariableBag;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->factoryMock = $this->getMockBuilder(EnhancedEcommerceProductConnectorFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expanderMock = $this->getMockBuilder(DataLayerExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->twigVariableBag = include codecept_data_dir('twigVariableBag.php');

        $this->plugin = new ProductDetailExpanderPlugin();
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testIsApplicable(): void
    {
        $this->assertEquals(true, $this->plugin->isApplicable('pageType', $this->twigVariableBag));
    }
}
