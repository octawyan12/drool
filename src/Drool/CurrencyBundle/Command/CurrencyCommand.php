<?php

namespace Drool\CurrencyBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Drool\CurrencyBundle\Document\Currency;

define('CONTROL_AMOUNT', 50000);
define('CONTROL_CURRENCY', 'USD');
/**
 * Description of CurrencyCommand
 *
 * @author ilie.gurzun@gmail.com
 */
class CurrencyCommand extends ContainerAwareCommand
{
    
    protected function configure()
    {
        $this->setName('currency:update')
                ->setDescription('Import currency');                
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        $json_url = "https://bitpay.com/api/rates";
//        $json = file_get_contents($json_url);
//        $data = json_decode($json);
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
//        foreach($data as $currency) {
//            if($currencyObject = $dm->getRepository('DroolCurrencyBundle:Currency')->findOneBy(array('shortName' => $currency->code))) {
//                $currencyObject->setValue($currency->rate);
//                $dm->persist($currencyObject);
//            } else {
//                $currencyObject = new Currency();
//                $currencyObject->setName($currency->name);
//                $currencyObject->setValue($currency->rate);
//                $currencyObject->setShortName($currency->code);
//                $dm->persist($currencyObject);
//            }
//        }
//        $dm->flush();
        $curl_url = "https://firstmetaexchange.com/exchange/doHypotheticalExchange";
        
        $dollar = $dm->getRepository('DroolCurrencyBundle:Currency')->findOneBy(array('shortName' => CONTROL_CURRENCY));
        $allCurrencies = $dm->getRepository('DroolCurrencyBundle:Currency')->findVirtual();
        foreach($allCurrencies as $id => $value) {
            
            $fields = array(
                'amount' => urlencode(CONTROL_AMOUNT),
                'currency' => urlencode(CONTROL_CURRENCY.'-'.$value->getShortName()),
                'direction' => urlencode('SELL'),
                'exchangedCurrency' => urlencode($value->getShortName()),
                
            );
            $fields_string = '';
            foreach($fields as $key=>$value) { 
                $fields_string .= $key.'='.$value.'&'; 

            }
            $fields_string = rtrim($fields_string, '&');

            $finalUrl = $curl_url.'?'.$fields_string;
            $finalUrl = rtrim($finalUrl, '&');
            $finalUrl = preg_replace('/\s+/', '', $finalUrl);
            
            $result = file_get_contents($finalUrl);
            $result = json_decode($result);
            $result = str_replace(' '.CONTROL_CURRENCY, '', $result->result);
            
            $currentCurrency = $dm->getRepository('DroolCurrencyBundle:Currency')->find($id);
            
            $currentCurrency->setValue(($result * $dollar->getValue())/CONTROL_AMOUNT);
            $dm->persist($currentCurrency);
        }
        $dm->flush();
    }
}