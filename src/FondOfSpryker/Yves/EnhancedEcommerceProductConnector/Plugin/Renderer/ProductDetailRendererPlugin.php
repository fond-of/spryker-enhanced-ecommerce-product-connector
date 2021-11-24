<?php

namespace FondOfSpryker\Yves\EnhancedEcommerceProductConnector\Plugin\Renderer;

use FondOfSpryker\Shared\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorConstants;
use FondOfSpryker\Yves\EnhancedEcommerceExtension\Dependency\EnhancedEcommerceRenderePluginInterface;
use Generated\Shared\Transfer\ProductViewTransfer;
use Spryker\Yves\Kernel\AbstractPlugin;
use Twig\Environment;

/**
 * @method \FondOfSpryker\Yves\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorFactory getFactory()
 */
class ProductDetailRendererPlugin extends AbstractPlugin implements EnhancedEcommerceRenderePluginInterface
{
    /**
     * @param string $pageType
     * @param array $twigVariableBag
     *
     * @return bool
     */
    public function isApplicable(string $pageType, array $twigVariableBag = []): bool
    {
        return $pageType === EnhancedEcommerceProductConnectorConstants::PAGE_TYPE
            && isset($twigVariableBag[EnhancedEcommerceProductConnectorConstants::PARAM_PRODUCT])
            && $twigVariableBag[EnhancedEcommerceProductConnectorConstants::PARAM_PRODUCT] instanceof ProductViewTransfer;
    }

    /**
     * @param \Twig\Environment $twig
     * @param string $page
     * @param array $twigVariableBag
     *
     * @return string
     */
    public function render(Environment $twig, string $page, array $twigVariableBag): string
    {
        return $this->getFactory()
            ->createProductDetailRenderer()
            ->render($twig, $page, $twigVariableBag);
    }
}
