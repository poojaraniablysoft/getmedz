<?php
class Paymentgateway extends Model {
	const PAYMENT_GATEWAY_TYPE_PAYPAL = 1;
	const PAYPAL_TOKEN = 'zzzzzzzzzzzzzzzzzzzz';
	const PAYPAL_URL = 'www.sandbox.paypal.com';
	
	function isPaymentSuccess($payment_gateway, $order_id, $post, &$response){
		if($payment_gateway == self::PAYMENT_GATEWAY_TYPE_PAYPAL){
			
			$url = "https://".self::PAYPAL_URL. "/cgi-bin/webscr";
			//mail('priyanka@ablysoft.com','paypal reponse 1',$url);
			//$post_vars = "cmd=_notify-synch&tx=" . $order_id . "&at=" . self::PAYPAL_TOKEN;
		
		
			$post_vars = 'cmd=_notify-validate';
			foreach ($post as $key => $value) {
				$post_vars .= '&' . $key . '=' . urlencode(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
			}
			
			
			$response .= $post_vars;
			
			if (function_exists('curl_init')) {
				
				/* $ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'https://www.sandbox.paypal.com/cgi-bin/webscr');
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: ' . 'www.sandbox.paypal.com'));
				$res = curl_exec($ch);
				$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				$curl_errno= curl_errno($ch);
				$curl_error = curl_error($ch);
				$response .=$res;
				curl_close($ch); */
				
				

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vars);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch, CURLOPT_TIMEOUT, 15);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_USERAGENT, 'cURL/PHP');

				$res = curl_exec($ch);
				$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				$curl_errno= curl_errno($ch);
				$curl_error = curl_error($ch);
				$response .=$res;
				curl_close($ch);
			
				
				//mail('priyanka@ablysoft.com','paypal response 2', print_r($res.' curl_errno : '.$curl_errno.' curl_error : '.$curl_error.' http_status: '.$http_status, true));
				if($res === false || !empty($curl_errno) || $http_status != 200){
					
					$error ='Curl Error :'.$curl_error.' <br>';
					$error .='Curl Error no. :'.$curl_errno.' <br>';
					$error .='Http Status  :'.$http_status.' <br>';
					self::sendErrorMail($payment_gateway, $order_id, $msg, print_r($res, true));
					return false;
				}
			}
			else {
			//	$res = file_get_contents($url . '?' . $req);
				$res = file_get_contents($url . '?' . $post_vars);
				//mail('priyanka@ablysoft.com','paypal reponse 3', print_r($res, true));
				$response .=$res;
			}
			if (strcmp(strtoupper($res), "VERIFIED") == 0) {
				return true;
			}
			
		}
		return false;
	}
	
	static function sendErrorMail($payment_gateway, $order_id, $error, $response){
		$payment_gateway = self::getPaymentGatewayByKey($payment_gateway);
		$replace_var = array(
							'{payment_gateway}' => $payment_gateway,
							'{order_id}' => $order_id,
							'{error}' => $error,
							'{response}' => $response,
							);
		Email::sendMail(FatApp::getConfig('conf_admin_email_id'),87, $replace_var);
	}
	
	static function getPaymentGateway(){
		return array(
					self::PAYMENT_GATEWAY_TYPE_PAYPAL =>Info::t_lang('PAYPAL')
					);
	}
	static function getPaymentGatewayByKey($key){
		$ar = self::paymentGateway();
		return @$ar[$key];
	}
}

?>