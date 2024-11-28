<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        DB::table('role_has_permissions')->truncate();
//        DB::table('model_has_roles')->truncate();
//        DB::table('model_has_permissions')->truncate();
//        DB::table('permissions')->truncate();
//        DB::table('roles')->truncate();

        $roles = [
                        ['name' => 'super_admin' , 'guard_name'=> 'api-manager'],
                        ['name' => 'admin' , 'guard_name'=> 'api-manager']
                ];
        foreach ($roles as $role)
        {
            Role::create([
                            'name' => $role['name'],
                            'guard_name' => $role['guard_name']
                        ]);
        }
        $permissions = [
                            ['name' => 'dashboard','guard_name'=> 'api-manager' , 'dispaly_ar' => 'الصفحه الرئيسيه' , 'dispaly_en' => 'Home Page' ],
                            ['name' => 'personal-info-update','guard_name'=> 'api-manager', 'dispaly_ar' => 'تعديل البيانات الشخصيه' , 'dispaly_en' => 'Personal Information Update'],
                            ['name' => 'category-read','guard_name'=> 'api-manager', 'dispaly_ar' => 'عرض الفئات الرئيسيه' , 'dispaly_en' => 'Category Read'],
                            ['name' => 'category-create','guard_name'=> 'api-manager', 'dispaly_ar' => 'انشاء الفئات الرئيسيه' , 'dispaly_en' => 'Category Create'],
                            ['name' => 'category-update','guard_name'=> 'api-manager', 'dispaly_ar' => 'تعديل الفئات الرئيسيه' , 'dispaly_en' => 'Category Update'],
                            ['name' => 'category-delete','guard_name'=> 'api-manager', 'dispaly_ar' => 'حذف الفئات الرئيسيه' , 'dispaly_en' => 'Category Delete'],
                            ['name' => 'sub-category-read','guard_name'=> 'api-manager', 'dispaly_ar' => 'عرض الفئات الفرعيه' , 'dispaly_en' => 'SubCategory Read'],
                            ['name' => 'sub-category-create','guard_name'=> 'api-manager', 'dispaly_ar' => 'انشاء الفئات الفرعيه' , 'dispaly_en' => 'SubCategory Create'],
                            ['name' => 'sub-category-update','guard_name'=> 'api-manager', 'dispaly_ar' => 'تعديل الفئات الفرعيه' , 'dispaly_en' => 'SubCategory Update'],
                            ['name' => 'sub-category-delete','guard_name'=> 'api-manager', 'dispaly_ar' => 'حذف الفئات الفرعيه' , 'dispaly_en' => 'SubCategory Delete'],
                            ['name' => 'city-read','guard_name'=> 'api-manager', 'dispaly_ar' => 'عرض المدن' , 'dispaly_en' => 'City Read'],
                            ['name' => 'city-create','guard_name'=> 'api-manager', 'dispaly_ar' => 'انشاء المدن' , 'dispaly_en' => 'City Create'],
                            ['name' => 'city-update','guard_name'=> 'api-manager', 'dispaly_ar' => 'تعديل المدن' , 'dispaly_en' => 'City Update'],
                            ['name' => 'city-delete','guard_name'=> 'api-manager', 'dispaly_ar' => 'حذف المدن' , 'dispaly_en' => 'City Delete'],
                            ['name' => 'unit-read','guard_name'=> 'api-manager', 'dispaly_ar' => 'عرض وحدات القياس' , 'dispaly_en' => 'Unit Read'],
                            ['name' => 'unit-create','guard_name'=> 'api-manager', 'dispaly_ar' => 'انشاء وحدات القياس' , 'dispaly_en' => 'Unit Create'],
                            ['name' => 'unit-update','guard_name'=> 'api-manager', 'dispaly_ar' => 'تعديل وحدات القياس' , 'dispaly_en' => 'Unit Update'],
                            ['name' => 'unit-delete','guard_name'=> 'api-manager', 'dispaly_ar' => 'حذف وحدات القياس' , 'dispaly_en' => 'Unit Delete'],
                            ['name' => 'governorate-read','guard_name'=> 'api-manager', 'dispaly_ar' => 'عرض المحافظات' , 'dispaly_en' => 'Governorate Read'],
                            ['name' => 'governorate-create','guard_name'=> 'api-manager', 'dispaly_ar' => 'انشاء المحافظات' , 'dispaly_en' => 'Governorate Create'],
                            ['name' => 'governorate-update','guard_name'=> 'api-manager', 'dispaly_ar' => 'تعديل المحافظات' , 'dispaly_en' => 'Governorate Update'],
                            ['name' => 'governorate-delete','guard_name'=> 'api-manager', 'dispaly_ar' => 'حذف المحافظات' , 'dispaly_en' => 'Governorate Delete'],
                            ['name' => 'zone-read','guard_name'=> 'api-manager', 'dispaly_ar' => 'عرض المناطق' , 'dispaly_en' => 'Zone Read'],
                            ['name' => 'zone-create','guard_name'=> 'api-manager', 'dispaly_ar' => 'انشاء المناطق' , 'dispaly_en' => 'Zone Create'],
                            ['name' => 'zone-update','guard_name'=> 'api-manager', 'dispaly_ar' => 'تعديل المناطق' , 'dispaly_en' => 'Zone Update'],
                            ['name' => 'zone-delete','guard_name'=> 'api-manager', 'dispaly_ar' => 'حذف المناطق' , 'dispaly_en' => 'Zone Delete'],
                            ['name' => 'contactus-read','guard_name'=> 'api-manager', 'dispaly_ar' => 'عرض الرسائل' , 'dispaly_en' => 'ContactUs Read'],
                            ['name' => 'contactus-show','guard_name'=> 'api-manager', 'dispaly_ar' => 'تفاصيل الرسائل' , 'dispaly_en' => 'ContactUs Show'],
                            ['name' => 'contactus-delete','guard_name'=> 'api-manager', 'dispaly_ar' => 'حذف الرسائل' , 'dispaly_en' => 'ContactUs Delete'],
                            ['name' => 'contactus-reply','guard_name'=> 'api-manager', 'dispaly_ar' => 'الرد على الرسائل' , 'dispaly_en' => 'ContactUs Reply'],
                            ['name' => 'blog-read','guard_name'=> 'api-manager', 'dispaly_ar' => 'عرض المنشورات' , 'dispaly_en' => 'Blog Read'],
                            ['name' => 'blog-show','guard_name'=> 'api-manager', 'dispaly_ar' => 'تفاصيل المنشورات' , 'dispaly_en' => 'Blog Show'],
                            ['name' => 'blog-update','guard_name'=> 'api-manager', 'dispaly_ar' => 'تعديل المنشورات' , 'dispaly_en' => 'Blog Update'],
                            ['name' => 'blog-delete','guard_name'=> 'api-manager', 'dispaly_ar' => 'حذف المنشورات' , 'dispaly_en' => 'Blog Delete'],
                            ['name' => 'instruction-update','guard_name'=> 'api-manager', 'dispaly_ar' => 'تعديل التعليمات' , 'dispaly_en' => 'Instruction Update'],
                            ['name' => 'setting-update','guard_name'=> 'api-manager', 'dispaly_ar' => 'تعديل الاعدادات' , 'dispaly_en' => 'Setting Update'],
                            ['name' => 'user-read','guard_name'=> 'api-manager', 'dispaly_ar' => 'عرض المستخدمين' , 'dispaly_en' => 'User Read'],
                            ['name' => 'user-update','guard_name'=> 'api-manager', 'dispaly_ar' => 'تعديل المستخدمين' , 'dispaly_en' => 'User Update'],
                            ['name' => 'user-show','guard_name'=> 'api-manager', 'dispaly_ar' => 'تفاصيل المستخدمين' , 'dispaly_en' => 'User Show'],
                            ['name' => 'user-delete','guard_name'=> 'api-manager', 'dispaly_ar' => 'حذف المستخدمين' , 'dispaly_en' => 'User Delete'],
                            ['name' => 'question-read','guard_name'=> 'api-manager', 'dispaly_ar' => 'عرض الاسئله' , 'dispaly_en' => 'Question Read'],
                            ['name' => 'question-show','guard_name'=> 'api-manager', 'dispaly_ar' => 'تفاصيل الاسئله' , 'dispaly_en' => 'Question Show'],
                            ['name' => 'question-update','guard_name'=> 'api-manager', 'dispaly_ar' => 'تعديل الاسئله' , 'dispaly_en' => 'Question Update'],
                            ['name' => 'question-delete','guard_name'=> 'api-manager', 'dispaly_ar' => 'حذف الاسئله' , 'dispaly_en' => 'Question Delete'],
                            ['name' => 'order-read','guard_name'=> 'api-manager', 'dispaly_ar' => 'عرض الطلبات' , 'dispaly_en' => 'Order Read'],
                            ['name' => 'order-show','guard_name'=> 'api-manager', 'dispaly_ar' => 'تفاصيل الطلبات' , 'dispaly_en' => 'Order Show'],
                            ['name' => 'order-delete','guard_name'=> 'api-manager', 'dispaly_ar' => 'حذف الطلبات' , 'dispaly_en' => 'Order Delete'],
                            ['name' => 'manager-read','guard_name'=> 'api-manager', 'dispaly_ar' => 'عرض الموظفين' , 'dispaly_en' => 'Manager Read'],
                            ['name' => 'manager-create','guard_name'=> 'api-manager', 'dispaly_ar' => 'انشاء الموظفين' , 'dispaly_en' => 'Manager Create'],
                            ['name' => 'manager-update','guard_name'=> 'api-manager', 'dispaly_ar' => 'تعديل الموظفين' , 'dispaly_en' => 'Manager Update'],
                            ['name' => 'manager-delete','guard_name'=> 'api-manager', 'dispaly_ar' => 'حذف الموظفين' , 'dispaly_en' => 'Manager Delete'],
                            ['name' => 'role-read','guard_name'=> 'api-manager', 'dispaly_ar' => 'عرض الادوار' , 'dispaly_en' => 'Role Read'],
                            ['name' => 'role-create','guard_name'=> 'api-manager', 'dispaly_ar' => 'انشاء الادوار' , 'dispaly_en' => 'Role Create'],
                            ['name' => 'role-update','guard_name'=> 'api-manager', 'dispaly_ar' => 'تعديل الادوار' , 'dispaly_en' => 'Role Update'],
                            ['name' => 'role-delete','guard_name'=> 'api-manager', 'dispaly_ar' => 'حذف الادوار' , 'dispaly_en' => 'Role Delete'],
                            ['name' => 'review-read','guard_name'=> 'api-manager', 'dispaly_ar' => 'عرض الاراء' , 'dispaly_en' => 'Review Read'],
                            ['name' => 'review-create','guard_name'=> 'api-manager', 'dispaly_ar' => 'انشاء الاراء' , 'dispaly_en' => 'Review Create'],
                            ['name' => 'review-update','guard_name'=> 'api-manager', 'dispaly_ar' => 'تعديل الاراء' , 'dispaly_en' => 'Review Update'],
                            ['name' => 'review-delete','guard_name'=> 'api-manager', 'dispaly_ar' => 'حذف الاراء' , 'dispaly_en' => 'Review Delete'],
                            ['name' => 'complaint-read','guard_name'=> 'api-manager', 'dispaly_ar' => 'عرض الشكاوى' , 'dispaly_en' => 'Complaint Read'],
                            ['name' => 'complaint-delete','guard_name'=> 'api-manager', 'dispaly_ar' => 'حذف الشكاوى' , 'dispaly_en' => 'Complaint Delete'],
                            ['name' => 'package-read','guard_name'=> 'api-manager', 'dispaly_ar' => 'عرض الباقات' , 'dispaly_en' => 'Package Read'],
                            ['name' => 'package-create','guard_name'=> 'api-manager', 'dispaly_ar' => 'انشاء الباقات' , 'dispaly_en' => 'Package Create'],
                            ['name' => 'package-update','guard_name'=> 'api-manager', 'dispaly_ar' => 'تعديل الباقات' , 'dispaly_en' => 'Package Update'],
                            ['name' => 'package-delete','guard_name'=> 'api-manager', 'dispaly_ar' => 'حذف الباقات' , 'dispaly_en' => 'Package Delete'],
                    ];
        foreach ($permissions as $permission)
        {
            Permission::create([
                                    'name' => $permission['name'],
                                    'guard_name' => $permission['guard_name'],
                                    'dispaly_ar' => $permission['dispaly_ar'],
                                    'dispaly_en' => $permission['dispaly_en']
                                ]);
        }
        $superAdminRole = Role::first();
        $permissions = Permission::all();
        $superAdminRole->syncPermissions($permissions);
        $adminRole = Role::find(2);
        $permissions = Permission::all();
        $adminRole->givePermissionTo(['dashboard','personal-info-update',
                                        'category-read','category-create','category-update','category-delete',
                                        'sub-category-read','sub-category-create','sub-category-update','sub-category-delete'
                                    ]);
        $user = \App\Models\Manager::find(1);
        $user->assignRole($superAdminRole);
        $adminUser = \App\Models\Manager::find(2);
        $adminUser->assignRole($adminRole);

    }
}
