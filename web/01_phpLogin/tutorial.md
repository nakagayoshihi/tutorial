# チュートリアル
## mysql拡張のインストール
現状ではPHPファイルから、MariaDBへ接続するための拡張既往がインストールされていないため、はじめにインストールを行う。

```
//mysql拡張のインストール
# sudo apt install php8.1-mysql

//mysql拡張の有効化
# sudo vi /etc/php/8.1/fpm/php.ini
 # 下記のコメントを外す
 extension=php_mysqli.dll

# sudo systemctl restart php8.1-fpm
# sudo systemctl restart nginx

```

## PHPにてDBとの接続部分の作成
MariaDBの接続ではMysqliもしくはPDOを用いた方式

詳細は　[Mysqli/PDOの違い](https://www.php.net/manual/ja/mysqli.overview.php)を参照。

MariaDB/MySQLを使うならMysqli、ほかのDBも使うならPDOくらいの認識
