<?php

namespace App\Http\Controllers;

use PDF;
use Flow;
use Auth;
use Carbon\Carbon;
use App\MinitCurai;
use App\MinitCuraiFlow;
use Illuminate\Http\Request;
use App\Base\BaseController;
use App\XtraAnggota;
use Illuminate\Support\Facades\DB;
use App\Role;



class MinitCuraiController extends BaseController
{
    public function index()
    {
        return $this->renderView('minitcurai.index');
    }

    public function create()
    {
        return view("minitcurai.create");
    }

    public function store(Request $request)
    {
        $fields = collect([
            "tajuk" => $request->txtAktiviti,
            "anjuran" => $request->txtAnjuran,
            "tarikh" => Carbon::createFromFormat('Y-m-d',  $request->txtTarikh)->format('Y-m-d'),
            "lokasi" => $request->txtTempat,
            "isu" => $request->txtIsu,
            'tindakan' => $request->txtTindakan,
            'pegawai_terlibat' => $request->txtPegawai,
            "anggota_id" => Auth::user()->anggota_id,
            "from_anggota_id" => Auth::user()->anggota_id,
            "to_anggota_id" => Auth::user()->anggota_id,
        ]);

        MinitCurai::menyimpan($fields);
    }

    public function grid(Request $request)
    {
        /* $search = collect([
            'key' => $request->input('search-key'),
            'dept' => Utility::pcrsListerDepartment($request->input('subDept'), $request->input('searchDept')),
        ]); */ 
	
        $perPage = 10;

        if (Auth::user()->perananSemasa()->key == Role::SUPER_ADMIN) {
            $created = MinitCurai::orderBy('created_at', 'desc');
		
        }
        else {
            $created = MinitCurai::where("anggota_id", Auth::user()->anggota_id)->orderBy('created_at', 'desc');
			
        }    
            

            $involve = MinitCurai::select("minitcurai.*")->join("minitcurai_flow", "minitcurai.id", "=",  "minitcurai_flow.minitcurai_id")
                ->where("minitcurai_flow.to_anggota_id", Auth::user()->anggota_id);
            $involve->union($created);

            $union = $involve->orderBy('tarikh', 'desc')->paginate($perPage);

        return view('minitcurai.grid', compact('union'));
    }
    public function edit(MinitCurai $minitCurai)
    {
        $xtraAnggota = XtraAnggota::select();

        if (Auth::user()->perananSemasa()->key == Role::KETUA_JABATAN) {
           $anggota = $xtraAnggota->where('dept_id', '<>', 44)->orderBy('nama', 'ASC')->get();
        }
        else {
            $anggota = $xtraAnggota->where('dept_id', Auth::user()->xtraAnggota->dept_id)->orderBy('nama', 'ASC')->get();
        }    
        return view('minitcurai.edit', compact('minitCurai', 'anggota'));
    }

    public function update(MinitCurai $minitCurai, Request $request)
    {
        $fields = collect([
            "tajuk" => $request->txtAktiviti,
            "anjuran" => $request->txtAnjuran,
            "tarikh" => Carbon::createFromFormat('Y-m-d',  $request->txtTarikh)->format('Y-m-d'),
            "lokasi" => $request->txtTempat,
            "isu" => $request->txtIsu,
            "tindakan" => $request->txtTindakan,
            "anggota_id" => Auth::user()->anggota_id,
            "from_anggota_id" => Auth::user()->anggota_id,
            "to_anggota_id" => Auth::user()->anggota_id,
        ]);

        $minitCurai->tajuk = $request->txtAktiviti;
        $minitCurai->anjuran = $request->txtAnjuran;
        $minitCurai->tarikh = Carbon::createFromFormat('Y-m-d',  $request->txtTarikh)->format('Y-m-d');
        $minitCurai->lokasi = $request->txtTempat;
        $minitCurai->isu = $request->txtIsu;
        $minitCurai->pegawai_terlibat = $request->txtPegawai;
        $minitCurai->tindakan = $request->txtTindakan;
        $minitCurai->cadangan = $request->txtCadangan;

        $minitCurai->save();
    }

