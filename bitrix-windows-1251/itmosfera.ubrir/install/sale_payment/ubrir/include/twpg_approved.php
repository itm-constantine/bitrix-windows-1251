<?php
					$bankHandler = new Ubrir(array(																											 // �������������� ������ �������� � TWPG
							'shopId' => CSalePaySystemAction::GetParamValue("ID"), 
							'order_id' => CSalePaySystemAction::GetParamValue("ORDER_ID"), 
							'sert' => CSalePaySystemAction::GetParamValue("SERT"),
						    'twpg_order_id' => $arOrder['PS_STATUS_DESCRIPTION'], 
						    'twpg_session_id' => $arOrder['PS_STATUS_MESSAGE']
							));
					if($bankHandler->check_status("APPROVED")) {
					CSaleOrder::Update(CSalePaySystemAction::GetParamValue("ORDER_ID"), array("PAYED" => "Y"));   									
					CSaleOrder::StatusOrder(CSalePaySystemAction::GetParamValue("ORDER_ID"), "P");
					echo '<div class="ubr_s">������ ������� ���������</div>';
					}
					else echo '<div class="ubr_f">�������� ������ ������</div>';
?>

