<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PlanningsExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        return Excel::download(new PlanningsExport, 'plannings.xlsx');
    }
}
