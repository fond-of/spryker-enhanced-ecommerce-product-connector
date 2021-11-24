<?php

namespace FondOfSpryker\Yves\EnhancedEcommerceProductConnector\Renderer;

use Codeception\Test\Unit;
use FondOfSpryker\Yves\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorConfig;
use Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface;

class ProductDetailRendererTest extends Unit
{
    /**
     * @var \FondOfSpryker\Yves\EnhancedEcommerceProductConnector\Renderer\ProductDetailRenderer
     */
    protected $renderer;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface
     */
    protected $moneyPluginMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Yves\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorConfig
     */
    protected $configMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->moneyPluginMock = $this->getMockBuilder(MoneyPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(EnhancedEcommerceProductConnectorConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->renderer = new ProductDetailRenderer($this->moneyPluginMock, $this->configMock);
    }

    /**
     * @return void
     */
    public function testGetTemplate(): void
    {
        static::assertEquals(
            '@EnhancedEcommerceProductConnector/partials/product-detail.js.twig',
            $this->renderer->getTemplate()
        );
    }
}
