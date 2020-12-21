<?php

namespace FondOfSpryker\Yves\EnhancedEcommerceProductConnector;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;

class EnhancedEcommerceProductConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @param Container $container
     *
     * @return Container
     */
    public function provideDependencies(Container $container): Container
    {
        return parent::provideDependencies($container);
    }
}
