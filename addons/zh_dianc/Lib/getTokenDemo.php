<?php

require_once (IA_ROOT . '/addons/zh_hdbm/Lib/YLYTokenClient.php');
$token = new YLYTokenClient();

//��ȡtoken;
$grantType = 'client_credentials';  //����ģʽ(client_credentials) || ����ģʽ(authorization_code)
$scope = 'all';                     //Ȩ��
$timesTamp = time();                //��ǰ������ʱ���(10λ)
//$code = '';                       //����ģʽ(�̻�code)
echo $token->GetToken($grantType,$scope,$timesTamp);

//ˢ��token;
$grantType = 'refresh_token';       //����ģʽ�򿪷�ģʽһ��
$scope = 'all';                     //Ȩ��
$timesTamp = time();                //��ǰ������ʱ���(10λ)
$RefreshToken = '';                 //ˢ��token����Կ
echo $token->RefreshToken($grantType,$scope,$timesTamp,$RefreshToken);




