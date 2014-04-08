<?php 
namespace Drool\CurrencyBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drool\CurrencyBundle\Document\Currency;

/**
 * Description of LoadStateData
 *
 * @author Ilie
 */
class LoadVirtualCurrencyData implements FixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(\Doctrine\Common\Persistence\ObjectManager $manager)
    {
        $virtualCurrencies = array(
            'IC' => 'IMVU Credits',
            'LD' => 'Lindens', 
            'TC' => 'Toricredits', 
            'FG' => 'Frenzoo Gold Coins', 
            'FH' => 'FriendsHangout Tokens', 
            'NN' => 'NuVera Note'
            );
        
            foreach ($virtualCurrencies as $key=>$value) {
                $currency = new Currency();
                $currency->setShortName($key);
                $currency->setName($value);
                $currency->setIsVirtual(true);
                $manager->persist($currency);
            }
            $manager->flush();
        
    }

}