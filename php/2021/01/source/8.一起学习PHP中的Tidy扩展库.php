<?php

$content = <<<EOF
<html><head><title>test</title></head> <body><p>error<br>another line</i></body>
</html>
EOF;

$tidy = new Tidy();
$config = [
        'indent'=>true,
        'output-xhtml'=>true,
];
$tidy->parseString($content, $config);
$tidy->cleanRepair();

echo $tidy, PHP_EOL;
// <html xmlns="http://www.w3.org/1999/xhtml">
//   <head>
//     <title>
//       test
//     </title>
//   </head>
//   <body>
//     <p>
//       error<br />
//       another line
//     </p>
//   </body>
// </html>

var_dump($tidy);
// object(tidy)#1 (2) {
//     ["errorBuffer"]=>
//     string(112) "line 1 column 1 - Warning: missing <!DOCTYPE> declaration
//   line 1 column 70 - Warning: discarding unexpected </i>"
//     ["value"]=>
//     string(195) "<!DOCTYPE html>
//   <html xmlns="http://www.w3.org/1999/xhtml">
//     <head>
//       <title>
//         test
//       </title>
//     </head>
//     <body>
//       <p>
//         error<br />
//         another line
//       </p>
//     </body>
//   </html>"
//   }

var_dump($tidy->isXml()); // bool(false)

var_dump($tidy->isXhtml()); // bool(false)

var_dump($tidy->getStatus()); // int(1)

var_dump($tidy->getRelease());  // string(10) "2017/11/25"

var_dump($tidy->getHtmlVer()); // int(500)

var_dump($tidy->getOpt('indent')); // int(1)

var_dump($tidy->getOptDoc('output-xhtml'));
// string(489) "This option specifies if Tidy should generate pretty printed output, writing it as extensible HTML. <br/>This option causes Tidy to set the DOCTYPE and default namespace as appropriate to XHTML, and will use the corrected value in output regardless of other sources. <br/>For XHTML, entities can be written as named or numeric entities according to the setting of <code>numeric-entities</code>. <br/>The original case of tags and attributes will be preserved, regardless of other options. "


echo $tidy->head(), PHP_EOL;
// <head>
//   <title>
//   test
// </title>
// </head>

$body = $tidy->body();

var_dump($body);
// object(tidyNode)#2 (9) {
//     ["value"]=>
//     string(60) "<body>
//     <p>
//       error<br />
//       another line
//     </p>
//   </body>"
//     ["name"]=>
//     string(4) "body"
//     ["type"]=>
//     int(5)
//     ["line"]=>
//     int(1)
//     ["column"]=>
//     int(40)
//     ["proprietary"]=>
//     bool(false)
//     ["id"]=>
//     int(16)
//     ["attribute"]=>
//     NULL
//     ["child"]=>
//     array(1) {
//       [0]=>
//       object(tidyNode)#3 (9) {
//         ["value"]=>
//         string(37) "<p>
// ………………
// ………………

echo $tidy->html(), PHP_EOL;
// <html xmlns="http://www.w3.org/1999/xhtml">
//   <head>
//     <title>
//       test
//     </title>
//   </head>
//   <body>
//     <p>
//       error<br />
//       another line
//     </p>
//   </body>
// </html>

echo $tidy->root(), PHP_EOL;
// <html xmlns="http://www.w3.org/1999/xhtml">
//   <head>
//     <title>
//       test
//     </title>
//   </head>
//   <body>
//     <p>
//       error<br />
//       another line
//     </p>
//   </body>
// </html>

$tidy = new Tidy();
$repair = $tidy->repairString($content, $config);

echo $repair, PHP_EOL;
// <html xmlns="http://www.w3.org/1999/xhtml">
//   <head>
//     <title>
//       test
//     </title>
//   </head>
//   <body>
//     <p>
//       error<br />
//       another line
//     </p>
//   </body>
// </html>

$html = <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<p>paragraph</p>
HTML;
$tidy = new Tidy();
$tidy->parseString($html);
$tidy->cleanRepair();

