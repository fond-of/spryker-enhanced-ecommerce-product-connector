<?php

namespace FondOfSpryker\Shared\EnhancedEcommerceProductConnector;

interface EnhancedEcommerceProductConnectorInterface
{
    public const PAGE_TYPE = 'productDetail';

    public const EVENT_NAME = 'genericEvent';
    public const EVENT_CATEGORY = 'ecommerce';

    public const PARAM_PRODUCT = 'product';
    public const PARAM_PRODUCT_ATTR_STYLE_UNTRANSLATED = 'style_untranslated';
    public const PARAM_PRODUCT_ATTR_STYLE = 'style';
    public const PARAM_PRODUCT_ATTR_SIZE_UNTRANSLATED = 'size_untranslated';
    public const PARAM_PRODUCT_ATTR_SIZE = 'size';
    public const PARAM_PRODUCT_ATTR_BRAND = 'brand';
    public const PARAM_PRODUCT_ATTR_MODEL_UNTRANSLATED = 'model_untranslated';
    public const PARAM_PRODUCT_ATTR_MODEL = 'model';

    public const CONFIG_DONT_UNSET_ARRAY_INDEX = 'CONFIG_DONT_UNSET_ARRAY_INDEX';
}
