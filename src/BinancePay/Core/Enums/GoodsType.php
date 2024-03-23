<?php

namespace BinancePay\Core\Enums;


/**
 * The type of the goods for the order.
 *  01: Tangible Goods
 *  02: Virtual Goods
 */
enum GoodsType: string
{
    case TangibleGood = "01";
    case VirtualGood = "02";
}
