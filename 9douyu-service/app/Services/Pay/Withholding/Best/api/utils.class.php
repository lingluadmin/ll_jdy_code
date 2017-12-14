<?php
function getCurrentTime(){
	return date("Ymdhis");
}

function http_post_data($url, $data_string) {  
  
        $ch = curl_init();  
        curl_setopt($ch, CURLOPT_POST, 1);  
        curl_setopt($ch, CURLOPT_URL, $url);  
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
            'Content-Type: application/json; charset=utf-8',  
            'Content-Length: ' . strlen($data_string))  
        );  
        ob_start();  
        curl_exec($ch);  
        $return_content = ob_get_contents();  
        ob_end_clean(); 
        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
        return array($return_code, $return_content);  
    }

function encodeOperations ($array)   
  {   
  	foreach ((array)$array as $key => $value)
  	 {  
  	 	 if (is_array($value)) 
  	 	{   
  	 		 encodeOperations($array[$key]);   } 
  	 	else 
  	 	{   
  	 		$array[$key] = urlencode($value);   
  	 	}  
  	 }   
  	return $array;  
  } 
  
  
/**************************************************************
*
*    ʹ���ض�function������������Ԫ��������
*    @param    string    &$array        Ҫ������ַ���
*    @param    string    $function    Ҫִ�еĺ���
*    @return boolean    $apply_to_keys_also        �Ƿ�ҲӦ�õ�key��
*    @access public
*
*************************************************************/
function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
{
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            arrayRecursive($array[$key], $function, $apply_to_keys_also);
        } else {
            $array[$key] = $function($value);
        }
        if ($apply_to_keys_also && is_string($key)) {
            $new_key = $function($key);
            if ($new_key != $key) {
                $array[$new_key] = $array[$key];
                unset($array[$key]);
            }
        }
    }
}
/**************************************************************
*
*    ������ת��ΪJSON�ַ������������ģ�
*    @param    array    $array        Ҫת��������
*    @return string        ת���õ���json�ַ���
*    @access public
*
*************************************************************/
function JSON_arr2str($array) {
    arrayRecursive($array, 'urlencode', true);
    $json = json_encode($array);
    return urldecode($json);
}
?>