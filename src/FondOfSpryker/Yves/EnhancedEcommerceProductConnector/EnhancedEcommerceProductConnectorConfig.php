<?php


namespace FondOfSpryker\Yves\EnhancedEcommerceProductConnector;

use Spryker\Yves\Kernel\AbstractBundleConfig;
use FondOfSpryker\Shared\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorInterface;

class EnhancedEcommerceProductConnectorConfig extends AbstractBundleConfig
{
    /**
     * Returns list with array-keys which should not deleted even if they are empty
     *
     * @return array
     */
    public function getDontUnsetArrayIndex(): array
    {
        return $this->get(EnhancedEcommerceProductConnectorInterface::CONFIG_DONT_UNSET_ARRAY_INDEX, [
            'action_field'
        ]);
    }
}
