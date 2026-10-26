# RedLine - Diecast 

**Max Out Your Collection.**  
> Platform e-commerce katalog dan manajemen inventaris miniatur mobil diecast kolektor berbasis web, terintegrasi secara otomatis dengan payment gateway Midtrans Snap API.

---

##  Daftar Isi
- [Gambaran Umum](#-gambaran-umum)
- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [Entity Relationship Diagram (ERD)](#-entity-relationship-diagram-erd)
- [Struktur Database & Entitas](#-struktur-database--entitas)
- [Panduan Instalasi](#-panduan-instalasi)
- [Konfigurasi Midtrans Gateway](#-konfigurasi-midtrans-gateway)
- [Simulasi & Pengujian Pembayaran](#-simulasi--pengujian-pembayaran)

---

## Gambaran Umum

**RedLine - Diecast** dirancang untuk menghubungkan kolektor diecast (*scale model cars*) dengan ketersediaan stok fisik toko secara transparan dan terkurasi. 

Sistem ini memiliki dua antarmuka utama:
1. **Collector Storefront:** Etalase interaktif bertema gelap (*modern dark mode*) dengan penyaringan kategori, detail kemasan blister (*card & bubble mint condition*), checkout langsung, dan nota faktur digital.
2. **Backoffice / Petugas:** Panel operasional inventaris terpadu untuk monitoring omzet berkala via grafik analitik harian, pengawasan stok minimum, dan pembukuan restock distributor resmi (PO).

---

## Fitur Utama

### Kolektor / Customer
* **Katalog Diecast Dinamis:** Filter dan pencarian langsung berdasarkan nama model, brand (Hot Wheels, Mini GT, Bburago), SKU unik, dan jenis blister.
* **Featured Showcase:** Penayangan kurasi diecast langka mingguan di halaman beranda.
* **Integrasi Snap Midtrans:** Dukungan multi-metode pembayaran: Virtual Account (BCA, BNI, BRI), Mandiri Bill, e-Wallet, dan QRIS.
* **Nota & Struk Digital:** Faktur instan dengan nomor invoice terenkripsi, rincian biaya, dan pencatatan metode pembayaran otomatis.
* **Pengurangan Stok Otomatis:** Pemotongan stok fisik secara atomik segera setelah transaksi terverifikasi lunas.

### Admin & Staf Gudang
* **Dashboard Ringkasan Operasional:**
  * Metrik utama: Total varian diecast, unit fisik tersedia, total omzet lunas, dan volume transaksi.
  * **Grafik Tren Omzet 7 Hari:** Visualisasi garis dinamis performa pendapatan harian bertenaga Chart.js.
  * **Peringatan Stok Kritis:** Notifikasi otomatis saat stok berada pada atau di bawah batas minimum (*threshold*).
* **Restock Distributor (PO):** Pencatatan barang masuk dari agen resmi lengkap dengan rincian unit dan harga modal.
* **Dialog Konfirmasi Logout:** Modal konfirmasi sebelum mengakhiri sesi untuk mencegah insiden salah klik.

---

## Akun Demo 

Gunakan akun pengujian bawaan seeder berikut:

| Role | Email | Password | Hak Akses |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin@redline.test` | `123456` | Akses penuh dashboard, PO, dan master data |
| **Staff Gudang** | `staff@redline.test` | `123456` | Kelola stok masuk dan Restock (PO) |
| **Customer 1** | `customer@redline.test` | `123456` | Beli unit diecast dan lihat nota pesanan |
| **Customer 2** | `bagas@redline.test` | `123456` | Beli unit diecast dan lihat nota pesanan |

---

## Tech Stack

* **Backend:** Laravel 12 (PHP 8.2+)
* **Database:** MySQL
* **Frontend:** Blade Templating, Bootstrap 5, Custom Dark CSS
* **Visualisasi & Ikon:** Chart.js, FontAwesome 6
* **Payment Gateway:** Midtrans Snap API (Sandbox & Production Ready)

---

## Entity Relationship Diagram (ERD)

Diagram di bawah ini menggambarkan struktur entitas database dan relasi relasional yang digunakan:

## 🗄️ Entity Relationship Diagram (ERD)

![ERD RedLine Diecast](docs/erd-RedLine.png)

---

## Struktur Database & Entitas

| Entitas | Deskripsi Fungsional |
| :--- | :--- |
| **`users`** | Menyimpan identitas akun pengguna toko, autentikasi, dan pembagian hak akses (*role*). |
| **`products`** | Master inventaris miniatur diecast mencakup harga jual, estimasi kulakan, stok fisik aktual, serta batas stok minim. |
| **`sales`** | Rekam induk faktur pesanan konsumen, status pembayaran (*pending/paid*), token Snap, dan jalur pembayaran (*payment type*). |
| **`sale_items`** | Detail baris transaksi pemesanan (koleksi diecast yang dipilih, kuantitas, harga satuan, dan subtotal). |
| **`suppliers`** | Data prinsipal pabrikan dan distributor penyuplai stok fisik (PT Mattel, PT Mini GT, dsb). |
| **`purchases`** | Berkas PO (*Purchase Order*) barang masuk ke gudang toko. |
| **`purchase_items`** | Detail unit produk diecast dan harga kulakan yang dipesan saat transaksi restock berjalan. |

---

## Panduan Instalasi

Ikuti langkah-langkah berikut untuk menjalankan aplikasi pada lingkungan lokal:

### 1. Clone Repositori
```bash
git clone https://github.com/Antares-93/RedLine-Diecast.git
cd RedLine-Diecast
```

### 2. Instalasi Dependensi PHP
```bash
composer install
```

### 3. Konfigurasi Lingkungan (`.env`)
Salin berkas konfigurasi template ke `.env`:
```bash
cp .env.example .env
```

Buka berkas `.env` dan sesuaikan koneksi database MySQL:
```env
APP_NAME=RedLine
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=redline
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Kunci & Migrasi Database
```bash
php artisan key:generate
php artisan migrate --seed
```

### 5. Hubungkan Folder Storage
Buat tautan simbolik agar gambar unit blister diecast dapat diakses oleh publik:
```bash
php artisan storage:link
```

### 6. Jalankan Web Server
```bash
php artisan serve
```
Akses aplikasi melalui browser di `http://127.0.0.1:8000`.

---

## Konfigurasi Midtrans Gateway

Dapatkan kredensial pengujian dari akun [Midtrans Sandbox](https://dashboard.sandbox.midtrans.com/) pada menu **Settings > Access Keys**, kemudian tambahkan ke berkas `.env`:

```env
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

---

## Simulasi & Pengujian Pembayaran

Saat menguji transaksi di localhost tanpa konfigurasi public webhook/ngrok:

1. Pilih diecast di katalog, lalu klik checkout hingga popup **Midtrans Snap** terbuka.
2. Pilih bank pembayaran (disarankan **BCA Virtual Account** atau **BNI/BRI**).
3. Salin nomor Virtual Account yang diterbitkan di popup.
4. Buka tab baru menuju [Midtrans Payment Simulator](https://simulator.sandbox.midtrans.com/).
5. Masukkan nomor VA, klik **Inquire**, lalu klik **Pay**.
6. Kembali ke web RedLine dan klik tombol **Return to merchant's page**.
7. Sistem otomatis:
   * Mengubah status pesanan menjadi **Lunas (Completed)**.
   * Merekam label metode pembayaran (contoh: *BCA Virtual Account*) ke nota.
   * Memotong stok unit fisik diecast terkait.
