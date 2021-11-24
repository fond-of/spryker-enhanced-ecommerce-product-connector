<?php

namespace FondOfSpryker\Yves\EnhancedEcommerceProductConnector\Renderer;

use FondOfSpryker\Shared\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorConstants as ModuleConstants;
use FondOfSpryker\Yves\EnhancedEcommerceExtension\Dependency\EnhancedEcommerceRendererInterface;
use FondOfSpryker\Yves\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorConfig;
use Generated\Shared\Transfer\EnhancedEcommerceProductTransfer;
use Generated\Shared\Transfer\EnhancedEcommerceTransfer;
use Generated\Shared\Transfer\ProductViewTransfer;
use Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface;
use Twig\Environment;

class ProductDetailRenderer implements EnhancedEcommerceRendererInterface
{
    /**
     * @var \Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface
     */
    protected $moneyPlugin;

    /**
     * @var \FondOfSpryker\Yves\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorConfig
     */
    protected $config;

    /**
     * @param \Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface $moneyPlugin
     * @param \FondOfSpryker\Yves\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorConfig $config
     */
    public function __construct(
        MoneyPluginInterface $moneyPlugin,
        EnhancedEcommerceProductConnectorConfig $config
    ) {
        $this->moneyPlugin = $moneyPlugin;
        $this->config = $config;
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
        $enhancedEcommerceTransfer = (new EnhancedEcommerceTransfer())
            ->setEvent(ModuleConstants::EVENT_NAME)
            ->setEventCategory(ModuleConstants::EVENT_CATEGORY)
            ->setEventAction($page)
            ->setEventLabel($twigVariableBag[ModuleConstants::PARAM_PRODUCT]->getSku())
            ->setEcommerceName('detail')
            ->addProduct($this->getProduct($twigVariableBag[ModuleConstants::PARAM_PRODUCT]));

        return $twig->render($this->getTemplate(), [
            'data' => $enhancedEcommerceTransfer->toArray(true, true),
        ]);
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return '@EnhancedEcommerceProductConnector/partials/product-detail.js.twig';
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     *
     * @return \Generated\Shared\Transfer\EnhancedEcommerceProductTransfer
     */
    protected function getProduct(ProductViewTransfer $productViewTransfer): EnhancedEcommerceProductTransfer
    {
        return (new EnhancedEcommerceProductTransfer())
            ->setId($productViewTransfer->getSku())
            ->setName($this->getProductName($productViewTransfer))
            ->setVariant($this->getProductAttrStyle($productViewTransfer))
            ->setBrand($this->getBrand($productViewTransfer))
            ->setDimension10($this->getSize($productViewTransfer))
            ->setPrice('' . $this->moneyPlugin->convertIntegerToDecimal($productViewTransfer->getPrice()) . '');
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     *
     * @return string
     */
    protected function getProductName(ProductViewTransfer $productViewTransfer): string
    {
        $productAttributes = $productViewTransfer->getAttributes();

        if (count($productAttributes) < 1) {
            return '';
        }

        if (isset($productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_MODEL_UNTRANSLATED])) {
            return $productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_MODEL_UNTRANSLATED];
        }

        if (isset($productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_MODEL])) {
            return $productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_MODEL];
        }

        return $productViewTransfer->getName();
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     *
     * @return string
     */
    protected function getProductAttrStyle(ProductViewTransfer $productViewTransfer): string
    {
        $productAttributes = $productViewTransfer->getAttributes();

        if (count($productAttributes) < 1) {
            return '';
        }

        if (isset($productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_STYLE_UNTRANSLATED])) {
            return $productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_STYLE_UNTRANSLATED];
        }

        if (isset($productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_STYLE])) {
            return $productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_STYLE];
        }

        return '';
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     *
     * @return string
     */
    protected function getBrand(ProductViewTransfer $productViewTransfer): string
    {
        $productAttributes = $productViewTransfer->getAttributes();

        if (count($productAttributes) < 1) {
            return '';
        }

        if (isset($productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_BRAND])) {
            return $productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_BRAND];
        }

        return '';
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     *
     * @return string
     */
    protected function getSize(ProductViewTransfer $productViewTransfer): string
    {
        $productAttributes = $productViewTransfer->getAttributes();

        if (count($productAttributes) < 1) {
            return '';
        }

        if (isset($productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_SIZE_UNTRANSLATED])) {
            return $productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_SIZE_UNTRANSLATED];
        }

        if (isset($productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_SIZE])) {
            return $productAttributes[ModuleConstants::PARAM_PRODUCT_ATTR_SIZE];
        }

        return '';
    }
}
