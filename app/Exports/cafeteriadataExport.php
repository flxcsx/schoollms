<?php

namespace App\Exports;

use App\Models\cafeteriaItems;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class cafeteriadataExport implements FromCollection,WithHeadings{
    protected $id;

    function __construct($mid) {
        $this->mid=$mid;     
    }

    public function collection(){
        return  cafeteriaItems::join('cafeteriatype','cafeteria_items.cafetype','cafeteriatype.id')
                ->join('cafeterias','cafeteria_items.cafeid','cafeterias.id')
                ->join('infraitems','cafeteria_items.itemid','infraitems.id')
                ->where('cafeteria_items.mid',$this->mid)
                ->select('cafeteriatype.ctype','cafeterias.cafeteria','infraitems.infraitem','cafeteria_items.itemno','cafeteria_items.itemdesc')
                ->get();
    }

    public function headings(): array{
        return [
            'Cafeteria Type',
            'Cafeteria',
            'Items',
            'Item No',  
            'Item Desc',    
        ];
    }
}
