<?php

namespace FondOfSpryker\Yves\EnhancedEcommerceProductConnector;

use FondOfSpryker\Shared\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorConstants;
use Spryker\Yves\Kernel\AbstractBundleConfig;

class EnhancedEcommerceProductConnectorConfig extends AbstractBundleConfig
{
    /**
     * Returns list with array-keys which should not deleted even if they are empty
     *
     * @return array
     */
    public function getDontUnsetArrayIndex(): array
    {
        return $this->get(EnhancedEcommerceProductConnectorConstants::CONFIG_DONT_UNSET_ARRAY_INDEX, [
            'action_field',
        ]);
    }
}