    public function sah(MinitCurai $minitCurai, Request $request)
    {
        $minitCurai->validating();
    }
    
    public function pulang(MinitCurai $minitCurai, Request $request)
    {
        $minitCurai->returning();
    }

    public function send(MinitCurai $minitCurai)
    {
        $minitCurai->flag = MinitCurai::HANTAR;
        $minitCurai->save();

        $minitCurai->minitCurai_flow()->save(new MinitCuraiFlow([
            'from_anggota_id' => Auth::user()->anggota_id,
            'to_anggota_id' => Flow::pelulus(Auth::user()->anggota)->xtraAttr->anggota_id
        ]));
    }

    public function forward(MinitCurai $minitCurai, Request $request)
    {
        foreach ($request->comPegawai as $pegawaiId) {
            $fields = collect([
                "from_anggota_id" => Auth::user()->anggota_id,
                "to_anggota_id" => $pegawaiId,
                "is_forward" => 1, 2, 3
            ]);
            MinitCurai::majukan($minitCurai, $fields);
        }
    }

    public function cetak(MinitCurai $minitCurai, $id)
    {
        
	$pdf = PDF::loadView('laporan.cetak', compact('minitCurai'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->download('MinitCuraiJPNMelaka.pdf');
    }
    
    public function destroy(MinitCurai $minitCurai)
    {
        $deleted = $minitCurai->delete();
        return response()->json($deleted);
    }
	
    public function search(Request $request)
    {
        $search = $request->input('table_search');
            
        
        
        
        
              
	$perPage = 10;

        if (Auth::user()->perananSemasa()->key == Role::SUPER_ADMIN) {
            
		$minitCurai = MinitCurai::query()
        ->where('created_at', 'LIKE', "%{$search}%");
        }
        else {
            $minitCurai = MinitCurai::query()
        ->where('created_at', 'LIKE', "%{$search}%");
			
        }    
            

            $involve = MinitCurai::select("minitcurai.*")->join("minitcurai_flow", "minitcurai.id", "=",  "minitcurai_flow.minitcurai_id")
                ->where("minitcurai_flow.to_anggota_id", Auth::user()->anggota_id);
            $involve->union($created);

            $union = $involve->orderBy('tarikh', 'desc')->paginate($perPage);

        return view('minitcurai.grid', compact('union'));
    }
    
    
    
    /*
    public function index(MinitCurai $minitCurai){
        $values = $minitCurai->data; //I want to print this $values variable.

        dd($values); // die and dump $values

    }
    /*
    /*
    public function cetak(Request $request)
    {
        $minitCurai = MinitCurai::all();
        view()->share('minitcurai',$minitCurai);
        
        if($request->has('download')){
        $pdf = PDF::loadView('minitcurai.cetak', compact('minitCurai'));
        return $pdf->download('MinitCuraiJPNMelaka.pdf');
        }
        
        return view('minitcurai.edit', compact('minitCurai', 'anggota'));
    }
    
     public function cetak(MinitCurai $minitCurai)
    {
        $pdf = PDF::loadView('laporan.cetak', compact('minitCurai'));
        return $pdf->download('MinitCuraiJPNMelaka.pdf');
    }
    */
    /*
    public function cetak()
    {
        $cetak = DB::table('minitcurai')->get();
        //$pdf = \App::make('dompdf.wrapper');
        return view ('minitcurai.cetak',['tajuk'=>$tajuk,'anjuran'=>$anjuran,'tarikh'=>$tarikh,'pegawai_terlibat'=>$pegawai_terlibat,'isu'=>$isu,'tindakan'=>$tindakan,'cadangan'=>$cadangan]);
        //return $pdf->stream();
    } 
    */
}
