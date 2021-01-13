<?php

namespace FondOfSpryker\Yves\EnhancedEcommerceProductConnector;

use FondOfSpryker\Yves\EnhancedEcommerceExtension\Dependency\EnhancedEcommerceDataLayerExpanderInterface;
use FondOfSpryker\Yves\EnhancedEcommerceProductConnector\Expander\ProductDataLayerExpander;
use Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface;
use Spryker\Yves\Kernel\AbstractFactory;

/**
 * @method \FondOfSpryker\Yves\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorConfig getConfig()
 */
class EnhancedEcommerceProductConnectorFactory extends AbstractFactory
{
    /**
     * @return \FondOfSpryker\Yves\EnhancedEcommerceExtension\Dependency\EnhancedEcommerceDataLayerExpanderInterface
     */
    public function createProductDataLayerExpander(): EnhancedEcommerceDataLayerExpanderInterface
    {
        return new ProductDataLayerExpander($this->getMoneyPlugin(), $this->getConfig());
    }

    /**
     * @return \Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface
     */
    public function getMoneyPlugin(): MoneyPluginInterface
    {
        return $this->getProvidedDependency(EnhancedEcommerceProductConnectorDependencyProvider::PLUGIN_MONEY);
    }
}
