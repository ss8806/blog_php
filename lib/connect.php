<?php
class connect
{
  // これらの定数を、コンストラクタ内で使います。
  const DB_NAME = "blog";
  const HOST = "localhost";
  const USER = "root";
  const PASS = "root";

  // private $dbh; //connectクラスの中で利用されているので、private
  protected $dbh; // サブクラスのArticleで使えるようにする

  public function __construct()
  { // constを参照するには this ではなく self::
    // DSNとはData Source Name の略で、どのホストのどのDBに接続するのかを示します。
    $dsn = "mysql:host=" . self::HOST . ";dbname=" . self::DB_NAME . ";charset=utf8mb4";
    try {
      // PDOのインスタンスをクラス変数に格納する11
      $this->dbh = new PDO($dsn, self::USER, self::PASS);
    } catch (Exception $e) {
      // Exceptionが発生したら表示して終了
      exit($e->getMessage());
    }

    // DBのエラーを表示するモードを設定
    $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  }

  public function query($sql, $param = null)
  {
    // プリペアドステートメントを作成し、SQL文を実行する準備をする
    $stmt = $this->dbh->prepare($sql);
    // パラメータを割り当てて実行し、結果セットを返す
    $stmt->execute($param);
    return $stmt;
  }
  // 使用例
  // $select = "SELECT * FROM users WHERE name=:name";
  // 第2引数でどのパラメータにどの変数を割り当てるか決める
  // $stmt = $db->query($select, array(':name' => $_POST['name']));
  // レコード1件を連想配列として取得する
  // $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
