<?php
/**
 * Author : Ali Ghalambaz<aghalambaz[At]gmail[Dot]com>
 * Date: 2019/08/31
 * Time: 12:23 PM
 */

namespace App\Services\Payment;


use App\Entity\TblBankTransactions;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use SoapFault;

class SamanPayment
{
    const REQUEST_TOKEN_URL = 'https://sep.shaparak.ir/payments/initpayment.asmx?WSDL';
    const REQUEST_PAYMENT_URL = 'https://sep.shaparak.ir/payment.aspx';
    const REQUEST_REVERSE_URL = 'https://sep.shaparak.ir/payments/referencepayment.asmx?WSDL';
    const REQUEST_VERIFY_URL = 'https://sep.shaparak.ir/payments/referencepayment.asmx?WSDL';
    const MID = 11475043;
    const MID_PASS = "02wMefd6v4rH";
    const STATE_NEW = 1;
    const STATE_TOKEN = 2;
    const STATE_TOKEN_FAILED = 3;
    const STATE_PAYING = 4;
    const STATE_PAY_FAILED = 5;
    const STATE_SUCCEED = 6;
    const STATE_PAY_MISMATCHED = 8;
    const STATE_PAY_REVERSED = 9;
    const STATE_VERIFYING = 10;
    const STATE_VERIFY_FAILED = 11;

    private $em ;
    private $entity = null;

    /**
     * @return null
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param null $entity
     * @return SamanPayment
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
        return $this;
    }
    private $resNum;
    private $error = 0;
    private $errorCode = 0;
    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     * @return SamanPayment
     */
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @param mixed $errorCode
     * @return SamanPayment
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
        return $this;
    }


    /**
     * @return UuidInterface
     */
    public function getTransactionReferenceNo()
    {
        return $this->resNum;
    }

    /**
     * @param mixed $resNum
     * @return SamanPayment
     */
    public function setResNum($resNum)
    {
        $this->resNum = $resNum;
        return $this;
    }

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function requestToken($userId,$orderId,$amount,$wage = 1,$additionalData1 = '',$additionalData2='')
    {
        try {
            $this->resNum = self::generateResNum();
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->errorCode =$e->getCode();
            return null;
        }
        $bt = new TblBankTransactions();
        $bt->setUserId($userId)->setPayable($amount)
            ->setOrderId($orderId)
            ->setState('new')->setStateCode(SamanPayment::STATE_NEW)
            ->setIpAddress($_SERVER['REMOTE_ADDR'])->setTransactionReference($this->resNum)
            ->setTouchDate(new \DateTime())->setMerchantId(self::MID);
        try {
            $client = new \SoapClient(self::REQUEST_TOKEN_URL);
            $params =array('TermID'=>self::MID,'Amount'=>$this->resNum->toString(),'ResNum'=>$amount,
                'Wage'=>$wage,'AdditionalData1'=>$additionalData1,'AdditionalData2'=>$additionalData2

            );
            $result = $client->__soapCall('RequestToken', $params);
        } catch (SoapFault $fault) {
            $this->error = $fault->faultstring;
            $this->errorCode =$fault->faultcode;
            return null;

        }


        if(is_string($result))
        {
           $bt->setState('TOKEN')->setStateCode(self::STATE_TOKEN)->setBankToken($result);
        }
        else $bt->setState('TOKEN FAILED')->setStateCode(self::STATE_TOKEN_FAILED)->setBankToken($result);
        $this->em->persist($bt);
        $this->em->flush();
        return $result;
    }

    /**
     * @return \Ramsey\Uuid\UuidInterface
     * @throws \Exception
     */
    public static function generateResNum()
    {
        return Uuid::uuid1();
    }

    public function validatePayment(array $params)
    {
        $repo = $this->em->getRepository(TblBankTransactions::class);

        $item = $repo->findBy(
            ['transactionReference' => $params['ResNum']],null,1
        );
        if(empty($item))
        {
           $this->error = 'No Transaction Find With '. $params['ResNum'];
           $this->errorCode = '-1000';
           return false;
        }
        $this->entity = $item[0];

        $item[0]->setBankState(empty($params['State'])?'':$params['State'])->
        setBankStateCode($params['StateCode'])->
        setBankRRN(empty($params['RRN'])?0:$params['RRN'])->
        setBankTraceNo(empty($params['TRACENO'])?0:$params['TRACENO'])->
        setBankRefrenceNo(empty($params['RefNum'])?'':$params['RefNum'])->
        setWebAddress(empty($params['website'])?'':$params['website'])->
        setUserPan(empty($params['SecurePan'])?'':$params['SecurePan'])->
        setPaid(empty($params['Amount'])?0:$params['Amount']);


        if(isset($params['State']))
        {
            if($params['State'] == 'OK' && $params['StateCode'] == 0)
            {
                if($item[0]->getPayable()!=$params['Amount'])
                {
                    $this->error =$params['State'].' Paid Mismatched';
                    $this->errorCode = -3000;
                    $item[0]->setStateCode(SamanPayment::STATE_PAY_MISMATCHED)->setState('Pay Mismatched');
                    $this->em->merge($item[0]);
                    $this->em->flush();
                    $this->reversePayment($item[0]);
                    return false;
                }
                else
                {
                    $item[0]->setStateCode(SamanPayment::STATE_VERIFYING)->setState('Verifying Payment');
                    $this->em->merge($item[0]);
                    $this->em->flush();
                    return true;
                }
            }
            else
            {
                $this->error =$params['State'];
                $this->errorCode = $params['StateCode'];
                $item[0]->setStateCode(SamanPayment::STATE_PAY_FAILED)->setState('PayFailed');
                $this->em->merge($item[0]);
                $this->em->flush();

                return false;
            }
        }
        else
        {
            $this->error = 'Unknown State';
            $this->errorCode = '-2000';
            $item[0]->setStateCode(SamanPayment::STATE_PAY_FAILED)->setState('PayFailed');
            $this->em->merge($item[0]);
            $this->em->flush();
            return false;
        }
    }


    private function reversePayment(TblBankTransactions $entity)
    {
        try {
            $client = new \SoapClient(self::REQUEST_REVERSE_URL);
            $params =array('String_1'=>$entity->getBankRefrenceNo(),'String_2'=>$entity->getMerchantId()
            ,'Username'=>self::MID, 'Password'=>self::MID_PASS);
            $result = $client->__soapCall('reverseTransaction', $params);
            return true;
        } catch (SoapFault $fault) {
            $this->error = $fault->faultstring;
            $this->errorCode =$fault->faultcode;
            return false;

        }

    }

    public function verifyPayment(TblBankTransactions $entity)
    {
        try {
            $client = new \SoapClient(self::REQUEST_VERIFY_URL);
            $params =array('RefNum'=>$entity->getBankRefrenceNo(),'MerchantID'=>$entity->getMerchantId()
            );
            $result = $client->__soapCall('VerifyTransaction', $params);

            if(!empty($result) && (floor($result) == $entity->getPaid()))
            {
                $entity->setState('Success')->setStateCode(self::STATE_SUCCEED);
                $this->em->merge($entity);
                $this->em->flush();
                return true;
            }
            else
            {
                $this->error = 'Verify Failed';
                $this->errorCode = -5000;
                $entity->setState('Verify Failed')->setStateCode(self::STATE_VERIFY_FAILED);
                $this->em->merge($entity);
                $this->em->flush();
                return false;
            }

        } catch (SoapFault $fault) {
            $this->error = $fault->faultstring;
            $this->errorCode =$fault->faultcode;
            return false;
        }
    }




}