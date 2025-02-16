<?php

namespace App\Http\Controllers\ProductSide;

use App\Models\Products;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExportToPDFProducts extends Controller
{
    public function exportPDF()
    {
        try {
            $products = Products::all();

            if ($products->isEmpty()) {
                return redirect()->back()->with('failedToExport', 'No products found to export to PDF');
            }

            if (!view()->exists('AdminSide.Pages.ExportToPDF')) {
                throw new \Exception('PDF template not found');
            }

            $pdf = PDF::loadView('AdminSide/Pages/ExportToPDF', ['products' => $products]);
            
            $pdf->setPaper('a4', 'portrait');
            
            return $pdf->download('Quantum_Order_Products.pdf');

        } catch (\Exception $e) {            
            return redirect()->back()->with('failedToExport', 'Failed to export PDF: ' . $e->getMessage());
        }
    }
}
