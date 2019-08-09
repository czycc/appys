#养生平台 pc+app

### 版本

- `php`: >=7.0.0
- `laravel`: 5.5.*
- `mysql`: >=5.7
- `composer`
- PHP OpenSSL PDO Mbstring Tokenizer XML

### 文件

- `resources/wechat_pay`: 微信支付证书目录

### 配置流程

1. 配置 `.env`

    ```
    cp .env.example .env
    //微信支付 支付宝支付 阿里oss sms
    ```

2. `laravel-admin`

   ```
   php artisan admin:install 
   ```

3. `jwt` 设置密钥

    ```
    php artisan jwt:secret
    ```

4. 自定义命令-生成永久测试token令牌

    ```
    php artisan appys:generate-token
    ```

### 碰见的问题

1. `Transformer`类实例化渲染列表时不能对类变量直接赋值操作
2. 