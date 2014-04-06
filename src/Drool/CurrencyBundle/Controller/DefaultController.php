<?php

namespace Drool\CurrencyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Drool\CurrencyBundle\Form\ConvertType;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $dm = $this->getDocumentManager();
        $form = $this->createForm(new ConvertType($dm), array());
        $result = null;
        if($request->isMethod('post')) {
            $form->bind($request);
            if($form->isValid()) {
                $currency_amount = $request->request->get('currency_amount');
                $from_currency = $request->request->get('from_currency');
                $to_currency = $request->request->get('to_currency');
                $result = $this->get('drool_currency.converter')->convertValues($currency_amount,$from_currency,$to_currency);
                
                $this->get('session')->getFlashBag()->add(
                        'notice', 'The result is: '. $result
                );
                
                return $this->redirect($this->generateUrl('drool_currency_homepage'));
            }
        }
        
        return $this->render('DroolCurrencyBundle:Default:index.html.twig', array(
            'result' => $result, 
            'form' => $form->createView()
        ));
    }
    
    private function getDocumentManager()
    {
        return $this->get('doctrine.odm.mongodb.document_manager');
    }
}
