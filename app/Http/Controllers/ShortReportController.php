<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShortReport;

class ShortReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['short_report'] = ShortReport::orderBy('number', 'asc')->get();
        
        return view('pages.shortReport.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $checkNumber = ShortReport::where('number', request('number'))->first();
        if($checkNumber != null)
        {
            return redirect()->back()->with("ERR", "Kode rekening telah digunakan");
        }
        ShortReport::create([
            'number'  => request('number')
        ]);
        
        return redirect()->back()->with("OK", "Berhasil menambahkan data");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShortReport  $shortReport
     * @return \Illuminate\Http\Response
     */
    public function show(ShortReport $shortReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShortReport  $shortReport
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = ShortReport::findOrFail($id);
        
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShortReport  $shortReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = ShortReport::findOrFail($id);
        $checkNumber = ShortReport::where('number', request('number'))->first();
        if($checkNumber != null)
        {
            if($checkNumber->id != $data->id)
            {
                return redirect()->back()->with("ERR", "Kode Rekening telah digunakan");
            }
        }
        
        $data->update([
            'number'  => request('number')
        ]);
        
        return redirect()->back()->with("OK", "Berhasil mengubah data");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShortReport  $shortReport
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ShortReport::findOrFail($id);
        $data->delete();
        
        return redirect()->back()->with("OK", "Berhasil menghapus data");
    }
}
