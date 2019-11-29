<?php

/**

 * Created by PhpStorm.

 * User: Administrator

 * Date: 2017/1/6

 * Time: 9:53

 */



include "PHPExcel.php";


/**读取Excel文件

 *$filePath: 文件路径

 */
function getFilePath($filePath)
{
    if(empty($filePath) or !file_exists($filePath)){

        die('file not exists');

    }

    $PHPReader = new PHPExcel_Reader_Excel2007();

    if(!$PHPReader->canRead($filePath)){
        $PHPReader = new PHPExcel_Reader_Excel5();

        if(!$PHPReader->canRead($filePath)){
            echo 'no Excel';

            return ;
        }
    }
    $PHPExcel = $PHPReader->load($filePath);
    return $PHPExcel;
}

/*

 * 数据导入到Excel对象

 * $filePath: 文件的路径

 * $info_arr: 要导入的数据

 * $sheet: excel表单

 * **/

function importData($filePath='', $info_arr=array(), $sheet=0){



    if(empty($filePath) or !file_exists($filePath))

    {

        die('file not exists');

    }

    //建立reader对象

    $PHPReader = new PHPExcel_Reader_Excel2007();

    if(!$PHPReader->canRead($filePath))

    {

        $PHPReader = new PHPExcel_Reader_Excel5();

        if(!$PHPReader->canRead($filePath))

        {

            echo 'no Excel';

            return ;

        }

    }

    //建立excel对象

    $PHPExcel = $PHPReader->load($filePath);

    //**读取excel文件中的指定工作表*/

    $currentSheet = $PHPExcel->getSheet($sheet);

    //**取得最大的列号*/

    $allColumn = $currentSheet->getHighestColumn();

    //获取最大行数

    $allRow = $currentSheet->getHighestRow();



    //设置插入起始行数, 这里用获取的行数计算。可以自行根据模板进行设置固定数值

    $i = $allRow + 1;



    //遍历查询出来的数据, 根据行数一次插入表单中

    //如果数据多可以用嵌套循环赋值.

    foreach($info_arr as $data){

        $startColumn = 'A';

        foreach($data as $value)

        {

            if($startColumn == 'A')
            {
                $currentSheet->setCellValue($startColumn . $i, $value."");

            } else
            {
                $currentSheet->setCellValue($startColumn . $i, $value);
            }


            $startColumn++;

        }

        $i++;

    }

    return $PHPExcel;



}
function importDataForObj($info_arr = array(), $title=array(), $sheet = 0, $type = 2007){


    $PHPExcel = new PHPExcel();

    if ($type == 2007)
    {
        $PHPExcel->getProperties()->setCreator("ctos")
            ->setLastModifiedBy("ctos")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
    }


    //**读取excel文件中的指定工作表*/

    $currentSheet = $PHPExcel->getSheet($sheet);
    /*设置工作薄名称*/
    $currentSheet->setTitle(iconv('gbk', 'utf-8', 'appointment'));

    $startColumnTitle = "A";
    foreach ($title as $item)
    {
        $currentSheet->getColumnDimension($startColumnTitle)->setWidth(18);
        $currentSheet->getStyle($startColumnTitle)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
        $currentSheet->setCellValue($startColumnTitle . "1", $item);
        $startColumnTitle++;
    }
    //**取得最大的列号*/

    $allColumn = $currentSheet->getHighestColumn();

    //获取最大行数
    $allRow = $currentSheet->getHighestRow();


    //设置插入起始行数, 这里用获取的行数计算。可以自行根据模板进行设置固定数值

    $i = $allRow + 1;


    //遍历查询出来的数据, 根据行数一次插入表单中

    //如果数据多可以用嵌套循环赋值.

    foreach($info_arr as $data){

        $startColumn = 'A';

        foreach($data as $value)

        {

            if($startColumn == 'A')
            {
                $currentSheet->setCellValue($startColumn . $i, " ".$value);

            } else
            {
                $currentSheet->setCellValue($startColumn . $i, $value);
            }


            $startColumn++;

        }

        $i++;

    }

    return $PHPExcel;



}

