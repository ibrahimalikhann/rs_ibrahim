# Ratnasagar App Deployment Guide (DigitalOcean)

## Prerequisite: Push to GitHub
If the automated push fails, please run the following command in your terminal manually to upload your code:
```bash
git push -u origin main
```
*Note: You may need to authenticate with your GitHub username and Personal Access Token (PAT).*

---

## Part 1: Create a DigitalOcean Droplet

1.  **Log in to DigitalOcean** and click **Create** -> **Droplet**.
2.  **Choose Region**: Select a datacenter closest to your users (e.g., Bangalore, Singapore, or London).
3.  **Choose Image**: Select **Ubuntu 24.04 (LTS) x64** (or the latest LTS version).
4.  **Choose Size**:
    *   For this Laravel/Inertia app, the **Basic** plan is sufficient.
    *   Select **Regular CPU** -> **$6/month (1GB RAM / 1 CPU)** or **$12/month (2GB RAM)** for better performance.
5.  **Authentication Method**:
    *   **Recommended**: SSH Key (Upload your local public key).
    *   **Alternative**: Password (Create a strong root password).
6.  **Hostname**: Give it a name (e.g., `ratnasagar-app`).
7.  **Click Create Droplet**.
8.  **Copy the IP Address** once the droplet is created (e.g., `123.45.67.89`).

---

## Part 2: Initial Server Setup (Connect via SSH)

Open your terminal (PowerShell or Command Prompt) and connect:
```bash
ssh root@your_droplet_ip
```
*(Accept the fingerprint by typing `yes` if asked).*

### 1. Update System
```bash
apt update && apt upgrade -y
```

### 2. Install Essentials (Nginx, PHP, MySQL, Git, Unzip, Composer, Node.js)
```bash
# Install Nginx and MySQL
apt install nginx mysql-server -y

# Secure MySQL (Optional but recommended)
mysql_secure_installation
# (Press Y for Validation plugin if you want strict passwords, or N. Set a root password.)

# Install PHP 8.2 (or latest) and extensions
add-apt-repository ppa:ondrej/php -y
apt update
apt install php8.2 php8.2-fpm php8.2-mysql php8.2-mbstring php8.2-xml php8.2-bcmath php8.2-curl php8.2-zip php8.2-intl -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Install Node.js (Latest LTS)
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt install -y nodejs
```

---

## Part 3: Deploy the Application

### 1. Clone Repository
```bash
cd /var/www
git clone https://github.com/ibrahimalikhann/rs_ibrahim.git ratnasagar
cd ratnasagar
```

### 2. Install Dependencies
```bash
# PHP Dependencies
composer install --optimize-autoloader --no-dev

# JS Dependencies & Build
npm install
npm run build
```

### 3. Setup Environment Variables
```bash
cp .env.example .env
nano .env
```
**Edit the following in `.env`:**
*   `APP_ENV=production`
*   `APP_DEBUG=false`
*   `APP_URL=http://your_droplet_ip`
*   `DB_CONNECTION=mysql`
*   `DB_HOST=127.0.0.1`
*   `DB_PORT=3306`
*   `DB_DATABASE=ratnasagar_db`
*   `DB_USERNAME=ratna_user`
*   `DB_PASSWORD=your_secure_password`

Target `Ctrl+X`, then `Y`, then `Enter` to save and exit.

### 4. Setup Database
Log into MySQL:
```bash
mysql -u root -p
```
Run SQL commands:
```sql
CREATE DATABASE ratnasagar_db;
CREATE USER 'ratna_user'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON ratnasagar_db.* TO 'ratna_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```
*(Make sure the password matches what you put in `.env`).*

Run Migrations:
```bash
php artisan key:generate
php artisan migrate --force
php artisan storage:link
```

### 5. Set Permissions
```bash
chown -R www-data:www-data /var/www/ratnasagar
chmod -R 775 /var/www/ratnasagar/storage
chmod -R 775 /var/www/ratnasagar/bootstrap/cache
```

---

## Part 4: Configure Nginx (Access via IP)

Create a site configuration:
```bash
nano /etc/nginx/sites-available/ratnasagar
```

**Paste the following configuration (Replace `your_droplet_ip` with your actual IP):**
```nginx
server {
    listen 80;
    server_name your_droplet_ip;
    root /var/www/ratnasagar/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Enable the site and restart Nginx:
```bash
ln -s /etc/nginx/sites-available/ratnasagar /etc/nginx/sites-enabled/
rm /etc/nginx/sites-enabled/default
nginx -t
systemctl restart nginx
```

---

## Done!
Visit `http://your_droplet_ip` in your browser. Your app should be live!
