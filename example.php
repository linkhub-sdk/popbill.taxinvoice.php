<?php

require_once 'PopbillTaxinvoice.php';
use Popbill\PopbillException;
use Popbill\TaxinvoiceService;
use Popbill\ENumMgtKeyType;
use Popbill\Taxinvoice;
use Popbill\TaxinvoiceDetail;
use Popbill\TaxinvoiceAddContact;

$PartnerID = 'TESTER';
$SecretKey = 'okH3G1/WZ3w1PMjHDLaWdcWIa/dbTX3eGuqMZ5AvnDE=';


$TaxinvoiceService = new TaxinvoiceService($PartnerID,$SecretKey);

$TaxinvoiceService->IsTest(true);

echo substr($TaxinvoiceService->GetPopbillURL('1231212312','userid','LOGIN'),0,50). ' ...';
echo chr(10);

echo $TaxinvoiceService->GetBalance('1231212312');
echo chr(10);
echo $TaxinvoiceService->GetPartnerBalance('1231212312');
echo chr(10);


echo substr($TaxinvoiceService->GetURL('1231212312','userid','SBOX'),0,50). ' ...';
echo chr(10);

$InUse = $TaxinvoiceService->CheckMgtKeyInUse('1231212312',ENumMgtKeyType::SELL,'123123');
echo $InUse ? '사용중':'미사용중';
echo chr(10);

$Taxinvoice = new Taxinvoice();

$Taxinvoice->writeDate = '20140410';
$Taxinvoice->IssueType = '정발행';
$Taxinvoice->ChargeDirection = '정과금';
$Taxinvoice->PurposeType = '영수';
$Taxinvoice->TaxType = '과세';
$Taxinvoice->IssueTiming = '직접발행';

$Taxinvoice->InvoicerCorpNum = '1231212312';
$Taxinvoice->InvoicerCorpName = '공급자상호';
$Taxinvoice->InvoicerMgtKey = '123123';
$Taxinvoice->InvoicerCEOName = '공급자 대표자성명';
$Taxinvoice->InvoicerAddr = '공급자 주소';
$Taxinvoice->InvoicerContactName = '공급자 담당자성명';
$Taxinovice->InvoicerEmail = 'tester@test.com';
$Taxinvoice->InvoicerTEL = '070-0000-0000';
$Taxinvoice->InvoicerHP = '010-0000-0000';
$Taxinvoice->InvoicerSMSSendYN = false;

$Taxinvoice->InvoiceeType = '사업자';
$Taxinvoice->InvoiceeCorpNum = '8888888888';
$Taxinvoice->InvoiceeCorpName = '공급받는자 상호';
$Taxinvoice->InvoiceeCEOName = '공급받는자 대표자성명';
$Taxinvoice->InvoiceeAddr = '공급받는자 주소';
$Taxinvoice->InvoiceeContactName1 = '공급받는자 담당자성명';
$Taxinovice->InvoiceeEmail1 = 'tester@test.com';
$Taxinvoice->InvoiceeTEL1 = '070-0000-0000';
$Taxinvoice->InvoiceeHP1 = '010-0000-0000';
$Taxinvoice->InvoiceeSMSSendYN = false;

$Taxinvoice->SupplyCostTotal = '100000';
$Taxinvoice->TaxTotal = '10000';
$Taxinvoice->TotalAmount = '110000';

$Taxinvoice->OriginalTaxinvoiceKey = '';
$Taxinvoice->SerialNum = '123';
$Taxinvoice->Cash = '';
$Taxinvoice->ChkBill = '';
$Taxinvoice->Note = '';
$Taxinvoice->Credit = '';
$Taxinvoice->Remark1 = '비고1';
$Taxinvoice->Remark2 = '비고2';
$Taxinvoice->Remark3 = '비고3';
$Taxinvoice->Kwon = '1';
$Taxinvoice->Hp = '1';

$Taxinvoice->BusinessLicenseYN = false;
$Taxinvoice->BankBookYN = false;
$Taxinvoice->FaxReceiveNum = '';
$Taxinvoice->FaxSendYN = false;

$Taxinvoice->DetailList = array();

$Taxinvoice->DetailList[] = new TaxinvoiceDetail();
$Taxinvoice->DetailList[0]->SerialNum = 1;
$Taxinvoice->DetailList[0]->PurchaseDT = '20140410';
$Taxinvoice->DetailList[0]->ItemName = '품목명1번';
$Taxinvoice->DetailList[0]->Spec = '규격';
$Taxinvoice->DetailList[0]->Qty = '1';
$Taxinvoice->DetailList[0]->UnitCost = '100000';
$Taxinvoice->DetailList[0]->SupplyCost = '100000';
$Taxinvoice->DetailList[0]->Tax = '10000';
$Taxinvoice->DetailList[0]->Remark = '품목비고';

$Taxinvoice->DetailList[] = new TaxinvoiceDetail();
$Taxinvoice->DetailList[1]->SerialNum = 2;
$Taxinvoice->DetailList[1]->ItemName = '품목명2번';

try {
	$result = $TaxinvoiceService->Register('1231212312',$Taxinvoice,false);
	echo $result->message;
}
catch(PopbillException $pe) {
	echo $pe->getMessage();
}

echo chr(10);

try {
	$result = $TaxinvoiceService->Delete('1231212312',EnumMgtKeyType::SELL,'123123');
	echo $result->message;
}
catch(PopbillException $pe) {
	echo $pe->getMessage();
}

echo chr(10);


?>