/*

 * 带字段数据导入

 * $filePath

 ** $info_arr: 要导入的数据

 * $sheet: excel表单

 * **/

function importFileData($filePath='', $info_arr=array(), $sheet=0)

{

    if(empty($filePath) or !file_exists($filePath))

    {

        die('file not exists');

    }

    /*建立reader对象*/

    $PHPReader = new PHPExcel_Reader_Excel2007();

    if(!$PHPReader->canRead($filePath))

    {

        $PHPReader = new PHPExcel_Reader_Excel5();

        if(!$PHPReader->canRead($filePath))

        {

            echo 'no Excel';

            return ;

        }

    }

    /*建立excel对象*/

    $PHPExcel = $PHPReader->load($filePath);

    //**读取excel文件中的指定工作表*/

    $currentSheet = $PHPExcel->getSheet($sheet);

    //**取得最大的列号*/

    $allColumn = $currentSheet->getHighestColumn();

    //获取最大行数

    $allRow = $currentSheet->getHighestRow();

    //设置插入起始行数, 这里用获取的行数计算。可以自行根据模板进行设置固定数值

    $i = $allRow + 2;

    //遍历查询出来的数据, 根据行数一次插入表单中

    //如果数据多可以用嵌套循环赋值.

    foreach($info_arr as $data){

        $startColumn = 'A';



        foreach($data as $key=>$value)

        {

            $currentSheet->setCellValue($startColumn . "1", $key);

            $currentSheet->setCellValue($startColumn . $i, $value);

            $startColumn++;

        }

        $i++;

    }



    return $PHPExcel;

}

/*新建文件, 自定义表单与内容*/

/* 创建Excel对象

 * 数据导入到Excel对象

 * $keyData: 表单内容字段(每列内容标题)

 * $data: 要导入的数据

 * $sheet: excel表单

 * **/

function createExcel($keyData = array(), $data = array(), $sheet = 0)

{

    $objPHPExcel = new PHPExcel();

    $currentSheet = $objPHPExcel->setActiveSheetIndex($sheet);

    $startColumn = 'A';

    foreach($keyData as $value)

    {

        $currentSheet->setCellValue($startColumn . "1", $value);

        $startColumn++;

    }

    $i = 2;

    foreach($data as $data_one)

    {

        $startColumn = 'A';

        foreach($data_one as $key=>$value)

        {

            $currentSheet->setCellValue($startColumn . $i, $value);
            $currentSheet->getStyle($startColumn . $i)->getAlignment()->setWrapText(true);

            $startColumn++;

        }

        $i++;

    }





    return $objPHPExcel;

}

/*获取数关联数组*/

/*

 * 获取已存在模板文件的数据

 * $filePath: 文件路径

 * $starRow: 数据所在表格的起始行数

 * $title: 标题开始的位置, 即获取数组的索引

 * endRow: 数据结束表单所剩的行数(即数据开始于数据结束的位置 *数据起始位置为正数,结束为倒数)

 * $sheet: 获取表单

 * **/

function getFiledData($filePath='',$startRow = 2, $titleNum = 1, $endRow = 0, $sheet = 0)

