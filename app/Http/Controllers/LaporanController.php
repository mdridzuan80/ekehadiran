<?php

namespace App\Http\Controllers;

use App\Anggota;
use Carbon\Carbon;
use App\Department;
use League\Fractal\Manager;
use Illuminate\Support\Arr;
use App\Base\BaseController;
use App\Repositories\LaporanRepository;
use League\Fractal\Resource\Collection;
use App\Http\Requests\LaporanHarianRequest;
use App\Http\Requests\LaporanBulananRequest;
use App\Transformers\LaporanHarianTransformer;

class LaporanController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return $this->renderView('laporan.index');
    }

    public function harian()
    {
        return $this->renderView('laporan.harian');
    }

    public function bulanan()
    {
        return $this->renderView('laporan.bulanan');
    }

    public function rpcHarian(LaporanHarianRequest $request, Manager $fractal, LaporanHarianTransformer $LaporanHariantransformer)
    {
        $bahagian = Department::find($request->input('txtDepartmentId'));
        $rekod = LaporanRepository::laporanHarian($request->input('txtDepartmentId'), $request->input('txtTarikh'));

        $resource = new Collection($rekod, $LaporanHariantransformer);
        $transform = $fractal->createData($resource);

        return response()->json(Arr::add($transform->toArray(), 'bahagian', $bahagian->deptname));
    }

    public function rpcBulanan(LaporanBulananRequest $request)
    {
        $records = [];
        $mula = Carbon::parse($request->input('txtTarikh'));
        $tamat = (clone $mula)->addMonth();
        $officers = Anggota::whereIn('userid', $request->input('comPegawai'))->get();

        foreach ($officers as $officer) {
            array_push($records, [
                'userid' => $officer->userid,
                'name' => $officer->xtraAttr->nama,
                'deptname' => $officer->xtraAttr->department->deptname,
                'bulan' => $mula->englishMonth . "-" . $mula->year,
                'events' => (new LaporanRepository)->laporanBulanan($officer, $mula, $tamat)
            ]);
        }

        return response()->json($records);
    }
}
