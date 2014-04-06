<?php

namespace Drool\CurrencyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConvertType
 *
 * @author Ilie
 */
class ConvertType extends AbstractType {

    private $em;
    public function __construct($em) {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                
            ->add('currency_amount', 'text', array(
                'mapped' => false
            ))
            ->add('from_currency', 'entity', array( 
                      'mapped' => false,
                      'class' => 'DroolCurrencyBundle:Currency',
                      'choices' => $this->em->getRepository('DroolCurrencyBundle:Currency')->findAll(),
                      'empty_value' => 'Currency 1',
            ))
            ->add('to_currency', 'entity', array(    
                      'mapped' => false,
                      'class' => 'DroolCurrencyBundle:Currency',
                      'choices' => $this->em->getRepository('DroolCurrencyBundle:Currency')->findAll(),
                      'empty_value' => 'Currency 2',
            ));  
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }

    public function getName() {
        return '';
    }

}
