## アプリケーション名

coachtech フリマ

## 環境構築

### Docker ビルド

1.  `git clone git@github.com:kasahara-dev/kasahara-mogi1.git`
2.  `cd kasahara-mogi1`
3.  `docker-compose up -d --build`

> [!IMPORTANT]
> MySQL は、OS によって起動しない場合があるのでそれぞれの PC に合わせて docker-compose.yml ファイルを編集

### Stripe 設定

1. Stripe テスト用アカウントを取得
2. Stripe コンソール画面よりコンビニ払い、カード払いを有効化

### Laravel 環境構築

1. `docker compose exec php bash`
2. `composer install`
3. .env.example ファイルから.env を作成し、各環境変数を下記に変更

- `STRIPE_PUBLIC_KEY={Stripe テスト用アカウントの公開鍵}`
- `STRIPE_SECRET_KEY={Stripe テスト用アカウントの秘密鍵}`

4. `php artisan key:generate`
5. `php artisan migrate`
6. `php artisan db:seed`
7. `php artisan storage:link`

> [!IMPORTANT]
> "The stream or file could not be opened"エラーが発生した場合
> src ディレクトリにある storage ディレクトリに権限を設定
> `chmod -R 777 storage`

## テスト手順

1. `docker compose exec mysql bash`
2. `mysql -u root -p`
3. `root`
4. `CREATE DATABASE demo_test;`
5. `exit`
6. `exit`
7. .env ファイルから.env.testing を作成し、各環境変数を下記に変更

- `APP_ENV=test`
- `APP_KEY=`
- `DB_DATABASE=demo_test`
- `DB_USERNAME=root`
- `DB_PASSWORD=root`

8. .env ファイルから.env.dusk.localを作成し、各環境変数を下記に変更

- `APP_ENV=testing`
- `APP_URL=http://nginx`

9. `docker compose exec php bash`
10. `php artisan key:generate --env=testing`
11. `php artisan config:clear`
12. `php artisan migrate --env=testing`
13. `composer require --dev laravel/dusk`
14. `php artisan dusk:install`
15. `php artisan dusk:make LoginTest`
16. `php artisan test`
17. `php artisan dusk`

## 使用技術

- PHP 8.1.33
- Laravel 8.83.8
- MySQL 8.0.26

## テーブル仕様

### usersテーブル

| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | unsigned bigint | 〇 | | 〇 | |
| name | string | | | 〇 | |
| email | string | | 〇 | 〇 | | |
| email_verified_at | timestamp | | | | |
| password | string | | | 〇 | |
| remember_token | string | | | | |
| created_at | timestamp | | | | |
| updated_at | timestamp | | | | |

### profilesテーブル

| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | unsigned_bigint | 〇	| | 〇 | |
| user_id | unsigned_bigint | | | 〇 | users(id) |
| img_path | string | | | | |
| address_id | unsigned_bigint | | | | addresses(id) |
| created_at | timestamp | | | | |
| updated_at | timestamp | | | | |

### itemsテーブル

| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id	| unsigned_bigint | | | 〇 | |
| user_id | unsigned_bigint | | | 〇 | users(id) |
| img_path | string | | | 〇 | |
| condition | tynyint | | | 〇 | |
| name | string | | | 〇 | |
| brand | string | | | | |
| detail | string | | | 〇 | |
| price	| integer | | | 〇 | |
| created_at | timestamp | | | | |
| updated_at | timestamp | | | | |

### addressesテーブル

| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | unsigned_bigint | 〇 | | 〇 | |
| post_number | string | | | 〇 | |
| address | string | | | 〇 | |
| building | string | | | | |
| created_at | timestamp | | | | |
| updated_at | timestamp | | | | |

### commentsテーブル

| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | unsigned_bigint | 〇 | | 〇 | |
| item_id | unsigned_bigint | | | 〇 | items(id) |
| user_id | unsigned_bigint | | | 〇 | users(id) |
| detail | string | | | 〇 | |
| created_at | timestamp | | | | |
| updated_at | timestamp | | | | |

### purchasesテーブル

| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | unsigned_bigint | 〇 | | 〇 | |
| item_id | unsigned_bigint | | | 〇 | items(id) |
| user_id | unsigned_bigint | | | 〇 | users(id) |
| user_name	string | | | 〇 | |
| payment | tinyint | | | 〇 | |
| post_number | string | | | 〇 | |
| address | string | | | 〇 | |
| building | string | | | | |
| created_at | timestamp | | | | |
| updated_at | timestamp | | | | |

### categoriesテーブル

| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | signeted_bigint | 〇 | | 〇 | |
| name | string | | | 〇 | |
| created_at | timestamp | | | | |
| updated_at | timestamp | | | | |

### favoritesテーブル

| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | signeted_bigint | 〇 | | 〇 | |
| item_id | signeted_bigint | | | 〇 | items(id) |
| user_id | signeted_bigint | | | 〇 | users(id) |
| created_at | timestamp | | | | |
| updated_at | timestamp | | | | |

### category_itemテーブル

| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | signeted_id | 〇 | | 〇 | |
| category_id | signeted_id | | | 〇 | categories(id) |
| item_id | signeted_id | | | 〇 | items(id) |
| created_at | timestamp | | | | |
| updated_at | timestamp | | | | |

## ER 図

![ER図](ER.drawio.png)

## URL

トップページ：http://localhost/

## テストユーザー

- テストユーザー 1(住所登録済みユーザー)メールアドレス：`test1@example.com` パスワード：`password`
- テストユーザー 2(住所未登録ユーザー)メールアドレス：`test2@example.com` パスワード：`password`

> [!IMPORTANT]
> テストデータでは、すでに複数ユーザーで出品、購入、お気に入り、コメント登録がされています
