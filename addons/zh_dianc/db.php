<?php
// $mysqli = new mysqli('127.0.0.1', 'hlzhycms', 'zcy2788460', 'hlzhycms');
// if(mysqli_connect_errno())
// {
//     echo mysqli_connect_error();
// }

// //创建mysqli对象方式 2 可以设置一些参数
// $mysqli = mysqli_init();
// $mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 2);//设置超时时间
// $mysqli->real_connect('127.0.0.1', 'hlzhycms', 'zcy2788460', 'hlzhycms'); 
// 
// 


/* Connect to a MySQL server  连接数据库服务器 */
$link = mysqli_connect(
    'localhost',  /* The host to connect to 连接MySQL地址 */
    'hlzhycms',      /* The user to connect as 连接MySQL用户名 */
    'zcy2788460',  /* The password to use 连接MySQL密码 */
    'hlzhycms');    /* The default database to query 连接数据库名称*/

if (!$link) {
    printf("Can't connect to MySQL Server. Errorcode: %s ", mysqli_connect_error());
    exit;
}else
    echo '数据库连接上了！';

/* Close the connection 关闭连接*/
mysqli_close($link);

?>
