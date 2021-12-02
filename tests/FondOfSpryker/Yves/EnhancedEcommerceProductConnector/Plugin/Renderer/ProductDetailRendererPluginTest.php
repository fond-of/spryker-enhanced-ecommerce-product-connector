<?php

namespace FondOfSpryker\Yves\EnhancedEcommerceProductConnector\Plugin\Renderer;

use Codeception\Test\Unit;
use FondOfSpryker\Shared\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorConstants;
use FondOfSpryker\Yves\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorFactory;
use FondOfSpryker\Yves\EnhancedEcommerceProductConnector\Renderer\ProductDetailRenderer;
use Generated\Shared\Transfer\ProductViewTransfer;
use Twig\Environment;

class ProductDetailRendererPluginTest extends Unit
{
    /**
     * @var \FondOfSpryker\Yves\EnhancedEcommerceProductConnector\Plugin\Renderer\ProductDetailRendererPlugin
     */
    protected $plugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Yves\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorFactory
     */
    protected $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Yves\EnhancedEcommerceProductConnector\Renderer\ProductDetailRenderer
     */
    protected $rendererMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Twig\Environment
     */
    protected $twigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductViewTransfer
     */
    protected $productViewTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(EnhancedEcommerceProductConnectorFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->rendererMock = $this->getMockBuilder(ProductDetailRenderer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->twigMock = $this->getMockBuilder(Environment::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productViewTransferMock = $this->getMockBuilder(ProductViewTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ProductDetailRendererPlugin();
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testIsApplicableSuccess(): void
    {
        static::assertEquals(true, $this->plugin->isApplicable(
            EnhancedEcommerceProductConnectorConstants::PAGE_TYPE,
            [
                EnhancedEcommerceProductConnectorConstants::PARAM_PRODUCT => $this->productViewTransferMock,
            ]
        ));
    }

    /**
     * @return void
     */
    public function testIsApplicableFailed(): void
    {
        static::assertEquals(false, $this->plugin->isApplicable(
            EnhancedEcommerceProductConnectorConstants::PAGE_TYPE,
            [
                EnhancedEcommerceProductConnectorConstants::PARAM_PRODUCT => null,
            ]
        ));
    }

    /**
     * @return void
     */
    public function testRender(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createProductDetailRenderer')
            ->willReturn($this->rendererMock);

        $this->rendererMock->expects(static::atLeastOnce())
            ->method('render')
            ->with(
                $this->twigMock,
                EnhancedEcommerceProductConnectorConstants::PAGE_TYPE,
                [EnhancedEcommerceProductConnectorConstants::PARAM_PRODUCT => $this->productViewTransferMock]
            )
            ->willReturn('string');

        $response = $this->plugin->render(
            $this->twigMock,
            EnhancedEcommerceProductConnectorConstants::PAGE_TYPE,
            [EnhancedEcommerceProductConnectorConstants::PARAM_PRODUCT => $this->productViewTransferMock]
        );

        static::assertIsString($response);
        static::assertEquals('string', $response);
    }
}
