<?php
/**
 * Author : Ali Ghalambaz<aghalambaz[At]gmail[Dot]com>
 * Date: 2019/09/02
 * Time: 9:26 AM
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * TblCustomers
 *
 * @ORM\Table(name="tbl_banktransactions")
 * @ORM\Entity
 */
class TblBankTransactions
{
    /*status & state are equals
 * new = 1 [default]
 * token generated = 2
 * sent for pay = 3
 * pay failed = 4
 * pay success = 5
 * pay mismatched = 6
 * pay reversed = 7
 * sent for verify = 8
 * verified = 9
 */


    public function __construct()
    {

    }

    /**
     * @return int
     */
    public function getTransactionId(): int
    {
        return $this->transactionId;
    }

    /**
     * @param int $transactionId
     * @return TblBankTransactions
     */
    public function setTransactionId(int $transactionId): TblBankTransactions
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return TblBankTransactions
     */
    public function setUserId(int $userId): TblBankTransactions
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return \Ramsey\Uuid\UuidInterface
     */
    public function getTransactionReference(): \Ramsey\Uuid\UuidInterface
    {
        return $this->transactionReference;
    }

    /**
     * @param \Ramsey\Uuid\UuidInterface $transactionReference
     * @return TblBankTransactions
     */
    public function setTransactionReference(\Ramsey\Uuid\UuidInterface $transactionReference): TblBankTransactions
    {
        $this->transactionReference = $transactionReference;
        return $this;
    }

    /**
     * @return int
     */
    public function getPayable(): int
    {
        return $this->payable;
    }

    /**
     * @param int $payable
     * @return TblBankTransactions
     */
    public function setPayable(int $payable): TblBankTransactions
    {
        $this->payable = $payable;
        return $this;
    }

    /**
     * @return int
     */
    public function getPaid(): int
    {
        return $this->paid;
    }

