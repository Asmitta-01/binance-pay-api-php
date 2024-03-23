<?php

namespace BinancePay\Core\Enums;


/**
 * 0000: Electronics & Computers
 * 
 * 1000: Books, Music & Movies
 * 
 * 2000: Home, Garden & Tools
 * 
 * 3000: Clothes, Shoes & Bags
 * 
 * 4000: Toys, Kids & Baby
 * 
 * 5000: Automotive & Accessories
 * 
 * 6000: Game & Recharge
 * 
 * 7000: Entertainment & Collection
 * 
 * 8000: Jewelry
 * 
 * 9000: Domestic service
 * 
 * A000: Beauty care
 * 
 * B000: Pharmacy
 * 
 * C000: Sports & Outdoors
 * 
 * D000: Food, Grocery & Health products
 * 
 * E000: Pet supplies
 * 
 * F000: Industry & Science
 * 
 * Z000: Others
 */
enum GoodsCategory: string
{
    case ElectronicsAndComputers = '0000';
    case BooksMusicAndMovies = '1000';
    case HomeGardenAndTools = '2000';
    case ClothesShoesAndBags = '3000';
    case ToysKidsBaby = '4000';
    case AutomotiveAndAccessories = '5000';
    case GamesAndRecharge = '6000';
    case EntertainmentAndCollection = '7000';
    case Jewelry = '8000';
    case DomesticService = '9000';
    case BeautyCare = 'A000';
    case Pharmacy = 'B000';
    case SportsAndOutdoors = 'C000';
    case FoodGroceryAndHealthProducts = 'D000';
    case PetSupplies = 'E000';
    case IndustryAndScience = 'F000';
    case Others = 'Z000';
}
