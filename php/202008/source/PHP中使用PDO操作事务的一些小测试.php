<?php

$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=blog_test', 'root', '');

// myisam
try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();
    $pdo->exec("insert into tran_myisam (name, age) values ('Joe', 12)");
    $pdo->exec("insert into tran_myisam2 (name, age) values ('Joe', 12)");

    // sleep(30);
    $pdo->commit();

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Failed: " . $e->getMessage(), PHP_EOL;
}

// innodb
try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();
    $pdo->exec("insert into tran_innodb (name, age) values ('Joe', 12)");
    $pdo->exec("insert into tran_innodb2 (name, age) values ('Joe', 12, 3)");

    $pdo->commit();

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Failed: " . $e->getMessage(), PHP_EOL;
}

// innodb
try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();
    $pdo->exec("insert into tran_innodb (name, age) values ('Joe', 12)");
    $pdo->exec("insert into tran_innodb2 (name, age) values ('Joe', 12)");

    // sleep(30);
    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Failed: " . $e->getMessage(), PHP_EOL;
}

// innodb
try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();
    $pdo->exec("insert into tran_innodb (name, age) values ('BW', 12)");
    $pdo->exec("insert into tran_innodb2 (name, age) values ('BW', 12)");

    // sleep(30);
    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Failed: " . $e->getMessage(), PHP_EOL; // Failed: There is already an active transaction
}
