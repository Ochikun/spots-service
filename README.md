# 旅日記
  撮った写真や思い出を投稿できるサイトです。 <br>
  地図をクリックすることで日記を投稿することができます。 <br>
  投稿した写真は地図上に画像付きで表示され、クリックすることで詳細画面へ遷移することができます。<br>

  ここにイメージを置く <br>

# URL
https://och-sample.com/login
サンプルアカウント
ID:
Password:

# 使用技術

### バックエンド / フロントエンド
- **Language:** PHP 8.4 / JavaScript
- **Framework:** Laravel 12.46.0
- **CSS:** Tailwind CSS
- **Library:** intervention image / Leaflet.js

### インフラ / 実行環境
- **Server:** Nginx
- **Container** Docker
- **Cloud(AWS):**
  - ALB
  - VPC
  - EC2 / Ubuntu
  - RDS / MySQL
  - S3
  - Route53
  - ACM

### インフラ構成図
<img width="995" alt="AWSインフラ構成図" src="https://github.com/user-attachments/assets/77521691-1deb-4295-b1cb-bb81af7c38ab">

### 機能一覧
  - ユーザ認証・管理機能
    - 会員登録,ログイン,編集
  - 日記・画像管理機能
    - 日記のCRUD機能
    - 画像の変換,保存
  - 日記一覧 ・ 詳細表示
  - 検索・ソート機能
    - タグ, キーワードによる検索
    - 日付順,～～～～による並び替え
  - 地図・位置情報連携
    - 投稿の地図上マッピング
    - ピンと詳細画面の双方向遷移
    - 現在地に基づいた位置検索
