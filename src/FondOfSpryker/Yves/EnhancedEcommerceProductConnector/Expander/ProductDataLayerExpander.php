<?php

namespace FondOfSpryker\Yves\EnhancedEcommerceProductConnector\Expander;

use FondOfSpryker\Shared\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorConstants as ModuleConstants;
use FondOfSpryker\Yves\EnhancedEcommerceExtension\Dependency\EnhancedEcommerceDataLayerExpanderInterface;
use FondOfSpryker\Yves\EnhancedEcommerceProductConnector\EnhancedEcommerceProductConnectorConfig;
use Generated\Shared\Transfer\EnhancedEcommerceDetailTransfer;
use Generated\Shared\Transfer\EnhancedEcommerceProductTransfer;
use Generated\Shared\Transfer\EnhancedEcommerceTransfer;
use Generated\Shared\Transfer\ProductViewTransfer;
use Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface;

class ProductDataLayerExpander implements EnhancedEcommerceDataLayerExpanderInterface
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
     * @param string $page
     * @param array $twigVariableBag
     * @param array $dataLayer
     *
     * @return array
     */
    public function expand(string $page, array $twigVariableBag, array $dataLayer): array
    {
        $enhancedEcommerceTransfer = (new EnhancedEcommerceTransfer())
            ->setEvent(ModuleConstants::EVENT_NAME)
            ->setEventCategory(ModuleConstants::EVENT_CATEGORY)
            ->setEventAction($page)
            ->setEventLabel($twigVariableBag[ModuleConstants::PARAM_PRODUCT]->getSku())
            ->setEcommerce(['detail' => $this->addDetail($twigVariableBag)->toArray()]);

        return $this->removeEmptyArrayIndex($enhancedEcommerceTransfer->toArray());
    }

    /**
     * @param array $twigVariableBag
     */
    protected function addDetail(array $twigVariableBag): EnhancedEcommerceDetailTransfer
    {
        $enhancedEcommerceDetailTransfer = new EnhancedEcommerceDetailTransfer();
        $enhancedEcommerceDetailTransfer->addProduct($this->getProduct($twigVariableBag[ModuleConstants::PARAM_PRODUCT]));

        return $enhancedEcommerceDetailTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     *
     * @return \Generated\Shared\Transfer\ProductViewTransfer
     */
    protected function getProduct(ProductViewTransfer $productViewTransfer): EnhancedEcommerceProductTransfer
    {
        $enhancedEcommerceProductTranfer = (new EnhancedEcommerceProductTransfer())
            ->setId($productViewTransfer->getSku())
            ->setName($this->getProductName($productViewTransfer))
            ->setVariant($this->getProductAttrStyle($productViewTransfer))
            ->setBrand($this->getBrand($productViewTransfer))
            ->setDimension10($this->getSize($productViewTransfer))
            ->setPrice('' . $this->moneyPlugin->convertIntegerToDecimal($productViewTransfer->getPrice()) . '');

        return $enhancedEcommerceProductTranfer;
    }

    /**
     * @param array $product
     *
     * @return string
     */
    protected function getProductName(ProductViewTransfer $productViewTransfer): string
    {
        $productAttributes = $productViewTransfer->getAttributes();

        if (!$productAttributes || count($productAttributes) === 0) {
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

        if (!$productAttributes || count($productAttributes) === 0) {
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

        if (!$productAttributes || count($productAttributes) === 0) {
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

        if (!$productAttributes || count($productAttributes) === 0) {
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

    /**
     * @param array $haystack
     *
     * @return array
     */
    protected function removeEmptyArrayIndex(array $haystack): array
    {
        foreach ($haystack as $key => $value) {
            if (is_array($value)) {
                $haystack[$key] = $this->removeEmptyArrayIndex($haystack[$key]);
            }

            if (!$value && !in_array($key, $this->config->getDontUnsetArrayIndex())) {
                unset($haystack[$key]);
            }
        }

        return $haystack;
    }
}
