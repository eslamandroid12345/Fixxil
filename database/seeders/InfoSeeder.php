<?php

namespace Database\Seeders;

use App\Models\Info;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Info::query()->updateOrCreate(['key' => 'facbook'], [
            'key' => 'facbook',
            'value' => 'facbook',
            'type' => 'text',
            'name_en' => 'Facbook',
            'name_ar' => 'فيس بوك',
        ]);
        Info::query()->updateOrCreate(['key' => 'linkedin'], [
            'key' => 'linkedin',
            'value' => 'linkedin',
            'type' => 'text',
            'name_en' => 'Linkedin',
            'name_ar' => 'لينكد ان ',
        ]);
        Info::query()->updateOrCreate(['key' => 'youtube'], [
            'key' => 'youtube',
            'value' => 'youtube',
            'type' => 'text',
            'name_en' => 'Youtube',
            'name_ar' => ' يوتيوب',
        ]);
        Info::query()->updateOrCreate(['key' => 'insta'], [
            'key' => 'insta',
            'value' => 'insta',
            'type' => 'text',
            'name_en' => 'Instagram',
            'name_ar' => 'انستجرام',
        ]);
        Info::query()->updateOrCreate(['key' => 'twiter'], [
            'key' => 'twiter',
            'value' => 'twiter',
            'type' => 'text',
            'name_en' => 'Twiter',
            'name_ar' => 'تويتر',
        ]);
        Info::query()->updateOrCreate(['key' => 'tiktok'], [
            'key' => 'tiktok',
            'value' => 'tiktok',
            'type' => 'text',
            'name_en' => 'Tiktok',
            'name_ar' => 'تيك توك',
        ]);
        Info::query()->updateOrCreate(['key' => 'email'], [
            'key' => 'email',
            'value' => 'email',
            'type' => 'text',
            'name_en' => 'Email',
            'name_ar' => 'ايميل',
        ]);
        Info::query()->updateOrCreate(['key' => 'phone'], [
            'key' => 'phone',
            'value' => 'phone',
            'type' => 'text',
            'name_en' => 'Phone',
            'name_ar' => 'رقم الهاتف',
        ]);
        Info::query()->updateOrCreate(['key' => 'whatsapp'], [
            'key' => 'whatsapp',
            'value' => 'whatsapp',
            'type' => 'text',
            'name_en' => 'Whatsapp',
            'name_ar' => 'واتس',
        ]);
        Info::query()->updateOrCreate(['key' => 'point_price'], [
            'key' => 'point_price',
            'value' => '10',
            'type' => 'text',
            'name_en' => 'Point Price',
            'name_ar' => 'سعر النقطه',
        ]);
        Info::query()->updateOrCreate(['key' => 'point_discount'], [
            'key' => 'point_discount',
            'value' => '50',
            'type' => 'text',
            'name_en' => 'Points Discount',
            'name_ar' => 'خصم النقاط',
        ]);
    }
}
