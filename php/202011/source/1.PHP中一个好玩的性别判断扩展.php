<?php

$gender = new Gender\Gender;

function showGender($name, $country)
{
    global $gender;
    $result = $gender->get($name, $country);
    var_dump($result);

    $data = $gender->country($country);
    var_dump($data);

    switch ($result) {
        case Gender\Gender::IS_FEMALE:
            printf("%s：女性 - %s\n", $name, $data['country']);
            break;

        case Gender\Gender::IS_MOSTLY_FEMALE:
            printf("%s：大部分情况下是女性 -  %s\n", $name, $data['country']);
            break;

        case Gender\Gender::IS_MALE:
            printf("%s：男性 -  %s\n", $name, $data['country']);
            break;

        case Gender\Gender::IS_MOSTLY_MALE:
            printf("%s：大部分情况下是男性 - %s\n", $name, $data['country']);
            break;

        case Gender\Gender::IS_UNISEX_NAME:
            printf("%s：中性名称（不好确认性别） - \n", $name, $data['country']);
            break;

        case Gender\Gender::IS_A_COUPLE:
            printf("%s：男女都适用 - %s\n", $name, $data['country']);
            break;

        case Gender\Gender::NAME_NOT_FOUND:
            printf("%s：对应的国家字典中没有找到相关信息 -  %s\n", $name, $data['country']);
            break;

        case Gender\Gender::ERROR_IN_NAME:
            echo "给定的姓名信息错误\n";
            break;

        default:
            echo "错误！\n";
            break;

    }
}


showGender("William", Gender\Gender::USA);
// int(77)
// array(2) {
//   ["country_short"]=>
//   string(3) "USA"
//   ["country"]=>
//   string(6) "U.S.A."
// }
// William：男性 -  U.S.A.

showGender("Ayumi Hamasaki", Gender\Gender::JAPAN);
// int(70)
// array(2) {
//   ["country_short"]=>
//   string(3) "JAP"
//   ["country"]=>
//   string(5) "Japan"
// }
// Ayumi Hamasaki：女性 - Japan

showGender("Gang Qiang", Gender\Gender::CHINA);
// int(63)
// array(2) {
//   ["country_short"]=>
//   string(3) "CHN"
//   ["country"]=>
//   string(5) "China"
// }
// Gang Qiang：中性名称（不好确认性别）

showGender("Anna Li", Gender\Gender::CHINA);
// int(70)
// array(2) {
//   ["country_short"]=>
//   string(3) "CHN"
//   ["country"]=>
//   string(5) "China"
// }
// Anna Li：女性 - China