    /**
     * @param int $paid
     * @return TblBankTransactions
     */
    public function setPaid(int $paid): TblBankTransactions
    {
        $this->paid = $paid;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTouchDate(): \DateTime
    {
        return $this->touchDate;
    }

    /**
     * @param \DateTime $touchDate
     * @return TblBankTransactions
     */
    public function setTouchDate(\DateTime $touchDate): TblBankTransactions
    {
        $this->touchDate = $touchDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    /**
     * @param string $ipAddress
     * @return TblBankTransactions
     */
    public function setIpAddress(string $ipAddress): TblBankTransactions
    {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return TblBankTransactions
     */
    public function setState(string $state): TblBankTransactions
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return int
     */
    public function getStateCode(): int
    {
        return $this->stateCode;
    }

    /**
     * @param int $stateCode
     * @return TblBankTransactions
     */
    public function setStateCode(int $stateCode): TblBankTransactions
    {
        $this->stateCode = $stateCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getBankState(): string
    {
        return $this->bankState;
    }

    /**
     * @param string $bankState
     * @return TblBankTransactions
     */
    public function setBankState(string $bankState): TblBankTransactions
    {
        $this->bankState = $bankState;
        return $this;
    }

    /**
     * @return int
     */
    public function getBankStateCode(): int
    {
        return $this->bankStateCode;
    }

    /**
     * @param int $bankStateCode
     * @return TblBankTransactions
     */
    public function setBankStateCode(int $bankStateCode): TblBankTransactions
    {
        $this->bankStateCode = $bankStateCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getBankTraceNo(): string
    {
        return $this->bankTraceNo;
    }

    /**
     * @param string $bankTraceNo
     * @return TblBankTransactions
     */
    public function setBankTraceNo(string $bankTraceNo): TblBankTransactions
    {
        $this->bankTraceNo = $bankTraceNo;
        return $this;
    }

    /**
     * @return int
     */
    public function getBankRRN(): int
    {
        return $this->bankRRN;
    }

    /**
     * @param int $bankRRN
     * @return TblBankTransactions
     */
    public function setBankRRN(int $bankRRN): TblBankTransactions
    {
        $this->bankRRN = $bankRRN;
        return $this;
    }

    /**
     * @return string
     */
    public function getBankRefrenceNo(): string
    {
        return $this->bankRefrenceNo;
    }

    /**
     * @param string $bankRefrenceNo
     * @return TblBankTransactions
     */
    public function setBankRefrenceNo(string $bankRefrenceNo): TblBankTransactions
    {
        $this->bankRefrenceNo = $bankRefrenceNo;
        return $this;
    }

    /**
     * @return int
     */
    public function getMerchantId(): int
    {
        return $this->merchantId;
    }

    /**
     * @param int $merchantId
     * @return TblBankTransactions
     */
    public function setMerchantId(int $merchantId): TblBankTransactions
    {
        $this->merchantId = $merchantId;
        return $this;
    }

    /**
     * @return string
     */
    public function getWebAddress(): string
    {
        return $this->webAddress;
    }

    /**
     * @param string $webAddress
     * @return TblBankTransactions
     */
    public function setWebAddress(string $webAddress): TblBankTransactions
    {
        $this->webAddress = $webAddress;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserPan(): string
    {
        return $this->userPan;
    }

    /**
     * @param string $userPan
     * @return TblBankTransactions
     */
    public function setUserPan(string $userPan): TblBankTransactions
    {
        $this->userPan = $userPan;
        return $this;
    }
    /**
     * @var int
     *
     * @ORM\Column(name="transaction_id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $transactionId;

    /**
     * @var int
     *
     * @ORM\Column(name="order_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $orderId = '0';

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     * @return TblBankTransactions
     */
    public function setOrderId(int $orderId): TblBankTransactions
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $userId = '0';

    /**
     * @var \Ramsey\Uuid\UuidInterface
     * @ORM\Column(name="transaction_reference" ,type="uuid_binary_ordered_time", unique=true, nullable=false)
     */
    private $transactionReference = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="payable", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $payable = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="paid", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $paid = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="touch_date", type="datetime", nullable=false, options={"default"="0000-00-00 00:00:00"})
     */
    private $touchDate;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_address", type="string", length=5, nullable=false, options={"fixed"=true})
     */
    private $ipAddress = '';


    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=0, nullable=false, options={"default"="new"})
     */
    private $state= 'new';

    /**
     * @var int
     *
     * @ORM\Column(name="state_code", type="integer", nullable=false, options={"unsigned"=true,"default" = 1})
     */
    private $stateCode = 0;


    /**
     * @var string
     *
     * @ORM\Column(name="bank_state", type="string", length=0, nullable=false, options={"default"=""})
     */
    private $bankState= '';

    /**
     * @var int
     *
     * @ORM\Column(name="bank_state_code", type="integer", nullable=false, options={"default" = -10000})
     */
    private $bankStateCode = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="bank_trace_no", type="bigint", length=0, nullable=false, options={"default"=0})
     */
    private $bankTraceNo= '';
    /**
     * @var int
     *
     * @ORM\Column(name="banek_rrn", type="bigint", length=0, nullable=false, options={"default"=0})
     */
    private $bankRRN= '';

    /**
     * @var string
     *
     * @ORM\Column(name="bank_refrence_no", type="string", length=60, nullable=false, options={"default"=""})
     */
    private $bankRefrenceNo= '';

    /**
     * @var string
     *
     * @ORM\Column(name="bank_token", type="string", length=60, nullable=false, options={"default"=""})
     */
    private $bankToken= '';

    /**
     * @return string
     */
    public function getBankToken(): string
    {
        return $this->bankToken;
    }

    /**
     * @param string $bankToken
     * @return TblBankTransactions
     */
    public function setBankToken(string $bankToken): TblBankTransactions
    {
        $this->bankToken = $bankToken;
        return $this;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="merchant_id", type="integer", nullable=false, options={"unsigned"=true,"default" = 0})
     */
    private $merchantId = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="web_address", type="string", length=0, nullable=false, options={"default"=""})
     */
    private $webAddress = '';

    /**
     * @var string
     *
     * @ORM\Column(name="user_pan", type="string", length=0, nullable=false, options={"default"=""})
     */
    private $userPan = '';


}