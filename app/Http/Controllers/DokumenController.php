<?php

namespace App\Http\Controllers;

use App\Mail\Email;
use App\Models\Sip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index()
    {
        return view('dokumen.index', [
            'title' => 'Data Dokumen Pegawai',
            'data_dokumen' => Sip::all()
        ]);
    }

    public function tambah()
    {
        return view('dokumen.tambah', [
            'title' => 'Tambah Data Dokumen',
            'data_user' => User::all()
        ]);
    }
    
    public function tambahProses(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'nama_dokumen' => 'required',
            'tanggal_berakhir' => 'required',
            'file' => 'mimes:doc,docx,pdf,xls,xlsx,ppt,pptx|max:10000'
        ]);

        if ($request->file('file')) {
            $validatedData['file'] = $request->file('file')->store('file');
        }

        Sip::create($validatedData);
        return redirect('/dokumen')->with('success', 'Dokumen Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        return view('dokumen.edit', [
            'title' => "Edit Data Dokumen",
            'data_user' => User::all(),
            'data_dokumen' => Sip::findOrFail($id)
        ]);
    }

    public function editProses(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'nama_dokumen' => 'required',
            'file' => 'mimes:doc,docx,pdf,xls,xlsx,ppt,pptx|max:10000'
        ]);

        if ($request->file('file')) {
            if ($request->file_lama) {
                Storage::delete($request->file_lama);
            }
            $validatedData['file'] = $request->file('file')->store('file');
        }

        Sip::where('id', $id)->update($validatedData);
        return redirect('/dokumen')->with('success', 'Dokumen Berhasil Diperbarui');
    }
    
    public function delete($id)
    {
        $dokumen = Sip::findOrFail($id);
        $dokumen->delete();
        Storage::delete($dokumen->file);
        return redirect('/dokumen')->with('success', 'Dokumen Berhasil Dihapus');
    }
    
    public function myDokumen()
    {
        return view('dokumen.mydokumen', [
            'title' => 'Data Dokumen Saya',
            'data_dokumen' => Sip::where('user_id', auth()->user()->id)->get()
        ]);
    }

    public function myDokumenTambah()
    {
        return view('dokumen.mydokumentambah', [
            'title' => 'Tambah Data Dokumen'
        ]);
    }

    public function myDokumenTambahProses(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'nama_dokumen' => 'required',
            'tanggal_berakhir' => 'required',
            'file' => 'mimes:doc,docx,pdf,xls,xlsx,ppt,pptx|max:10000'
        ]);

        if ($request->file('file')) {
            $validatedData['file'] = $request->file('file')->store('file');
        }

        Sip::create($validatedData);
        return redirect('/my-dokumen')->with('success', 'Dokumen Berhasil Ditambahkan');
    }

    public function myDokumenEdit($id)
    {
        return view('dokumen.mydokumenedit', [
            'title' => "Edit Data Dokumen",
            'data_dokumen' => Sip::findOrFail($id)
        ]);
    }
    public function myDokumenEditProses(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_dokumen' => 'required',
            'file' => 'mimes:doc,docx,pdf,xls,xlsx,ppt,pptx|max:10000'
        ]);

        if ($request->file('file')) {
            if ($request->file_lama) {
                Storage::delete($request->file_lama);
            }
            $validatedData['file'] = $request->file('file')->store('file');
        }

        Sip::where('id', $id)->update($validatedData);
        return redirect('/my-dokumen')->with('success', 'Dokumen Berhasil Diperbarui');
    }

    public function myDokumenDelete($id)
    {
        $dokumen = Sip::findOrFail($id);
        $dokumen->delete();
        Storage::delete($dokumen->file);
        return redirect('/my-dokumen')->with('success', 'Dokumen Berhasil Dihapus');
    }
}
