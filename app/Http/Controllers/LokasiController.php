<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LokasiController extends Controller
{
    public function index()
    {
        return view('lokasi.index', [
            'title' => 'Master Lokasi Kantor',
            'data_lokasi' => Lokasi::where('status', 'approved')->get()
        ]);
    }

    public function pendingLocation()
    {
        return view('lokasi.indexpending', [
            'title' => 'Pending Location',
            'data_lokasi' => Lokasi::where('status', 'pending')->get()
        ]);
    }

    public function requestLocation()
    {
        return view('lokasi.indexrequest', [
            'title' => 'Request Lokasi',
            'data_lokasi' => Lokasi::where('created_by', auth()->user()->id)->get()
        ]);
    }

    public function tambahLokasi()
    {
        return view('lokasi.tambah', [
            'title' => 'Tambah Lokasi Kantor'
        ]);
    }

    public function tambahRequestLocation()
    {
        return view('lokasi.tambahrequest', [
            'title' => 'Tambah Lokasi Kantor'
        ]);
    }

    public function prosesTambahLokasi(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lokasi' => 'required',
            'lat_kantor' => 'required',
            'long_kantor' => 'required',
            'radius' => 'required',
            'status' => 'required',
            'created_by' => 'required'
        ]);
        Lokasi::create($validatedData);
        return redirect('/lokasi-kantor')->with('success', 'Lokasi Berhasil Di Tambahkan');
    }
    
    public function prosesTambahRequestLocation(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lokasi' => 'required',
            'lat_kantor' => 'required',
            'long_kantor' => 'required',
            'radius' => 'required',
            'status' => 'required',
            'created_by' => 'required'
        ]);
        Lokasi::create($validatedData);
        return redirect('/request-location')->with('success', 'Lokasi Berhasil Di Tambahkan');
    }

    public function editLokasi($id)
    {
        return view('lokasi.edit', [
            'title' => 'Edit Lokasi Kantor',
            'lokasi' => Lokasi::findOrFail($id)
        ]);
    }

    public function editRequestLocation($id)
    {
        return view('lokasi.editrequest', [
            'title' => 'Edit Lokasi Kantor',
            'lokasi' => Lokasi::findOrFail($id)
        ]);
    }

    public function UpdatePendingLocation(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required'
        ]);

        Lokasi::where('id', $id)->update($validatedData);
        if($validatedData["status"] == 'approved'){
            $lokasi = Lokasi::findOrFail($id);
            $user_id = $lokasi->created_by;
            User::where('id', $user_id)->update(['lokasi_id' => $lokasi->id]);
            return redirect('/lokasi-kantor/pending-location')->with('success', 'Lokasi Berhasil Di Approve');    
        } else {
            return redirect('/lokasi-kantor/pending-location')->with('success', 'Lokasi Berhasil Di Reject');    
        }
    }

    public function updateLokasi(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_lokasi' => 'required',
            'lat_kantor' => 'required',
            'long_kantor' => 'required'
        ]);

        Lokasi::where('id', $id)->update($validatedData);
        return redirect('/lokasi-kantor')->with('success', 'Lokasi Berhasil Diupdate');    
    }

    public function updateRequestLocation(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_lokasi' => 'required',
            'lat_kantor' => 'required',
            'long_kantor' => 'required',
            'status' => 'required'
        ]);

        Lokasi::where('id', $id)->update($validatedData);
        return redirect('/request-location')->with('success', 'Lokasi Berhasil Diupdate');    
    }

    public function updateRadiusLokasi(Request $request, $id)
    {
        $validatedData = $request->validate([
            'radius' => 'required',
        ]);

        Lokasi::where('id', $id)->update($validatedData);
        return redirect('/lokasi-kantor')->with('success', 'Lokasi Berhasil Diupdate');
    }

    public function updateRadiusRequestLocation(Request $request, $id)
    {
        $validatedData = $request->validate([
            'radius' => 'required',
            'status' => 'required'
        ]);

        Lokasi::where('id', $id)->update($validatedData);
        return redirect('/request-location')->with('success', 'Lokasi Berhasil Diupdate');
    }

    public function deleteLokasi($id)
    {
        $check = User::where('lokasi_id', $id)->count();
        if ($check > 0) {
            Alert::error('Failed', 'Masih Ada User Yang Menggunakan Lokasi Ini!');
            return back();
        } else {
            $lokasi = Lokasi::findOrFail($id);
            $lokasi->delete();
        }
        return redirect('/lokasi-kantor')->with('success', 'Lokasi Berhasil Di Delete');
    }

    public function deleteRequestLocation($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        $user = User::where('lokasi_id', $id)->count();
        if($user > 0) {
            Alert::error('Failed', 'Masih Ada User Yang Menggunakan Lokasi Ini!');
            return redirect('/request-location');
        } else {
            $lokasi->delete();
            return redirect('/request-location')->with('success', 'Lokasi Berhasil Di Delete');
        }
    }
}
