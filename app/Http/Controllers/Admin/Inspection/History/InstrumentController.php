<?php

namespace  App\Http\Controllers\Admin\Inspection\History;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\Instrument;
use App\Models\Target;
use Illuminate\Http\Request;
use DataTables;

class InstrumentController extends Controller
{
    // protected $viewNamespace = "pages.admin.monitoring-evaluasi.form.instrument.";

    public function data(Form $form, Target $target){
        $data = $form->instruments()->latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('name', function($row){   
                $link = '<a href="'.route('monev.form.instrument.question.index',[$row->form_id, $row->id]).'">'.strtoupper($row->name).'</a>';     
                return $link;
            })
            ->addColumn('actions', function($row) use ($form){   
                $btn = '<button class="edit btn btn-success btn-sm">Lihat Detail</button>';        
                return $btn;
            })
            ->rawColumns(['actions', 'name'])
            ->make(true);
    }
}
