<?php
    // 正常的GET、POST
    echo $_GET['show'], '<br/>'; // 1
    echo $_POST['name'], '<br/>'; // 提交的内容

    // 使用REQUEST
    echo $_REQUEST['show'], '<br/>'; // 1
    echo $_REQUEST['tel'], '<br/>'; // 提交的内容

    // // register_globals 如果打开
    // echo $name, '<br/>'; // 提交的内容
    // echo $tel, '<br/>'; // 提交的内容

    // // import_request_variables 抱歉，5.4之后已经取消了
    // import_request_variables('pg', 'pg_');
    // echo $pg_show, '<br/>';
    // echo $pg_name, '<br/>';

    extract($_POST, EXTR_PREFIX_ALL, 'ex');
    echo $ex_name, '<br/>'; // 提交的内容
    echo $ex_tel, '<br/>'; // 提交的内容

    

    // 参数名中的.和空格
    echo $_REQUEST['address_prov'], '<br/>'; // 提交的内容
    echo $_REQUEST['address_city'], '<br/>'; // 提交的内容

    // 参数名中的[]
    print_r($_REQUEST['interest']); // Array (v,....) 
    echo '<br />';
    print_r($_REQUEST['edu']); // Array (k/v,....) 

    // php://input
    $content = file_get_contents('php://input');   
    print_r($content); //name=xxx&.....

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <form action="?show=1" method="post">
        姓名：<input type="text" name="name"/><br />
        电话：<input type="text" name="tel"/><br/>

        地址（省）：<input type="text" name="address.prov"/><br/>
        地址（市）：<input type="text" name="address city"/><br/>

        兴趣1：<input type="text" name="interest[]"/><br/>
        兴趣2：<input type="text" name="interest[]"/><br/>
        兴趣3：<input type="text" name="interest[]"/><br/>

        学历1：<input type="text" name="edu[one]"/><br/>
        学历2：<input type="text" name="edu[two]"/><br/>

        <input type="submit" value="提交" >
    </form>
</body>
</html>