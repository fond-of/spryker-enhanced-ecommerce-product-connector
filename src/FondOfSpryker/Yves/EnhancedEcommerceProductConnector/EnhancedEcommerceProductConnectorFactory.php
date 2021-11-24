<?php

namespace FondOfSpryker\Yves\EnhancedEcommerceProductConnector;

use FondOfSpryker\Yves\EnhancedEcommerceExtension\Dependency\EnhancedEcommerceRendererInterface;
use FondOfSpryker\Yves\EnhancedEcommerceProductConnector\Renderer\ProductDetailRenderer;
use Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface;
use Spryker\Yves\Kernel\AbstractFactory;

/**
 * @method \FondOfSpryker\Yves\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorConfig getConfig()
 */
class EnhancedEcommerceProductConnectorFactory extends AbstractFactory
{
    /**
     * @return \FondOfSpryker\Yves\EnhancedEcommerceExtension\Dependency\EnhancedEcommerceRendererInterface
     */
    public function createProductDetailRenderer(): EnhancedEcommerceRendererInterface
    {
        return new ProductDetailRenderer($this->getMoneyPlugin(), $this->getConfig());
    }

    /**
     * @return \Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface
     */
    public function getMoneyPlugin(): MoneyPluginInterface
    {
        return $this->getProvidedDependency(EnhancedEcommerceProductConnectorDependencyProvider::PLUGIN_MONEY);
    }
}
