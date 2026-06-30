<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Demo users — one for each role described in the system
        User::updateOrCreate(
            ['email' => 'admin@clothingerp.test'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('Admin@1234'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'cashier@clothingerp.test'],
            [
                'name' => 'Cashier User',
                'password' => Hash::make('Cashier@1234'),
                'role' => 'cashier',
            ]
        );

        User::updateOrCreate(
            ['email' => 'manager@clothingerp.test'],
            [
                'name' => 'Manager User',
                'password' => Hash::make('Manager@1234'),
                'role' => 'manager',
            ]
        );

        // Sample products
        $products = [
            ['product_name' => "Men's Cotton T-Shirt", 'category' => 'Men', 'price' => 15.99, 'quantity' => 50],
            ['product_name' => "Women's Floral Dress", 'category' => 'Women', 'price' => 34.99, 'quantity' => 30],
            ['product_name' => 'Denim Jeans', 'category' => 'Unisex', 'price' => 45.00, 'quantity' => 4],
            ['product_name' => "Kids' Hoodie", 'category' => 'Kids', 'price' => 22.50, 'quantity' => 25],
            ['product_name' => 'Leather Belt', 'category' => 'Accessories', 'price' => 18.00, 'quantity' => 60],
            ['product_name' => 'Winter Jacket', 'category' => 'Outerwear', 'price' => 89.99, 'quantity' => 3],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Sample customers
        $customers = [
            ['name' => 'Aisha Rahman', 'phone' => '0771234567', 'email' => 'aisha@example.com'],
            ['name' => 'Mohamed Faizal', 'phone' => '0779876543', 'email' => 'faizal@example.com'],
            ['name' => 'Nilanthi Perera', 'phone' => '0712345678', 'email' => 'nilanthi@example.com'],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
