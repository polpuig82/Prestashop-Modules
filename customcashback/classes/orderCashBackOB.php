<?php

class orderCashBackDB extends ObjectModel
{
    public $balance;
    public $lastMovement;
    public $expirationDate;
    public $maxPercentage;
    public $cashbackProduct;
    public $transacciones;

    /**
     * Définition des paramètres de la classe
     */
    public static $definition = array(
        'table' => 'order_cashback',
        'primary' => 'id_order_cashback',
        'multilang' => false,
        'multilang_shop' => false,
        'fields' => array(
            'balance' => array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat'),
            'lastMovement' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'expirationDate' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'maxPercentage' => array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat'),
            'cashbackProduct' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'transacciones' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            '$deliveryId' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            '$obId' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            '$clientId' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            // '$shippingAddressId' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            // '$billingAddressId' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            '$status' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            // '$orderDate' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            // '$shippingDate' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            // '$shippingAddress' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            // '$deliverySlotId' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            // '$slotName' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            // '$totalAmount' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            // '$invoiceId' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            // '$invoiceNo' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            // '$order' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            // '$lineId' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),

        ),
    );
}
