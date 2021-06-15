<?php

namespace App\Http\Controllers\Admin\Inspection\History;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\Target;
use Illuminate\Http\Request;
use DataTables;

class TargetController extends Controller
{
    protected $viewNamespace = "pages.admin.monitoring-evaluasi.inspection-history.sasaran-monitoring.";

    public function index(Form $form){
        return view($this->viewNamespace.'index', compact('form'));
    }

    public function detail(Form $form, Target $target){
        return view($this->viewNamespace.'detail', compact('form','target'));
    }

    public function data(Form $form){
        $data = $form->targets()->latest();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('name', function($row) use($form){   
                return $row->institutionable->name;
            })
            ->addColumn('officer_name', function($row){   
                return $row->officerName();
            })
            ->addColumn('actions', function($row) use ($form){   
                $btn = '<div class="list-icons">
                <div class="dropdown">
                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                        <i class="icon-menu9"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="'.route('monev.inspection-history.target.detail',[$form->id,$row->id]).'" class="dropdown-item"><i class="icon-eye"></i> Lihat Detail</a>
                        <a href="javascript:void(0)" class="dropdown-item"><i class="icon-download"></i> Unduh</a>
                        <a href="javascript:void(0)" class="dropdown-item" onclick="destroy(`'.route('monev.form.destroy',[$row->id]).'`)"><i class="icon-trash"></i> Hapus</a>
                    </div>
                </div>
            </div>';     
                return $btn;
            })
            
            ->rawColumns(['actions'])
            ->make(true);
    }

    
}
