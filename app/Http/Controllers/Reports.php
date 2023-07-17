<?php

namespace App\Http\Controllers;

use App\Exports\CertificatessExport;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class Reports extends Controller
{

    public function Certificates()
    {
        return Excel::download(new CertificatessExport, 'certificates.xlsx');
    }

    public function Users()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
