<?php

class orderSuscripciones extends ObjectModel
{

    public $deliveryId;

    public $obId;

    public $clientId;

    public $shippingAddressId;

    public $status;

    public $subscriptionDate;

    public $order;

    public $lineId;

    public $lineasEstado;

    public $deliveryDate;
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
            '$status' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            '$subscriptionDate' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            '$order' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            '$deliveryDate' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            '$lineId' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),

            '$lineasEstado' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),


        ),
    );


}