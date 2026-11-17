# Student Record Management System

A beginner-friendly PHP + MariaDB CRUD application for the IT412 Systems Administration and Maintenance final PIT.

## Features
- Administrator login/logout
- Dashboard with total student count and recent records
- Add, list, search, edit, and delete student records
- PDO prepared statements, password hashing, output escaping, and CSRF tokens
- Responsive Bootstrap interface

## Requirements
- Ubuntu Server
- Apache2
- PHP 8.1+ with `php-mysql`
- MariaDB
- Git (optional)

## 1. Create the database and application user

Log in to MariaDB as an administrator:

```bash
sudo mariadb
```

Run these SQL commands (replace the example password with a strong unique password):

```sql
CREATE DATABASE student_records_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'student_app'@'localhost' IDENTIFIED BY 'ChangeThis_DB_Password_123!';
GRANT SELECT, INSERT, UPDATE, DELETE ON student_records_db.* TO 'student_app'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

Import the schema:

```bash
sudo mariadb student_records_db < database.sql
```

If `database.sql` reports that the database already exists, that is okay; it uses `IF NOT EXISTS`.

## 2. Configure PHP database connection

Edit `config/database.php` and set `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASS` to match the database credentials created above.

## 3. Deploy to Apache

For a simple class deployment:

```bash
sudo mkdir -p /var/www/html/student-records
sudo cp -r . /var/www/html/student-records/
sudo chown -R root:www-data /var/www/html/student-records
sudo find /var/www/html/student-records -type d -exec chmod 755 {} \;
sudo find /var/www/html/student-records -type f -exec chmod 644 {} \;
sudo systemctl reload apache2
```

Open `http://SERVER_IP/student-records/`.

## 4. Create the first administrator

Open:

`http://SERVER_IP/student-records/setup_admin.php`

Create an administrator username and a password of at least 10 characters. Then immediately remove the setup page:

```bash
sudo rm /var/www/html/student-records/setup_admin.php
```

Log in at:

`http://SERVER_IP/student-records/login.php`

## 5. Required packages (Ubuntu)

```bash
sudo apt update
sudo apt install apache2 mariadb-server php libapache2-mod-php php-mysql php-mbstring php-xml git -y
sudo systemctl enable --now apache2 mariadb
```

## 6. Network access

In VirtualBox, use a Bridged Adapter if the host's network permits it. Find the Ubuntu IP:

```bash
hostname -I
```

From another computer on the same LAN/Wi-Fi, open:

`http://SERVER_IP/student-records/`

If UFW is enabled:

```bash
sudo ufw allow 80/tcp
sudo ufw status
```

Both devices must be on the same reachable LAN. Some Wi-Fi networks enable client isolation, which blocks device-to-device access.

## 7. Monitoring commands for the report

```bash
uptime
free -h
df -h
du -sh /var/www/html/student-records
top
ps aux | grep -E 'apache2|mariadbd'
```

## Security notes
- Change the sample database password before deployment.
- Use a strong administrator password.
- Delete `setup_admin.php` immediately after creating the first admin.
- Do not expose this class project directly to the public internet without HTTPS and additional hardening.
- Keep MariaDB bound to localhost; client computers access the application through Apache, not directly through the database.
