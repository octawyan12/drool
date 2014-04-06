<?php

namespace Drool\CurrencyBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Drool\CurrencyBundle\Entity\Currency;

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
        $json_url = "https://bitpay.com/api/rates";
        $json = file_get_contents($json_url);
        $data = json_decode($json);
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        foreach($data as $currency) {
            if($currencyObject = $em->getRepository('DroolCurrencyBundle:Currency')->findOneBy(array('shortName' => $currency->code))) {
                $currencyObject->setValue($currency->rate);
                $em->persist($currencyObject);
            } else {
                $currencyObject = new Currency();
                $currencyObject->setName($currency->name);
                $currencyObject->setValue($currency->rate);
                $currencyObject->setShortName($currency->code);
                $em->persist($currencyObject);
            }
        }
        $em->flush();
    }
}