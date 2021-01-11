<?php

namespace FondOfSpryker\Yves\EnhancedEcommerceProductConnector;

use FondOfSpryker\Yves\EnhancedEcommerceExtension\Dependency\EnhancedEcommerceDataLayerExpanderInterface;
use FondOfSpryker\Yves\EnhancedEcommerceProductConnector\Expander\ProductDataLayerExpander;
use FondOfSpryker\Yves\EnhancedEcommerceProductConnector\Expander\DataLayerExpanderInterface;
use Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface;
use Spryker\Yves\Kernel\AbstractFactory;

/**
 * @method EnhancedEcommerceProductConnectorConfig getConfig()
 */
class EnhancedEcommerceProductConnectorFactory extends AbstractFactory
{
    /**
     * @return EnhancedEcommerceDataLayerExpanderInterface
     */
    public function createDataLayerExpander(): EnhancedEcommerceDataLayerExpanderInterface
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
