<?php
require_once (__DIR__.'/lib/YLYOpenApiClient.php');

$api = new YLYOpenApiClient();

$content = '';                          //��ӡ����
$content .= '<FS><center>8����</center></FS>';
$content .= str_repeat('-',32);
$content .= '<FS><table>';
$content .= '<tr><td>��Ʒ</td><td>����</td><td>�۸�</td></tr>';
$content .= '<tr><td>�����ع���</td><td>x1</td><td>��20</td></tr>';
$content .= '<tr><td>�����ļ���</td><td>x1</td><td>��12</td></tr>';
$content .= '<tr><td>��ϳ���</td><td>x1</td><td>��15</td></tr>';
$content .= '</table></FS>';
$content .= str_repeat('-',32)."\n";
$content .= '<FS>���: 47Ԫ</FS>';

$machineCode = '';                      //��Ȩ���ն˺�
$accessToken = '';                      //api��������
$originId = '';                         //�̻��Զ���id
$timesTamp = time();                    //��ǰ������ʱ���(10λ)
echo $api->printIndex($machineCode,$accessToken,$content,$originId,$timesTamp);