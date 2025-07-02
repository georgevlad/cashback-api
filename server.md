Here is your Hetzner server documentation exported in **Markdown format**:

---

````markdown
# 📘 Hetzner Server Setup Documentation (Giga Project)

## 🖥️ Server Overview

- **Provider**: Hetzner
- **CPU**: AMD Ryzen 5 3600
- **RAM**: 64 GB DDR4
- **Storage**: 2 × SSD M.2 NVMe 512 GB
- **OS**: Ubuntu 22.04 LTS
- **Hostname**: Configured with multiple subdomains (`importer.gvs.plus`, `cashback-api.gvs.plus`, `cashback.gvs.plus`)
- **Used for**:
  - Go importer app
  - Laravel API
  - React frontend app
  - MySQL database server

---

## 🛠️ Initial Server Setup

### 1. Add a new user and configure SSH
```bash
adduser gvs
usermod -aG sudo gvs
rsync --archive --chown=gvs:gvs ~/.ssh /home/gvs
````

### 2. Install basic stack

```bash
sudo apt update && sudo apt upgrade
sudo apt install nginx mysql-server php php-mysql php-cli php-fpm git curl unzip
```

### 3. Install Go (example)

```bash
wget https://golang.org/dl/go1.23.3.linux-amd64.tar.gz
sudo tar -C /usr/local -xzf go1.23.3.linux-amd64.tar.gz
echo 'export PATH=$PATH:/usr/local/go/bin' >> ~/.bashrc
source ~/.bashrc
```

### 4. Configure Nginx

Example for React app:

```nginx
server {
    server_name cashback.gvs.plus;
    root /var/www/cashback.gvs.plus;
    index index.html;

    location / {
        try_files $uri $uri/ /index.html;
    }

    listen 443 ssl;
    ssl_certificate /etc/letsencrypt/live/cashback.gvs.plus/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/cashback.gvs.plus/privkey.pem;
}
```

Enable site:

```bash
ln -s /etc/nginx/sites-available/cashback.gvs.plus /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

---

## 🔒 HTTPS with Certbot

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d cashback.gvs.plus
```

Renew manually:

```bash
sudo certbot renew --dry-run
```

---

## 💾 MySQL

### Access:

```bash
mysql -u root -p
```

### Create DB and user:

```sql
CREATE DATABASE cashback_api;
CREATE USER 'cashback_user'@'localhost' IDENTIFIED BY 'strongpassword';
GRANT ALL PRIVILEGES ON cashback_api.* TO 'cashback_user'@'localhost';
FLUSH PRIVILEGES;
```

---

## 🐘 Laravel API

**Path**: `/var/www/cashback-api`

Common commands:

```bash
php artisan migrate
php artisan queue:work
php artisan schedule:run
```

Set permissions:

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
```

Set environment:

```bash
cp .env.example .env
php artisan key:generate
```

---

## 🟢 Go Importer

**Path**: `/home/gvs/importer`

Build and run:

```bash
go build -o importer ./cmd
./importer
```

Use with `LOAD DATA LOCAL INFILE`:

```go
mysql.RegisterLocalFile(filePath)
```

---

## 🔁 PM2 (for React app)

```bash
pm2 start npm --name "cashback" -- start
pm2 restart cashback
pm2 logs cashback
pm2 list
```

---

## 🔍 Useful Commands

| Task                      | Command                                  |
| ------------------------- | ---------------------------------------- |
| Restart Nginx             | `sudo systemctl restart nginx`           |
| View Laravel logs         | `tail -f storage/logs/laravel.log`       |
| View latest logs only     | `tail -n 100 storage/logs/laravel.log`   |
| Enable daily Laravel logs | In `.env`: `LOG_CHANNEL=daily`           |
| MySQL status              | `systemctl status mysql`                 |
| Restart MySQL             | `sudo systemctl restart mysql`           |
| SSH tunnel for HeidiSQL   | `ssh -L 3307:127.0.0.1:3306 gvs@your-ip` |

---

## 🔄 Laravel Scheduled Jobs

Jobs defined in `app/Console/Kernel.php`:

```php
Schedule::job(new AwinMerchantsJob())->everyTwoHours()->at('00');
```

Run manually:

```bash
php artisan schedule:run
```

Set up cron:

```bash
* * * * * cd /var/www/cashback-api && php artisan schedule:run >> /dev/null 2>&1
```

---

## ✅ Tips for New Users

1. Use the `gvs` user (with `sudo`) for safety and access.
2. Always validate Nginx configs: `nginx -t`.
3. Restart necessary services after changes.
4. Back up MySQL regularly using `mysqldump`.
5. PM2 is used for Node/React apps. Laravel uses systemd queue workers or `php artisan`.

```

---

Let me know if you want me to convert this into a `.md` file and attach it directly.
```
