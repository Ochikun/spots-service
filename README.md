# 旅日記
  撮った写真や思い出を投稿できるサイトです。 <br>
  地図をクリックすることで日記を投稿することができます。 <br>
  投稿した写真は地図上に画像付きで表示され、クリックすることで詳細画面へ遷移することができます。<br>

<img width="400" alt="spots-image-01" src="https://github.com/user-attachments/assets/a4954801-30e8-45e1-b653-8eb7ee1226e6">
<img width="400" alt="spots-image-02" src="https://github.com/user-attachments/assets/9e3b768e-934c-41ba-b668-0425f97c9b8d">
<img width="350" alt="spots-image-03" src="https://github.com/user-attachments/assets/b7376ac2-ae0d-4a33-a25b-13264b182304">
<img width="400" height="220" alt="Image" src="https://github.com/user-attachments/assets/1ba3a35b-0ea0-48cc-aa35-20471fe70f9f"/><br>

# URL
https://och-sample.com/login <br>
※コストの関係により公開を停止することがございます

サンプルアカウント  <br>
ID: <br>
Password: <br>

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
    - カテゴリ,ワード,投稿日による検索
    - 日付,タイトル順による並び替え
  - 地図・位置情報連携
    - 投稿の地図上マッピング
    - ピンと詳細画面の双方向遷移
    - 現在地に基づいた位置検索

### 技術選定理由
  - Laravel<br>
      　MVCモデルの責務の分離による保守性の向上と将来的な機能拡張の容易さを考慮してLaravelを採用しました。
      　また、Eloquent ORM、認証機能、バリデーションなどを活用することでセキュリティを確保しつつ開発を行いました。

  - AWS<br>
      　スケーラビリティの確保や障害発生時の柔軟性を考慮しAWSを採用しました。
      　S3やRDSによるデータの分離とサーバーのステートレス化を考慮して設計しました。

  - Docker<br>
      　開発環境と本番環境で生じる実行環境の差異を解消するためにDockerを採用しました。
