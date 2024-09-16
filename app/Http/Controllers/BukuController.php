<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::all();
        return view('buku.index', compact('buku'));
    }

    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_buku' => 'required',
            'pengarang' => 'required',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $input = $request->all();
    
        // Jika ada gambar yang diupload
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('images'), $imageName);
            $input['cover_image'] = $imageName;
        }
    
        Buku::create($input);
    
        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Buku $buku)
    {
        return view('buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'nama_buku' => 'required',
            'pengarang' => 'required',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $input = $request->all();
    
        // Jika ada gambar yang diupload
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('images'), $imageName);
            $input['cover_image'] = $imageName;
        }
    
        $buku->update($input);
    
        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
