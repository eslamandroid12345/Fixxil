<?php

namespace Database\Seeders;

use App\Models\Structure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Structure::query()->updateOrCreate(
            [
                'key' => 'name',
            ],
            [
                'content' => json_encode([
                    'en' => ['fixxil'],
                    'ar' => ['منصه الفنين']
                ]),
            ]
        );

        Structure::query()->updateOrCreate(
            [
                'key' => 'about',
            ],
            [
                'content' => json_encode([
                    'en' => [['title' => 'about'],['content' => 'About site']],
                    'ar' => [['title' => 'عن'],['content' => 'عن المنصه']],
                ]),
            ]
        );

        Structure::query()->updateOrCreate(
            [
                'key' => 'policy',
            ],
            [
                'content' => json_encode([
                    'en' => [['title' => 'policy'],['content' => 'policy site']],
                    'ar' => [['title' => 'الشروط'],['content' => 'الشروط واالاحكام']],
                ]),
            ]
        );

        Structure::query()->updateOrCreate(
            [
                'key' => 'address',
            ],
            [
                'content' => json_encode([
                    'en' => [['title' => 'Address'],['content' => 'Address site']],
                    'ar' => [['title' => 'العنوان'],['content' => 'العنوان الخاص بالموقع']],
                ]),
            ]
        );

        Structure::query()->updateOrCreate(
            [
                'key' => 'order_instruction',
            ],
            [
                'content' => json_encode([
                    'en' => [['title' => 'Order Instruction'],['content' => 'order instruction content']],
                    'ar' => [['title' => 'تعليمات الطلبات'],['content' => 'محتوى تعليمات الطلبات']],
                ]),
            ]
        );

        Structure::query()->updateOrCreate(
            [
                'key' => 'order_used',
            ],
            [
                'content' => json_encode([
                    'en' => [['title' => 'Order User'],['content' => 'order user content']],
                    'ar' => [['title' => 'تعليمات المستخدمين'],['content' => 'محتوى تعليمات المستخدمين']],
                ]),
            ]
        );
    }
}
