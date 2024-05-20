<?php

namespace App\Exports;

use App\Models\student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class studenttransportExport implements FromCollection,WithHeadings{
    protected $id;

    function __construct($busroute) {
        $this->busroute=$busroute; 
        $this->aid=session()->get('NONTECH_GROUPMANAGER_ADMIN_ID');    
    }

    public function collection(){
            return  student::join('distances','students.sdistance','distances.id')
                    ->join('busroutes','distances.busrouteid','busroutes.id')
                    ->where('busroutes.id',$this->busroute)
                    ->where('students.aid',$this->aid)
                    ->select('sregistrationnumber','sname','slname','semail','snumber','busroute','location')
                    ->get();
    }

    public function headings(): array{
        return [
            'Registration Number',
            'First Name',
            'Last Name',
            'Email',
            'Number',
            'Bus Route',
            'Pick/Drop Location'
        ];
    }
}
