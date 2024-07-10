<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Branch\Entities\Branch;

class ProductsImport implements ToCollection,WithHeadingRow
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $branch = Branch::query()->where('id',$this->data['branch_id'])->first();

        DB::transaction(function () use ($rows, $branch) {
            foreach ($rows as $row) {
                if (isset($row['price'], $row['quantity'], $row['id'])) {
                    // Attempt to retrieve the product and its pivot row from the branch
                    $product = $branch->products()->where('product_id', $row['id'])->first();

                    if ($product) {
                        // If the product already exists in the relationship, fetch current pivot data
                        $currentQuantity = $product->pivot->quantity ?? 0;
                        $newQuantity = $currentQuantity + $row['quantity'];

                        // Update the pivot table with the new cumulative quantity, and other pivot fields as needed
                        $branch->products()->updateExistingPivot($row['id'], [
                            'quantity' => $newQuantity,
                            'price' => $row['price'], // Assuming you want to update the price as well
                            // Add any other pivot field updates here
                        ]);
                    } else {
                        // If the product does not exist in the relationship, attach it with the provided data
                        $branch->products()->attach($row['id'], [
                            'company_id' => $this->data['company_id'], // Make sure this field is necessary for your pivot table
                            'price' => $row['price'],
                            'quantity' => $row['quantity'],
                            'is_active' => true, // Assuming default active state, adjust as needed
                        ]);
                    }
                }
            }
        });
    }
}
