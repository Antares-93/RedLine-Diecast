<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Pengguna 3 Role
        User::firstOrCreate(
            ['email' => 'admin@redline.test'],
            [
                'name' => 'Owner / Admin Toko',
                'password' => Hash::make('123456'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'staff@redline.test'],
            [
                'name' => 'Staff Gudang RedLine',
                'password' => Hash::make('123456'),
                'role' => 'staff',
            ]
        );

        User::firstOrCreate(
            ['email' => 'customer@redline.test'],
            [
                'name' => 'Dribel Diecaster',
                'password' => Hash::make('123456'),
                'role' => 'customer',
            ]
        );

        // 2. Kategori Diecast
        $catMainline = Category::firstOrCreate(['name' => 'Mainline Reguler'], [
            'description' => 'Diecast reguler standar gantungan retail'
        ]);

        $catPremium = Category::firstOrCreate(['name' => 'Car Culture Premium'], [
            'description' => 'Diecast ban karet (Real Riders) dan full bodi metal'
        ]);

        $catSpecial = Category::firstOrCreate(['name' => 'Red Line Club (RLC) / Chase'], [
            'description' => 'Edisi terbatas kolektor bernomor seri'
        ]);

        $catLargeScale = Category::firstOrCreate(['name' => 'Big Scale Collector'], [
            'description' => 'Model miniatur presisi skala menengah dan besar dengan pintu buka'
        ]);

        // 3. Distributor Pemasok Resmi
        $supMattel = Supplier::firstOrCreate(['name' => 'PT Mattel Distribution Indonesia'], [
            'phone' => '021-5551234',
            'email' => 'order@mattel.co.id',
            'address' => 'Kawasan Industri Cikarang, Jawa Barat'
        ]);

        $supMiniGT = Supplier::firstOrCreate(['name' => 'TSM & Mini GT Official Distributor'], [
            'phone' => '021-8889999',
            'email' => 'supply@minigtindo.com',
            'address' => 'Mangga Dua Square, Jakarta Utara'
        ]);

        $supBburago = Supplier::firstOrCreate(['name' => 'Bburago & Maisto Indonesia Import'], [
            'phone' => '021-7772345',
            'email' => 'sales@bburagoindo.test',
            'address' => 'Gudang Pluit, Jakarta Utara'
        ]);

        // 4. Data Produk dengan Ragam Skala (1:64, 1:43, 1:24, 1:18)
        Product::firstOrCreate(['sku' => 'RL-HW-R34-01'], [
            'category_id' => $catPremium->id,
            'name' => 'Nissan Skyline GT-R (BNR34) Team Transport',
            'brand' => 'Hot Wheels',
            'scale' => '1:64',
            'purchase_price' => 120000,
            'selling_price' => 175000,
            'stock' => 12,
            'minimum_stock' => 3,
        ]);

        Product::firstOrCreate(['sku' => 'RL-HW-CIV-02'], [
            'category_id' => $catMainline->id,
            'name' => "'90 Honda Civic EF Hatchback",
            'brand' => 'Hot Wheels',
            'scale' => '1:64',
            'purchase_price' => 22000,
            'selling_price' => 35000,
            'stock' => 24,
            'minimum_stock' => 5,
        ]);

        Product::firstOrCreate(['sku' => 'RL-BBU-F1-03'], [
            'category_id' => $catLargeScale->id,
            'name' => 'Oracle Red Bull Racing RB19 Max Verstappen #1',
            'brand' => 'Bburago F1',
            'scale' => '1:43',
            'purchase_price' => 160000,
            'selling_price' => 245000,
            'stock' => 9,
            'minimum_stock' => 2,
        ]);

        Product::firstOrCreate(['sku' => 'RL-JAD-FF-04'], [
            'category_id' => $catLargeScale->id,
            'name' => "Brian's Nissan Skyline GT-R R34 Fast & Furious (Diecast Openable)",
            'brand' => 'Jada Toys',
            'scale' => '1:24',
            'purchase_price' => 320000,
            'selling_price' => 460000,
            'stock' => 6,
            'minimum_stock' => 2,
        ]);

        Product::firstOrCreate(['sku' => 'RL-MAI-LAM-05'], [
            'category_id' => $catLargeScale->id,
            'name' => 'Lamborghini Terzo Millennio Grey Metallic Special Edition',
            'brand' => 'Maisto Premiere',
            'scale' => '1:18',
            'purchase_price' => 680000,
            'selling_price' => 950000,
            'stock' => 4,
            'minimum_stock' => 1,
        ]);

        Product::firstOrCreate(['sku' => 'RL-RLC-CAM-06'], [
            'category_id' => $catSpecial->id,
            'name' => "'69 Chevy Camaro Spectraflame Blue (Red Line Club)",
            'brand' => 'Hot Wheels RLC',
            'scale' => '1:64',
            'purchase_price' => 500000,
            'selling_price' => 750000,
            'stock' => 2,
            'minimum_stock' => 3,
        ]);
    }
}