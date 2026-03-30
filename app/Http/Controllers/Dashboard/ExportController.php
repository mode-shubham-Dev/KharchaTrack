<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', auth()->id())
            ->orderBy('name')
            ->get();

        return view('dashboard.pages.export.index', compact('categories'));
    }

    public function download(Request $request)
    {
        // ===== VALIDATE =====
        $request->validate([
            'date_from' => 'required|date',
            'date_to'   => 'required|date|after_or_equal:date_from',
            'type'      => 'nullable|in:income,expense',
        ]);

        // ===== BUILD QUERY =====
        $transactions = Transaction::where('user_id', auth()->id())
            ->with('category')
            ->whereBetween('date', [
                $request->date_from,
                $request->date_to
            ])
            ->when($request->type, fn($q) => 
                $q->where('type', $request->type))
            ->when($request->category_id, fn($q) => 
                $q->where('category_id', $request->category_id))
            ->orderBy('date', 'desc')
            ->get();


        // ===== BUILD CSV =====
        $filename = 'transactions-' .
            $request->date_from . '-to-' .
            $request->date_to . '.csv';

        // Save to temp file in storage
        $tempPath = storage_path('app/' . $filename);

        $file = fopen($tempPath, 'w');

        fprintf($file, chr(0xEF) . chr(0xBB) .chr(0xBF));

        // Header row
        fputcsv($file, ['Date', 'Category', 'Type', 'Amount (NPR)', 'Note']);

        // Data rows
        foreach ($transactions as $transaction) {
            fputcsv($file, [
                $transaction->date->format('d/m/Y'),
                $transaction->category->name,
                ucfirst($transaction->type),
                number_format($transaction->amount, 2, '.', ''),
                $transaction->note ?? '',
            ]);
        }

        fclose($file);

        // ===== DOWNLOAD AND DELETE =====
        return response()->download($tempPath, $filename)->deleteFileAfterSend(true);
    }

   
}
