# ミノリginサーバーリポジトリ

## APIサーバーの機能

このAPIサーバーは、クラス管理とオンライン教育のための複数の機能を提供します。主な機能は以下の通りです：

1. **出席情報関連機能**：
  - 特定IDの出席情報の取得、削除、作成/更新。
  - クラス別の全出席情報の取得。

2. **Google認証**：
  - Googleログイン後、ユーザー情報を受け取りトークン生成。
  - ユーザーをGoogleログインページへリダイレクト。

3. **クラスボード（Class Board）**：
  - 特定クラスの全ボードの取得、クラスボードの作成。
  - 公告されたクラスボードの取得。
  - 特定のクラスボードの詳細情報の取得、削除、更新。

4. **クラスコード（Class Code）**：
  - 特定のクラスコードのシークレットの有無を確認。
  - クラスコードとシークレットの検証、ユーザーに役割を割り当て。

5. **クラススケジュール（Class Schedule）**：
  - 特定のクラスIDの全クラススケジュールの取得、新規作成。
  - 特定の日付のクラススケジュールの取得。
  - ライブ中のクラススケジュールの取得。
  - 特定のクラススケジュールの詳細情報の取得、更新、削除。

6. **クラス（Classes）**：
  - 新しいクラスの作成（名前、定員数、説明、画像URLを含む）。

7. **クラスユーザー（Class User）**：
  - 特定ユーザーが参加している全クラスの情報取得。
  - 特定ユーザーの名前の更新、ユーザー役割の変更。

8. **ユーザー（User）**：
  - ユーザーが申し込んだクラスの取得。

また、プロジェクトでは`WebRTC`を通じた`リアルタイムの授業`、`Socket.io`を通じた`リアルタイムのチャット`機能、`クラス関連のCRUD`機能、管理者関連機能が追加予定です。

## ディレクトリ構造

```bash
- project-root/
  ├── constants/
  │    └── 定数の定義
  ├── controllers/
  │    └── ユーザーのリクエスト処理とモデルの操作
  ├── docs/
  │    └── プロジェクトの文書化
  ├── dto/
  │    └── データ転送オブジェクトの定義
  ├── middlewares/
  │    └── 共通ミドルウェアロジック（認証、ログ記録など）
  ├── migration/
  │    └── データベーススキーマ管理
  ├── models/
  │    └── データモデルの定義
  ├── repositories/
  │    └── データベースとの相互作用の抽象化
  ├── services/
  │    └── ビジネスロジックの実装
  └── utils/
       └── ユーティリティ関数と共通コード
```

## 適用されたデザインパターン

### MVC (Model-View-Controller)
- モデル（Model）: /models
  - データ関連のロジック処理。データベースのテーブルやデータ構造を表します。
- コントローラー（Controller）: /controllers
  - ユーザーからのAPIリクエストを受け取り、必要に応じてモデルを利用してデータを操作し、適切なレスポンスを生成します。

### リポジトリパターン（Repository Pattern）
- リポジトリ（Repository）: /repositories
  - データベースとの相互作用をカプセル化し、データアクセスロジックとビジネスロジックを分離。データの取得、保存、更新などの処理を担当します。

### サービスレイヤー（Service Layer）
- サービス（Service）: /services
  - ビジネスロジックを中心に処理。コントローラーとリポジトリの間の仲介者として機能し、ビジネスルールやデータ処理ロジックを担当します。

### DTO（Data Transfer Object）
- DTO: /dto
  - APIリクエストやレスポンスでデータを転送する際に使用されるオブジェクト。必要なデータをカプセル化し、クライアントとサーバー間のデータ交換を効率化します。

### ミドルウェアパターン（Middleware Pattern）
- ミドルウェア（Middleware）: /middlewares
  - リクエスト処理の前後で一般的なタスク（認証、ロギング、エラーハンドリングなど）を処理します。

### ユーティリティ関数（Utility Functions）
- ユーティリティ（Utilities）: /utils
  - 再利用可能なヘルパー関数や一般的なユーティリティ機能を提供します。
