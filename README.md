## アプリケーション名

coachtech フリマ

## 環境構築

### Docker ビルド

1.  `git clone git@github.com:kasahara-dev/kasahara-mogi1.git`
2.  `docker-compose up -d --build`

> [!IMPORTANT]
> MySQL は、OS によって起動しない場合があるのでそれぞれの PC に合わせて docker-compose.yml ファイルを編集

### Stripe 設定

1. Stripe テスト用アカウントを取得
2. Stripe コンソール画面よりコンビニ払い、カード払いを有効化

### Laravel 環境構築

1. `docker-compose exec php bash`
2. `composer install`
3. .env.example ファイルから.env を作成し、環境変数を変更(STRIPE_PUBLIC_KEY、STRIPE_SECRET_KEY には Stripe テスト用アカウントの公開鍵、秘密鍵を設定)
4. `php artisan key:generate`
5. `php artisan migrate`
6. `php artisan db:seed`

> [!IMPORTANT]
> "The stream or file could not be opened"エラーが発生した場合
> src ディレクトリにある storage ディレクトリに権限を設定
> `chmod -R 777 storage`

### テスト手順

1. .env ファイルから.env.testing を作成し、環境変数を変更
2. `php artisan key:generate --env=testing`
3. `php artisan config:clear`
4. `php artisan migrate --env=testing`
5. `php artisan test`

## 使用技術

- PHP 8.1.33
- Laravel 8.83.8
- MySQL 8.0.26

## ER 図

![ER図](ER.drawio.png)

## URL

トップページ：http://localhost/

## テストユーザー

- 住所登録済みユーザー メールアドレス：\test1@example.com パスワード：password
- 住所未登録ユーザー メールアドレス：\test2@example.com パスワード：password
