<?php
  require_once 'src/common-utils.php';

  $db_login = get_json('.login/db.json');
  $dsn = "mysql:host={$db_login->host};dbname={$db_login->db};charset={$db_login->charset}";

  $options = [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
  ];

  try {
      $pdo = new PDO($dsn, $db_login->user, $db_login->pass, $options);
  } catch (PDOException $e) {
      throw new PDOException($e->getMessage(), (int) $e->getCode());
  }
