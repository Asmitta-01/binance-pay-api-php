<?php

namespace BinancePay\Core\Model;

class Buyer
{
    public function __construct(
        private string $lastName,
        private string $firstName,
        private string $email,
        private string $language = 'en'
    ) {
    }

    public function toArray()
    {
        return [
            "buyerName" => [
                "firstName" => $this->firstName,
                "lastName" => $this->lastName
            ],
            "buyerEmail" => $this->email,
            "buyerBrowserLanguage" => $this->language
        ];
    }
}
