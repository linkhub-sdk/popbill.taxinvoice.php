<?php
/**
* =====================================================================================
* Class for base module for Popbill API SDK. It include base functionality for
* RESTful web service request and parse json result. It uses Linkhub module
* to accomplish authentication APIs.
*
* This module uses curl and openssl for HTTPS Request. So related modules must
* be installed and enabled.
*
* http://www.linkhub.co.kr
* Author : Kim Seongjun (pallet027@gmail.com)
* Written : 2014-04-15
*
* Thanks for your interest.
* We welcome any suggestions, feedbacks, blames or anything.
* ======================================================================================
*/
namespace Popbill;
require_once 'Popbill/popbill.php';

class TaxinvoiceService extends PopbillBase {
	
	public function __construct($PartnerID,$SecretKey) {
    	parent::__construct($PartnerID,$SecretKey);
    	$this->AddScope('110');
    }
    
    //팝빌 세금계산서 연결 url
    public function GetURL($CorpNum,$UserID,$TOGO) {
    	$response = $this->executeCURL('/Taxinvoice/?TG='.$TOGO,$CorpNum,$UserID);
    	
    	return $response->url;
    }
    
    //관리번호 사용여부 확인
    public function CheckMgtKeyInUse($CorpNum,$MgtKeyType,$MgtKey) {
    	if(is_null($MgtKey) || empty($MgtKey)) {
    		throw new PopbillException('관리번호가 입력되지 않았습니다.',-99999999);
    	}
    	try
    	{
    		$response = $this->executeCURL('/Taxinvoice/'.$MgtKeyType.'/'.$MgtKey,$CorpNum);
    		return is_null($response->itemKey) == false;
    	}catch(PopbillException $pe) {
    		if($pe->getCode() == -11000005) {
    			return false;
    		}
    		throw $pe;
    	}
    }
    
    //임시저장
    public function Register($CorpNum, $Taxinvoice, $UserID = null, $writeSpecification = false) {
    	
    	if($writeSpecification) {
    		$Taxinvoice->writeSpecification = $writeSpecification;
    	}
    	
    	$postdata = json_encode($Taxinvoice);
    	
    	return $this->executeCURL('/Taxinvoice',$CorpNum,$UserID,true,null,$postdata);
    }    
    
    //삭제
    public function Delete($CorpNum,$MgtKeyType,$MgtKey,$UserID = null) {
    	if(is_null($MgtKey) || empty($MgtKey)) {
    		throw new PopbillException('관리번호가 입력되지 않았습니다.',-99999999);
    	}
    	
    	return $this->executeCURL('/Taxinvoice/'.$MgtKeyType.'/'.$MgtKey, $CorpNum, $UserID, true,'DELETE','');
    }
    
    //수정
    public function Update($CorpNum,$MgtKeyType,$MgtKey,$Taxinvoice, $UserID = null, $writeSpecification = false) {
    	if(is_null($MgtKey) || empty($MgtKey)) {
    		throw new PopbillException('관리번호가 입력되지 않았습니다.',-99999999);
    	}
    	
    	if($writeSpecification) {
    		$Taxinvoice->writeSpecification = $writeSpecification;
    	}
    	
    	$postdata = json_encode($Taxinvoice);
    	
    	return $this->executeCURL('/Taxinvoice/'.$MgtKeyType.'/'.$MgtKey, $CorpNum, $UserID, true, 'PATCH', $postdata);
    }
    
    //발행예정
    public function Send($CorpNum,$MgtKeyType,$MgtKey,$Memo = '',$UserID = null) {
    	if(is_null($MgtKey) || empty($MgtKey)) {
    		throw new PopbillException('관리번호가 입력되지 않았습니다.',-99999999);
    	}
    	
    	$Request = new MemoRequest();
    	$Request->memo = $Memo;
    	
    	$postdata = json_encode($Request);
    	
    	return $this->executeCURL('/Taxinvoice/'.$MgtKeyType.'/'.$MgtKey, $CorpNum, $UserID, true,'SEND',$postdata);
    }
    
    //발행예정취소
    public function CancelSend($CorpNum,$MgtKeyType,$MgtKey,$Memo = '',$UserID = null) {
    	if(is_null($MgtKey) || empty($MgtKey)) {
    		throw new PopbillException('관리번호가 입력되지 않았습니다.',-99999999);
    	}
    	$Request = new MemoRequest();
    	$Request->memo = $Memo;
    	
    	$postdata = json_encode($Request);
    	
    	return $this->executeCURL('/Taxinvoice/'.$MgtKeyType.'/'.$MgtKey, $CorpNum, $UserID, true,'CANCELSEND',$postdata);
    }
}

class Taxinvoice
{
	
	public $writeSpecification;
	public $writeDate;
	public $chargeDirection;
	public $issueType;
	public $issueTiming;
	public $taxType;
	public $ivoicerCorpNum;
	public $invoicerMgtKey;
	public $invoicerTaxRegID;
	public $invoicerCorpName;
	public $invoicerCEOName;
	public $invoicerAddr;
	public $invoicerBizClass;
	public $invoicerBizType;
	public $invoicerContactName;
	public $invoicerDeptName;
	public $invoicerTEL;
	public $invoicerHP;
	public $invoicerEmail;
	public $invoicerSMSSendYN;
	
	public $invoiceeCorpNum;
	public $invoiceeType;
	public $invoiceeMgtKey;
	public $invoiceeTaxRegID;
	public $invoiceeCorpName;
	public $invoiceeCEOName;
	public $invoiceeAddr;
	public $invoiceeBizClass;
	public $invoiceeBizType;
	public $invoiceeContactName1;
	public $invoiceeDeptName1;
	public $invoiceeTEL1;
	public $invoiceeHP1;
	public $invoiceeEmail2;
	public $invoiceeContactName2;
	public $invoiceeDeptName2;
	public $invoiceeTEL2;
	public $invoiceeHP2;
	public $invoiceeEmail1;
	public $invoiceeSMSSendYN;
	
	public $trusteeCorpNum;
	public $trusteeMgtKey;
	public $trusteeTaxRegID;
	public $trusteeCorpName;
	public $trusteeCEOName;
	public $trusteeAddr;
	public $trusteeBizClass;
	public $trusteeBizType;
	public $trusteeContactName;
	public $trusteeDeptName;
	public $trusteeTEL;
	public $trusteeHP;
	public $trusteeEmail;
	public $trusteeSMSSendYN;
	
	public $taxTotal;
	public $supplyCostTotal;
	public $totalAmount;
	public $modifyCode;
	public $purposeType;
	public $serialNum;
	public $cash;
	public $chkBill;
	public $credit;
	public $note;
	public $remark1;
	public $remark2;
	public $remark3;
	public $kwon;
	public $ho;
	public $businessLicenseYN;
	public $bankBookYN;
	public $faxsendYN;
	public $faxreceiveNum;
	public $originalTaxinvoiceKey;
	public $detailList;
	public $addContactList;
	
}
class TaxinvoiceDetail {
	public $serialNum;
	public $purchaseDT;
	public $itemName;
	public $spec;
	public $qty;
	public $unitCost;
	public $supplyCost;
	public $tax;
	public $remark;
}
class TaxinvoiceAddContact {
	public $serialNum;
	public $email;
	public $contactName;
}
class ENumMgtKeyType {
	const SELL = 'SELL';
	const BUY = 'BUY';
	const TRUSTEE = 'TRUSTEE';
}
class MemoRequest {
	public $memo;
}
?>
