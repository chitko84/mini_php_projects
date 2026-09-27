# PHP Login System

Features:
- User registration
- Secure password hashing with `password_hash()`
- Login using prepared statements and `password_verify()`
- Session-protected dashboard
- Logout

## Setup
1. Create a MySQL database named `phase11_login`.
2. Import `database.sql`.
3. Update database credentials in `db.php` if needed.
4. Put this folder inside your PHP server directory (for example, XAMPP `htdocs`).
5. Open `register.php`, create an account, then log in through `login.php`.

Default XAMPP database settings used:
- Host: localhost
- User: root
- Password: empty
