<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'Invoices',
            'List_Invoices',
            'Paid_Invoices',
            'UnPaid_Invoices',
            'Partial_Invoices',
            'Archive_Invoices',
            'Reports',
            'Invoices_Report',
            'Customers_Report',
            'Users',
            'List_Users',
            'Users_permissions',
            'Settings',
            'Products',
            'Sections',

            'Print_Invoice',
            'Add_Invoice',
            'Edit_Invoice',
            'Delete_Invoice',
            'Export_Excel_Invoice',
            'Edit_Status_Invoice',
            'Add_Attachment',
            'Delete_Attachment',

            'Add_User',
            'Edit_User',
            'Delete_User',

            'View_permission',
            'Add_permission',
            'Edit_permission',
            'Delete_permission',

            'Add_Product',
            'Edit_Product',
            'Delete_Product',

            'Add_Section',
            'Edit_Section',
            'Delete_Section',


        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }


    }
}
