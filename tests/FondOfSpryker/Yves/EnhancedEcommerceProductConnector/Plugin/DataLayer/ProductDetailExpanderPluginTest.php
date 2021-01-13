<?php

namespace FondOfSpryker\Yves\EnhancedEcommerceProductConnector\Plugin\DataLayer;

use Codeception\Test\Unit;
use FondOfSpryker\Shared\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorConstants;
use FondOfSpryker\Yves\EnhancedEcommerceExtension\Dependency\EnhancedEcommerceDataLayerExpanderInterface;
use FondOfSpryker\Yves\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorFactory;
use Generated\Shared\Transfer\ProductViewTransfer;

class ProductDetailExpanderPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Yves\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorFactory
     */
    protected $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Yves\EnhancedEcommerceExtension\Dependency\EnhancedEcommerceDataLayerExpanderInterface
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
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductViewTransfer
     */
    protected $productViewTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->factoryMock = $this->getMockBuilder(EnhancedEcommerceProductConnectorFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expanderMock = $this->getMockBuilder(EnhancedEcommerceDataLayerExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productViewTransferMock = $this->getMockBuilder(ProductViewTransfer::class)
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
        $this->assertEquals(true, $this->plugin->isApplicable(EnhancedEcommerceProductConnectorConstants::PAGE_TYPE, [
            EnhancedEcommerceProductConnectorConstants::PARAM_PRODUCT => $this->productViewTransferMock,
        ]));
    }

    /**
     * @return void
     */
    public function testExpand()
    {
        $this->factoryMock->expects($this->atLeastOnce())
            ->method('createProductDataLayerExpander')
            ->willReturn($this->expanderMock);

        $this->expanderMock->expects($this->atLeastOnce())
            ->method('expand');

        $this->plugin->expand(
            EnhancedEcommerceProductConnectorConstants::PAGE_TYPE,
            $this->twigVariableBag,
            []
        );
    }
}
