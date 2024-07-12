## 1st Time Setup and Configuration

1. Install Laragon https://laragon.org/download/index.html (recommended) or XAMPP https://www.apachefriends.org/download.html
2. Clone/Download ZIP file of this project repository to your local in `laragon/www` or `xampp/htdocs`
3. Open your project in VS Code and open terminal
4. Run `composer install`
5. Run `npm install`
6. Duplicate .env.example and rename to .env
7. Setup .env file. Please set this variable
    - General
        - APP_URL=https://um-task.test
        - APP_TIMEZONE='Asia/Kuala_Lumpur'
    - Database
        - DB_CONNECTION=mysql
        - DB_HOST=127.0.0.1
        - DB_PORT=3306
        - DB_DATABASE=um_task_db
        - DB_USERNAME=root
        - DB_PASSWORD=
    - Email Gateway (For testing purpose use Mailtrap. For production use real email provider)
        - MAIL_SEND, MAIL_MAILER, MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD, MAIL_ENCRYPTION
8. Run `php artisan key:generate`
9. Run `php artisan migrate` or `php artisan migrate:fresh`
10. Run `php artisan db:seed`
11. Run `php artisan storage:link`
12. Run `php artisan serve` or start Laragon/XAMPP
13. Run `npm run dev`
14. Open browser and go to https://um-task.test (if using Laragon) or http://127.0.0.1:8000 (if using php artisan serve)

### Admin Credential

```
email = admin@example.com
password = password
```
