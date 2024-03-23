<?php

namespace BinancePay\Core\Model;

use BinancePay\Core\Enums\GoodsCategory;
use BinancePay\Core\Enums\GoodsType;

/**
 * Goods
 * 
 * @property string $id The unique ID to identify the goods.
 * @property string $name Goods name. Special character is prohibited Example: \ " or emoji
 * 
 * @link https://developers.binance.com/docs/binance-pay/api-order-create-v3#goods
 */
class Goods
{
    public function __construct(
        private GoodsType $type,
        private GoodsCategory $category,
        private string $id,
        private string $name,
        private ?string $detail,
    ) {
    }

    public function toArray()
    {
        return [
            "goodsType" => $this->type->value,
            "goodsCategory" => $this->category->value,
            "referenceGoodsId" => $this->id,
            "goodsName" => $this->name,
            "goodsDetail" => $this->detail
        ];
    }
}
