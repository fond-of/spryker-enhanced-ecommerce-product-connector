<?php

namespace FondOfSpryker\Yves\EnhancedEcommerceProductConnector;

use FondOfSpryker\Yves\EnhancedEcommerceProductConnector\Expander\DataLayerExpander;
use FondOfSpryker\Yves\EnhancedEcommerceProductConnector\Expander\DataLayerExpanderInterface;
use Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface;
use Spryker\Yves\Kernel\AbstractFactory;

/**
 * @method EnhancedEcommerceProductConnectorConfig getConfig()
 */
class EnhancedEcommerceProductConnectorFactory extends AbstractFactory
{
    public function createDataLayerExpander(): DataLayerExpanderInterface
    {
        return new DataLayerExpander($this->getMoneyPlugin(), $this->getConfig());
    }

    /**
     * @return \Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface
     */
    public function getMoneyPlugin(): MoneyPluginInterface
    {
        return $this->getProvidedDependency(EnhancedEcommerceProductConnectorDependencyProvider::PLUGIN_MONEY);
    }
}
