<?php
		if(!empty($response_order)) {	
		$arFields = array( "PS_STATUS_DESCRIPTION" => $response_order->OrderID[0], "PS_STATUS_MESSAGE" => $response_order->SessionID[0]);
		$is_updated = CSaleOrder::Update(CSalePaySystemAction::GetParamValue("ORDER_ID"), $arFields);	                                     // ��������� ������ �� ������ ������� � ������
		if(!$is_updated) throw new UbrirException(sprintf('��������� ��������� ������ �����. �������� ���� ���������'));
		else $readyToPay = true;	
		}
		else throw new UbrirException(sprintf('������� ������ �� ������ ������ �� �������� �������� ������. ������� ��������� �� ����������.'));
?>

