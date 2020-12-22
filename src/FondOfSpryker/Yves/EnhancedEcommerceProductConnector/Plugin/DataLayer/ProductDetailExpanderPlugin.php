<?php

namespace FondOfSpryker\Yves\EnhancedEcommerceProductConnector\Plugin\DataLayer;

use FondOfSpryker\Shared\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorInterface;
use FondOfSpryker\Yves\EnhancedEcommerceExtension\Dependency\EnhancedEcommerceDataLayerExpanderPluginInterface;
use Generated\Shared\Transfer\ProductViewTransfer;
use Spryker\Yves\Kernel\AbstractPlugin;

/**
 * @method \FondOfSpryker\Yves\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorFactory getFactory()
 */
class ProductDetailExpanderPlugin extends AbstractPlugin implements EnhancedEcommerceDataLayerExpanderPluginInterface
{
    /**
     * @param string $pageType
     * @param array $twigVariableBag
     *
     * @return bool
     */
    public function isApplicable(string $pageType, array $twigVariableBag = []): bool
    {
        return $pageType === EnhancedEcommerceProductConnectorInterface::PAGE_TYPE
            && isset($twigVariableBag[EnhancedEcommerceProductConnectorInterface::PARAM_PRODUCT])
            && $twigVariableBag[EnhancedEcommerceProductConnectorInterface::PARAM_PRODUCT] instanceof ProductViewTransfer;
    }

    /**
     * @param string $page
     * @param array $twigVariableBag
     * @param array $dataLayer
     *
     * @return array
     */
    public function expand(string $page, array $twigVariableBag, array $dataLayer): array
    {
        return $this->getFactory()
            ->createDataLayerExpander()
            ->expand($page, $twigVariableBag, $dataLayer);
    }
}
