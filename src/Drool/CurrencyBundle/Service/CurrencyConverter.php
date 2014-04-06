<?php

namespace Drool\CurrencyBundle\Service;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CurrencyConverter
 *
 * @author ilie.gurzun@gmail.com
 */
class CurrencyConverter {
    
    private $service_container;
    
    public function __construct($service_container) {
        $this->service_container = $service_container;
    }
    public function convertValues($from_value, $from_currency_id, $to_currency_id) {
        $dm = $this->service_container->get('doctrine_mongodb')->getManager();
        
        $from_currency = $dm->getRepository('DroolCurrencyBundle:Currency')->find($from_currency_id);
        $to_currency = $dm->getRepository('DroolCurrencyBundle:Currency')->find($to_currency_id);
        
        $result = $from_value * ($to_currency->getValue() / $from_currency->getValue());
        return $result;
    }
}
