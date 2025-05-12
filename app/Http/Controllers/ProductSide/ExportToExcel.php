<?php

namespace App\Http\Controllers\ProductSide;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportToExcel extends Controller
{
    public function UserexportToExcel()
    {
        $products = Products::all();

        // Check if there are any users
        if ($products->isEmpty()) {
            return redirect('/UserManagement')->with('failedToExport', 'No products found to export');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        // Set headers
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Image');
        $sheet->setCellValue('D1', 'Category');
        $sheet->setCellValue('E1', 'Price');
        $sheet->setCellValue('F1', 'Stock');
        $sheet->setCellValue('G1', 'Description');
        $sheet->setCellValue('H1', 'Created_At');
        $sheet->setCellValue('I1', 'Updated_At');;

        // Add data
        $row = 2;
        foreach ($products as $productsRow) {
            $sheet->setCellValue('A' . $row, $productsRow->productId);
            $sheet->setCellValue('B' . $row, $productsRow->productName);
            $sheet->setCellValue('C' . $row, $productsRow->image);
            $sheet->setCellValue('D' . $row, $productsRow->category);
            $sheet->setCellValue('E' . $row, $productsRow->price);
            $sheet->setCellValue('F' . $row, $productsRow->stock);
            $sheet->setCellValue('G' . $row, $productsRow->description);
            $sheet->setCellValue('H' . $row, $productsRow->created_at);
            $sheet->setCellValue('I' . $row, $productsRow->updated_at);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Quantum_Order_Products.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
