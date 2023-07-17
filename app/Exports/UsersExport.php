<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        $columns = Schema::getColumnListing('users');
        return array_filter($columns, function ($column) {
            return !in_array($column, ['password', 'remember_token']);
        });
    }

    public function collection()
    {
        return User::all();
    }
}
