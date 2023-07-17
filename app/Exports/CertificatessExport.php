<?php

namespace App\Exports;

use App\Models\Certificates;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CertificatessExport implements FromQuery, WithHeadings
{

    public function headings(): array
    {
        return [
            'Certificate Title',
            'Certificate Count',
        ];
    }

    public function query()
    {
        return Certificates::leftJoin('certificate_user', 'certificates.id', '=', 'certificate_user.certificates_id')
            ->select('certificates.title', DB::raw('COUNT(certificate_user.certificates_id) as certificate_count'))
            ->groupBy('certificates.id', 'certificates.title');
    }
}