{

    if(empty($filePath) or !file_exists($filePath))

    {

        die('file not exists');

    }

    $PHPReader = new PHPExcel_Reader_Excel2007();        //建立reader对象

    if(!$PHPReader->canRead($filePath))

    {

        $PHPReader = new PHPExcel_Reader_Excel5();

        if(!$PHPReader->canRead($filePath))

        {

            echo 'no Excel';

            return ;

        }

    }

    //建立excel对象

    $PHPExcel = $PHPReader->load($filePath);

    //**读取excel文件中的指定工作表*/

    $currentSheet = $PHPExcel->getSheet($sheet);

    //**取得最大的列号*/

    $allColumn = $currentSheet->getHighestColumn();

    //**取得一共有多少行*/

    $allRow = $currentSheet->getHighestRow() - $endRow;

    $data = array();

    $count = 0;



    //获取字段

    $title = array();

    for($colIndex='A';$colIndex<=$allColumn;$colIndex++)

    {

        $addr = $colIndex.$titleNum;

        $cell = $currentSheet->getCell($addr)->getValue();

        if($cell instanceof PHPExcel_RichText)

        {

            //富文本转换字符串

            $cell = $cell->__toString();

        }

        $title[$colIndex] = $cell;

    }

    //循环读取每个单元格的内容。 列从A开始

    for($rowIndex=$startRow;$rowIndex<=$allRow;$rowIndex++)

    {

        for($colIndex='A';$colIndex<=$allColumn;$colIndex++)

        {

            $addr = $colIndex.$rowIndex;

            $cell = $currentSheet->getCell($addr)->getValue();

            if($cell instanceof PHPExcel_RichText)

            {

                //富文本转换字符串

                $cell = $cell->__toString();



            }

            //判断单元格内容是否为公式

            $cell_one = substr($cell, 0, 1);

            if($cell_one == '=')

            {
                /*取公式计算后的结果*/
                $value = $currentSheet->getCell($addr)->getFormattedValue();

                $cell = $value;

            }

            $key = $title[$colIndex];

            $data[$rowIndex][$key] = $cell;

        }

        $count++;

    }



    return $data;

}



/*获取索引数组*/
/*

 * 获取已存在模板文件的数据

 * $filePath: 文件路径

 * $starRow: 数据所在表格的起始行数

 * $title: 标题开始的位置, 即获取数组的索引

 * endRow: 数据结束表单所剩的行数(即数据开始于数据结束的位置 *数据起始位置为正数,结束为倒数)

 * $sheet: 获取表单

 * **/
function getData($filePath='',$startRow = 2, $endRow = 0, $sheet = 0)

{

    if(empty($filePath) or !file_exists($filePath))

    {

        die('file not exists');

    }

    //建立reader对象

    $PHPReader = new PHPExcel_Reader_Excel2007();

    if(!$PHPReader->canRead($filePath))

    {

        $PHPReader = new PHPExcel_Reader_Excel5();

        if(!$PHPReader->canRead($filePath))

        {

            echo 'no Excel';

            return ;

        }

    }

    //建立excel对象

    $PHPExcel = $PHPReader->load($filePath);

    //**读取excel文件中的指定工作表*/

    $currentSheet = $PHPExcel->getSheet($sheet);

    //**取得最大的列号*/

    $allColumn = $currentSheet->getHighestColumn();

    //**取得一共有多少行*/

    $allRow = $currentSheet->getHighestRow() - $endRow;

    $data = array();



    //循环读取每个单元格的内容。 列从A开始

    for($rowIndex=$startRow;$rowIndex<=$allRow;$rowIndex++)

    {

        $cellArray = array();

        for($colIndex='A';$colIndex<=$allColumn;$colIndex++)

        {

            $addr = $colIndex.$rowIndex;

            $cell = $currentSheet->getCell($addr)->getValue();

            if($cell instanceof PHPExcel_RichText)

            {

                //富文本转换字符串

                $cell = $cell->__toString();



            }

            //判断单元格内容是否为公式

            $cell_one = substr($cell, 0, 1);

            if($cell_one == '=')

            {

                $value = $currentSheet->getCell($addr)->getFormattedValue();

                $cell = $value;

            }



            $cellArray[] = $cell;

        }

        $data[] = $cellArray;

    }



    return $data;

}

/*

 * 下载文件

 * $PHPObj: excel对象

 * $filename: 下载后的文件名

 * **/

function download($PHPObj,  $filename = 'newBook', $ex = '2007')

{
    /** 清除缓冲区,避免乱码 */

    /** 导出excel2007文档*/
    if($ex == '2007') {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($PHPObj, 'Excel2007');
        $objWriter->save('php://output');
        exit;

        /** 导出excel2003文档 */
    } else {

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($PHPObj, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }


}