<?php

class YLYHttpClient{

    public static function push($requestInfo,$url)
    {
        $curl = curl_init(); // ����һ��CURL�Ự
        curl_setopt($curl, CURLOPT_URL, $url); // Ҫ���ʵĵ�ַ
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // ����֤֤����Դ�ļ��
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Expect:'
        )); // ������ݰ������ύ
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // ʹ���Զ���ת
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // �Զ�����Referer
        curl_setopt($curl, CURLOPT_POST, 1); // ����һ�������Post����
        curl_setopt($curl, CURLOPT_POSTFIELDS, $requestInfo); // Post�ύ�����ݰ�
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // ���ó�ʱ���Ʒ�ֹ��ѭ
        curl_setopt($curl, CURLOPT_HEADER, 0); // ��ʾ���ص�Header��������
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // ��ȡ����Ϣ���ļ�������ʽ����
        $tmpInfo = curl_exec($curl); // ִ�в���
        if (curl_errno($curl)) {
            echo 'Errno' . curl_error($curl);
        }
        curl_close($curl); // �ؼ�CURL�Ự
        return $tmpInfo; // ��������
    }


}