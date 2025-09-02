<?php

class deliverySlot extends ObjectModel
{

    public $deliverySlotId;

    public $slotDay;

    public $slotName;

    /**
     * Définition des paramètres de la classe
     */
    public static $definition = array(
        'table' => 'address',
        'primary' => 'deliverySlotId',
        'multilang' => false,
        'multilang_shop' => false,
        'fields' => array(
            'deliverySlotId' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            'slotDay' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),
            'slotName' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml','size' => 255),

        ),
    );


}