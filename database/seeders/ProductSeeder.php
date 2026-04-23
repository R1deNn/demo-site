<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name'        => 'Механическая клавиатура',
                'description' => 'Тактильные переключатели Cherry MX Brown, RGB подсветка, алюминиевый корпус.',
                'price'       => 899900,
                'in_stock'    => true,
            ],
            [
                'name'        => 'Игровая мышь Razer',
                'description' => 'Оптический сенсор 25 600 DPI, 7 программируемых кнопок, RGB-подсветка.',
                'price'       => 349900,
                'in_stock'    => true,
            ],
            [
                'name'        => 'Монитор 27" 4K IPS',
                'description' => 'Разрешение 3840×2160, время отклика 1 мс, частота 144 Гц, HDR400.',
                'price'       => 5299900,
                'in_stock'    => true,
            ],
            [
                'name'        => 'Наушники Sony WH-1000XM5',
                'description' => 'Активное шумоподавление, 30 часов автономной работы, LDAC.',
                'price'       => 2499900,
                'in_stock'    => false,
            ],
            [
                'name'        => 'SSD Samsung 970 EVO 1TB',
                'description' => 'NVMe M.2, скорость чтения до 3 500 МБ/с, скорость записи до 2 700 МБ/с.',
                'price'       => 699900,
                'in_stock'    => true,
            ],
            [
                'name'        => 'Веб-камера Logitech C920',
                'description' => 'Full HD 1080p при 30 fps, автофокус, встроенный стереомикрофон.',
                'price'       => 599900,
                'in_stock'    => true,
            ],
            [
                'name'        => 'USB-хаб 7 портов',
                'description' => 'USB 3.0, поддержка быстрой зарядки 60 Вт, алюминиевый корпус.',
                'price'       => 99900,
                'in_stock'    => false,
            ],
            [
                'name'        => 'Коврик для мыши XL',
                'description' => 'Размер 900×400 мм, толщина 3 мм, нескользящая резиновая основа.',
                'price'       => 129900,
                'in_stock'    => true,
            ],
            [
                'name'        => 'Кресло Herman Miller Aeron',
                'description' => 'Эргономичное офисное кресло, поясничная поддержка, сетчатая спинка.',
                'price'       => 18999900,
                'in_stock'    => false,
            ],
        ];

        foreach ($products as $data) {
            Product::create($data);
        }
    }
}
