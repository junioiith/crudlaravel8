<?php

namespace App\Http\Controllers;

use PDF;
//use Barryvdh\DomPDF\PDF;
use App\Models\Employee;

use Illuminate\Http\Request;
use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    public function index(Request $request) {
        if($request->has('search')) {
            $data = Employee::where('nama', 'LIKE', '%' .$request->search.'%')->paginate(4);
        } else {
            $data = Employee::paginate(4);
        }
        
        return view ('datapegawai', compact('data'));
    }

    public function tambahpegawai() {
        return view('tambahdata');
    }

    public function insertpegawai(Request $request) {
        //dd($request->all());
        $data = Employee::create($request->all());

        if($request->hasFile('foto')) {
            $request->file('foto')->move('fotopegawai/', $request->file('foto')->getClientOriginalName());
            $data->foto = $request->file('foto')->getClientOriginalName();
            $data->save();
        }
        return redirect()->route('pegawai')->with('success', 'Data berhasil ditambahkan');
    }

    public function editpegawai($id) {
        $data = Employee::Find($id);
        //dd($data);
        return view('editpegawai', compact('data'));
    }

    public function updatepegawai(Request $request,$id) {
        $data = Employee::Find($id);
        $data->update($request->all());
        return redirect()->route('pegawai')->with('success', 'Data berhasil diupdate');
    }

    public function deletepegawai($id) {
        $data = Employee::Find($id);
        $data->delete();
        return redirect()->route('pegawai')->with('success', 'Data berhasil dihapus');

    }

    public function exportpdf() {
        $data = Employee::all();

        view()->share('data', $data);
        $pdf = PDF::loadview('datapegawai-pdf');

        return $pdf->download('data.pdf');
    }

    public function exportexcel() {
        return Excel::download(new EmployeeExport, 'datapegawai.xlsx');
    }

    public function importexcel(Request $request) {
        $data = $request->file('file');

        $namafile = $data->getClientOriginalName();
        $data->move('EmployeeData', $namafile);

        Excel::Import(new EmployeeImport, \public_path('/EmployeeData/'.$namafile));

        return \redirect()->back();

    }
}
