<?php

class orderInProgress extends ObjectModel
{

    public $deliveryId;

    public $obId;

    public $clientId;

    public $shippingAddressId;

    public $billingAddressId;

    public $status;

    public $orderDate;

    public $shippingDate;

    public $shippingAddress;

    public $deliverySlotId;

    public $slotName;

    public $totalAmount;

    public $invoiceId;

    public $invoiceNo;

    public $order;

    public $lineId;
    /**
     * Définition des paramètres de la classe
     */
    public static $definition = array(
        'table' => 'address',
        'primary' => 'obId',
        'multilang' => false,
        'multilang_shop' => false,
        'fields' => array(
            '$deliveryId' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            '$obId' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            '$clientId' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            '$shippingAddressId' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            '$billingAddressId' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            '$status' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            '$orderDate' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            '$shippingDate' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            '$shippingAddress' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            '$deliverySlotId' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            '$slotName' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            '$totalAmount' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            '$invoiceId' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            '$invoiceNo' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            '$order' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            '$lineId' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),


        ),
    );


}