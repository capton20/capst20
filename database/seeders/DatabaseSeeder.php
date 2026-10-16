<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin default
        User::firstOrCreate(
            ['email' => 'admin@jogokopi.com'],
            [
                'name' => 'Admin JOGO Kopi',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Kasir default
        User::firstOrCreate(
            ['email' => 'kasir@jogokopi.com'],
            [
                'name' => 'Kasir JOGO Kopi',
                'password' => Hash::make('password'),
                'role' => 'kasir',
                'email_verified_at' => now(),
            ]
        );

        // Kategori
        $kategoriEspresso = Category::firstOrCreate(
            ['name' => 'Kopi Espresso & Latte'],
            [
                'slug' => Str::slug('Kopi Espresso & Latte'),
                'description' => 'Minuman berbasis espresso dengan susu creamy dan biji kopi pilihan.',
            ]
        );

        $kategoriManual = Category::firstOrCreate(
            ['name' => 'Manual Brew'],
            [
                'slug' => Str::slug('Manual Brew'),
                'description' => 'Kopi single origin Nusantara diseduh dengan teknik V60, Japanese, dan Aeropress.',
            ]
        );

        $kategoriNonKopi = Category::firstOrCreate(
            ['name' => 'Minuman Non-Kopi'],
            [
                'slug' => Str::slug('Minuman Non-Kopi'),
                'description' => 'Pilihan segar non-kopi seperti Matcha, Cokelat, dan Artisan Tea.',
            ]
        );

        $kategoriMakanan = Category::firstOrCreate(
            ['name' => 'Makanan & Camilan'],
            [
                'slug' => Str::slug('Makanan & Camilan'),
                'description' => 'Teman bersantai seperti Croissant, Toast, dan French Fries.',
            ]
        );

        // Menu Sampel
        $menus = [
            [
                'category_id' => $kategoriEspresso->id,
                'name' => 'Kopi Susu Gula Aren JOGO',
                'description' => 'Espresso house blend dipadukan dengan susu segar dan gula aren murni khas Jawa Tengah.',
                'price' => 22000,
            ],
            [
                'category_id' => $kategoriEspresso->id,
                'name' => 'Caffe Latte Double Shot',
                'description' => 'Espresso ganda dengan steamed milk lembut berkarakter floral dan nutty.',
                'price' => 26000,
            ],
            [
                'category_id' => $kategoriManual->id,
                'name' => 'V60 Gayo Natural',
                'description' => 'Seduhan manual biji Arabika Aceh Gayo dengan rasa manis buah dan aroma melati.',
                'price' => 28000,
            ],
            [
                'category_id' => $kategoriNonKopi->id,
                'name' => 'Ceremonial Matcha Latte',
                'description' => 'Matcha murni dari Uji Jepang dengan perpaduan susu oat oatmilk yang gurih.',
                'price' => 27000,
            ],
            [
                'category_id' => $kategoriMakanan->id,
                'name' => 'Roti Bakar Kaya Butter',
                'description' => 'Roti panggang renyah dengan selai srikaya buatan rumah dan butter New Zealand.',
                'price' => 20000,
            ],
        ];

        foreach ($menus as $menu) {
            Menu::firstOrCreate(
                ['name' => $menu['name']],
                $menu
            );
        }
    }
}
