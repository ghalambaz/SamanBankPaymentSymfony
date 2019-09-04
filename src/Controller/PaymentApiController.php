<?php
/**
 * Author : Ali Ghalambaz<aghalambaz[At]gmail[Dot]com>
 * Date: 2019/08/31
 * Time: 12:36 PM
 */

namespace App\Controller;


use App\Entity\TblBankTransactions;
use App\Services\Payment\PaymentFactory;
use App\Services\Payment\SamanPayment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Tests\Compiler\J;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;

class PaymentApiController extends Controller
{
    /**
     * @Route("/PaymentApi/requestToken", name="requestTokenPaymentApi")
     * @param Request $request
     * @param SamanPayment $samanPayment
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function requestToken(Request $request,SamanPayment $samanPayment)  //First Request
    {
        $user_id = 1234;
        $amount = 10250;
        $order_id = rand(1,10000);

        /* examples
        if(isset($_SESSION['userkey']))
            $userid = $_SESSION['userkey'];

        if(empty($userid)) return new JsonResponse('you are not login!');
        */

        $token = $samanPayment->requestToken($user_id,$order_id,$amount);
        if(empty($token)) return new JsonResponse('failed no token');


        return $this->render('payment/sep.twig', [
            'form_action' => $samanPayment::REQUEST_PAYMENT_URL,
            'token'=>$token,
            'redirect_url'=> 'http://kidstaxi.opendev.ir/PaymentApi/bankPaymentResponse'
        ]);

    }
    /**
     * @Route("/PaymentApi/bankPaymentResponse", name="bankPaymentResponse")
     */
    public function bankPaymentResponse(Request $request,SamanPayment $samanPayment)
    {
        $params = $request->request->all();
        if(!$samanPayment->validatePayment($params))
        {
            return new JsonResponse($samanPayment->getErrorCode().':'.$samanPayment->getError());
        }
        else {
            if($samanPayment->verifyPayment($samanPayment->getEntity()))
            {
                return new JsonResponse('Payment Succeed'.$params['ResNum'].' -- '.$params['TRACENO'].' -- '.$params['RRN']);
            }
            else
                return new JsonResponse('Your Money Will Pay back in 72 hours');
        }




    }

}