##### waerrrrrrrrr 🦖🦖
## 🛠️ Instalasi dan Setup

### 1. Clone Repository

```bash
git clone https://github.com/imdevedugame/jwt-login.git
cd jwt-login
```

### 2. Install Dependency

```bash
composer install
npm install && npm run dev
```

### 3. Copy File .env

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Setup Database

Edit file `.env`:

```
DB_CONNECTION=mysql
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

Lalu migrasi:

```bash
php artisan migrate
```

### 5. Storage Link (untuk gambar tutorial)

```bash
php artisan storage:link
```

### 6. Jalankan Server

```bash
php artisan serve
```

---