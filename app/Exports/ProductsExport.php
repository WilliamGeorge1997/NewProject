<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return \Modules\Product\Entities\Product::query()->select('id', 'title->en','price')->active()->get();
    }

    /**
     * Return the headings for the excel file.
     *
     * @return array
     */
    public function headings(): array
    {
        return ["ID", "Name","Price",'Quantity'];
    }
}
