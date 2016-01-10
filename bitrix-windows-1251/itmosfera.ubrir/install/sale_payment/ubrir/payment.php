<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<?
include(GetLangFileName(dirname(__FILE__)."/", "/ubrir.php"));
include(dirname(__FILE__)."/sdk/ubrir_autoload.php");
include(dirname(__FILE__)."/view/style.php");

$shouldPay = (strlen(CSalePaySystemAction::GetParamValue("SHOULD_PAY")) > 0) ? 
CSalePaySystemAction::GetParamValue("SHOULD_PAY") : $GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["SHOULD_PAY"];
$orderID = (strlen(CSalePaySystemAction::GetParamValue("ORDER_ID")) > 0) ? 
CSalePaySystemAction::GetParamValue("ORDER_ID") : $GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["ID"];

$arOrder = CSaleOrder::GetByID(CSalePaySystemAction::GetParamValue("ORDER_ID"));                                                            // �������� ������� �����


if(!isset($_GET['status'])) {		

	/* ---------------- ���� �������� ��� �� ��������� -------------- */

	$readyToPay = false;                                                                                                                     // ����������� �������
	$bankHandler = new Ubrir(array(																											 // �������������� ������ �������� � TWPG
							'shopId' => CSalePaySystemAction::GetParamValue("ID"), 
							'order_id' => CSalePaySystemAction::GetParamValue("ORDER_ID"), 
							'sert' => CSalePaySystemAction::GetParamValue("SERT"),
							'amount' => CSalePaySystemAction::GetParamValue("SHOULD_PAY")
							));                    
	$response_order = $bankHandler->prepare_to_pay();                                       												// ��� ������ ����

	include(dirname(__FILE__)."/include/twpg_db.php");	
	   
    if($readyToPay AND !empty($response_order)) { 
		$twpg_url = $response_order->URL[0].'?orderid='.$response_order->OrderID[0].'&sessionid='.$response_order->SessionID[0];
		echo '<INPUT TYPE="button" value="O������� Visa" onclick="document.location = \''.$twpg_url.'\'">';
	}
	 
	if(CSalePaySystemAction::GetParamValue("TWO") == 'Y') {                                                                               // ���� ������� ��� �����������, �� �������� ��� � � Uniteller
	   echo ' <INPUT TYPE="button" onclick="document.forms.uniteller.submit()" value="O������� MasterCard">';
           include(dirname(__FILE__)."/include/uni_form.php");
	  };

}

    /* ----------------- ���� ��� ��������� ---------------------- */ 

else {             

	$status = htmlspecialchars(stripslashes($_GET['status']));                                                                                                    
	
	switch ($status) {
				case 'APPROVED':
					include(dirname(__FILE__)."/include/twpg_approved.php");
					break;
					
				case 'CANCELED':
					echo '<div class="ubr_f">O����� �������� �������������</div>';
					break;
					
				case 'DECLINED':
					if(!empty($_GET['desc'])) $desc = '. ������� ������ - '.$_GET['desc'];
					else $desc ='';
					echo '<div class="ubr_f">O����� ��������� ������'.$desc.'</div>';
					break;

				case '0':
					echo '<div class="ubr_f">O����� �� ���������</div>';                                                                                          //��� ��� ������ �� ����������
					break;		
					
				case '1':
					echo '<div class="ubr_s">O����� ��������� �������, �������� ��������� ������</div>';
					break;			
					
				default:
					# code...
					break;
			}
			
	}
	

?>
