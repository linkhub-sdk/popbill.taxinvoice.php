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
    
    public function Delete($CorpNum,$MgtKeyType,$MgtKey,$UserID = null) {
    	if(is_null($MgtKey) || empty($MgtKey)) {
    		throw new PopbillException('관리번호가 입력되지 않았습니다.',-99999999);
    	}
    	
    	return $this->executeCURL('/Taxinvoice/'.$MgtKeyType.'/'.$MgtKey,$CorpNum,$UserID,true,'DELETE','');
    }
}

class Taxinvoice
{
	
	public $WriteSpecification;
	public $writeDate;
	public $ChargeDirection;
	public $IssueType;
	public $IssueTiming;
	public $TaxType;
	public $IvoicerCorpNum;
	public $InvoicerMgtKey;
	public $InvoicerTaxRegID;
	public $InvoicerCorpName;
	public $InvoicerCEOName;
	public $InvoicerAddr;
	public $InvoicerBizClass;
	public $InvoicerBizType;
	public $InvoicerContactName;
	public $InvoicerDeptName;
	public $InvoicerTEL;
	public $InvoicerHP;
	public $InvoicerEmail;
	public $InvoicerSMSSendYN;
	
	public $InvoiceeCorpNum;
	public $InvoiceeType;
	public $InvoiceeMgtKey;
	public $InvoiceeTaxRegID;
	public $InvoiceeCorpName;
	public $InvoiceeCEOName;
	public $InvoiceeAddr;
	public $InvoiceeBizClass;
	public $InvoiceeBizType;
	public $InvoiceeContactName1;
	public $InvoiceeDeptName1;
	public $InvoiceeTEL1;
	public $InvoiceeHP1;
	public $InvoiceeEmail2;
	public $InvoiceeContactName2;
	public $InvoiceeDeptName2;
	public $InvoiceeTEL2;
	public $InvoiceeHP2;
	public $InvoiceeEmail1;
	public $InvoiceeSMSSendYN;
	
	public $TrusteeCorpNum;
	public $TrusteeMgtKey;
	public $TrusteeTaxRegID;
	public $TrusteeCorpName;
	public $TrusteeCEOName;
	public $TrusteeAddr;
	public $TrusteeBizClass;
	public $TrusteeBizType;
	public $TrusteeContactName;
	public $TrusteeDeptName;
	public $TrusteeTEL;
	public $TrusteeHP;
	public $TrusteeEmail;
	public $TrusteeSMSSendYN;
	
	public $TaxTotal;
	public $SupplyCostTotal;
	public $TotalAmount;
	public $ModifyCode;
	public $PurposeType;
	public $SerialNum;
	public $Cash;
	public $ChkBill;
	public $Credit;
	public $Node;
	public $Remark1;
	public $Remark2;
	public $Remark3;
	public $Kwon;
	public $Ho;
	public $BusinessLicenseYN;
	public $BankBookYN;
	public $FaxSendYN;
	public $FaxReceiveNum;
	public $OriginalTaxinvoiceKey;
	public $DetailList;
	public $AddContactList;
	
}
class TaxinvoiceDetail {
	public $SerialNum;
	public $PurchaseDT;
	public $ItemName;
	public $Spec;
	public $Qty;
	public $UnitCost;
	public $SupplyCost;
	public $Tax;
	public $Remark;
}
class TaxinvoiceAddContact {
	public $SerialNum;
	public $Email;
	public $ContactName;
}
class ENumMgtKeyType {
	const SELL = 'SELL';
	const BUY = 'BUY';
	const TRUSTEE = 'TRUSTEE';
}
?>
