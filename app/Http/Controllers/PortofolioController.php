<?php

namespace App\Http\Controllers;

use App\Models\Portofolio;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PortofolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $this->middleware('auth');
        return view('portofolio.index', [
            'portofolios' => Portofolio::all(),
        ]);
    }

    public function portofolio()
    {
        return view('pengunjung.portofolio', [
            // 'profiles' => User::all(),
            'portofolios' => Portofolio::all(),
        ]);
    }

    public function profil()
    {
        return view('pengunjung.profil', [
            'portofolio' => Portofolio::all(),
            'profil' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('portofolio.create', [
            'profiles' => User::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $validatedData = $request->validate([
            'user_id' => 'required',
            'pengalaman' => 'required',
            'kemampuan' => 'required',
            'aktivitas_sekarang' => 'required',
            'gambar_utama' => 'image|file|max:1024',
            // 'gambar1' => 'image|file|max:1024',
            // 'gambar2' => 'image|file|max:1024',
            // 'gambar3' => 'image|file|max:1024',
        ]);

        if($request->file('gambar_utama')){
            $validatedData['gambar_utama'] = $request->file('gambar_utama')->store('gambar_utama');
        }
        
        Portofolio::create($validatedData);

        return redirect('portofolio')->with('success', 'Portofolio telah ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Portofolio  $portofolio
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Portofolio  $portofolio
     * @return \Illuminate\Http\Response
     */
    public function edit(Portofolio $portofolio)
    {
        return view('portofolio.edit', [
            'portofolio' => $portofolio,
            'profiles' => User::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portofolio  $portofolio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'pengalaman' => 'required',
            'kemampuan' => 'required',
            'aktivitas_sekarang' => 'required',
            'gambar_utama' => 'image|file|max:1024',

        ]);

        if($request->file('gambar_utama')){
            if ($request->oldImage) {
                storage::delete($request->oldImage);
            }
            $validatedData['gambar_utama'] = $request->file('gambar_utama')->store('gambar_utama');
        }

        $portofolio = Portofolio::find($id)
            ->update($validatedData);

        return redirect('portofolio')->with('success', 'Portofolio telah diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portofolio  $portofolio
     * @return \Illuminate\Http\Response
     */
    public function destroy($portofolio_id)
    {
        $portofolio = Portofolio::where('id',$portofolio_id)->first();
        $portofolio->delete();     

        if ($portofolio->gambar_utama) {
            storage::delete($portofolio->gambar_utama);
        }

        return redirect('portofolio')->with('success', 'Portofolio telah dihapus');
    }
}