echo $tidy->errorBuffer, PHP_EOL;
// line 4 column 1 - Warning: <p> isn't allowed in <head> elements
// line 4 column 1 - Info: <head> previously mentioned
// line 4 column 1 - Warning: inserting implicit <body>
// line 4 column 1 - Warning: inserting missing 'title' element

$tidy ->diagnose();
echo $tidy->errorBuffer, PHP_EOL;
// line 4 column 1 - Warning: <p> isn't allowed in <head> elements
// line 4 column 1 - Info: <head> previously mentioned
// line 4 column 1 - Warning: inserting implicit <body>
// line 4 column 1 - Warning: inserting missing 'title' element
// Info: Doctype given is "-//W3C//DTD XHTML 1.0 Strict//EN"
// Info: Document content looks like XHTML 1.0 Strict
// Tidy found 3 warnings and 0 errors!

$html = <<<EOF
<html><head>
<?php echo '<title>title</title>'; ?>
<#
  /* JSTE code */
  alert('Hello World');
#>
</head>
<body>

<?php
  // PHP code
  echo 'hello world!';
?>

<%
  /* ASP code */
  response.write("Hello World!")
%>

<!-- Comments -->
Hello World
</body></html>
Outside HTML
EOF;

$tidy = new Tidy();
$tidy->parseString($html);

$tidyNode = $tidy->html();

showNodes($tidyNode);

function showNodes($node){

    if($node->isComment()){
        echo '========', PHP_EOL,'This is Comment Node :"', $node->value, '"', PHP_EOL;
    }
    if($node->isText()){
        echo '--------', PHP_EOL,'This is Text Node :"', $node->value, '"', PHP_EOL;
        }
    if($node->isAsp()){
        echo '++++++++', PHP_EOL,'This is Asp Script :"', $node->value, '"', PHP_EOL;
        }
    if($node->isHtml()){
        echo '********', PHP_EOL,'This is HTML Node :"', $node->value, '"', PHP_EOL;
        }
    if($node->isPhp()){
        echo '########', PHP_EOL,'This is PHP Script :"', $node->value, '"', PHP_EOL;
        }
    if($node->isJste()){
        echo '@@@@@@@@', PHP_EOL,'This is JSTE Script :"', $node->value, '"', PHP_EOL;
    }

    if($node->name){
            // getParent()
    if($node->getParent()){
        echo '&&&&&&&& ', $node->name ,' getParent is : ', $node->getParent()->name, PHP_EOL;
    }

    // hasSiblings
    echo '^^^^^^^^ ', $node->name, ' has siblings is : ';
            var_dump($node->hasSiblings());
    echo PHP_EOL;
    }

    if($node->hasChildren()){
            foreach($node->child as $child){
                    showNodes($child);
        }
    }
}

// ………………
// ………………
// ********
// This is HTML Node :"<head>
// <?php echo '<title>title</title>'; ><#
//   /* JSTE code */
//   alert('Hello World');
// #>
// <title></title>
// </head>
// "
// &&&&&&&& head getParent is : html
// ^^^^^^^^ head has siblings is : bool(true)
// ………………
// ………………
// ++++++++
// This is Asp Script :"<%
//   /* ASP code */
//   response.write("Hello World!")
// %>" 
// ………………
// ………………

$html = <<<EOF
<p>test</i>
<bogustag>bogus</bogustag>
EOF;
$config = array('accessibility-check' => 3,'doctype'=>'bogus');
$tidy = new Tidy();
$tidy->parseString($html, $config);

echo 'tidy access count: ', tidy_access_count($tidy), PHP_EOL;
echo 'tidy config count: ', tidy_config_count($tidy), PHP_EOL;
echo 'tidy error count: ', tidy_error_count($tidy), PHP_EOL;
echo 'tidy warning count: ', tidy_warning_count($tidy), PHP_EOL;

// tidy access count: 4
// tidy config count: 2
// tidy error count: 1
// tidy warning count: 6
