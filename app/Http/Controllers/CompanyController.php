<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use DB;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $province = Province::all();
        $companyDetails = Company::with('province', 'district', 'vdcormunicipalities')->get();
        return view('company.company-list', [ 'dataInfo' => $province, 'companyInfo' => $companyDetails]);
    }

    // load districts
    public function loadDistricts(Request $request) {
        $districts = DB::table('districts')->where('provinceid', $request->provinceid)->get();
        $value = "<option value='' selected>Choose District...</option>";
        if (!empty($districts)) {
            foreach($districts as $dist) {
                $value .= "<option value='".$dist->id."'>".$dist->districtname."</option>";
            }
            echo $value;
        }
    }

    // load vdc or municipality
    public function loadVdc(Request $request) {
        $vdcs = DB::table('vdcormunicipalities')->where('districtid', $request->districtid)->get();
        $value = "<option value='' selected>Choose Vdc or Municipality...</option>";
        if (!empty($vdcs)) {
            foreach($vdcs as $dist) {
                $value .= "<option value='".$dist->id."'>".$dist->municipalityname."</option>";
            }
            echo $value;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'website' => 'required | unique:companies',
            'logo' => 'required',
            'email' => 'required | email | unique:companies',
            'province' => 'required',
            'district' => 'required',
            'vdcormunicipality'  => 'required',
        ]);
        $filename = time().$request->file('logo')->getClientOriginalName();
        $fileStored = $request->file('logo')->storeAs('public/companylogo', $filename);

        $info = Company::create([
            'name' => $request->name,
            'website' => $request->website,
            'logo' => $filename,
            'email' => $request->email,
            'provinceid' => $request->province,
            'districtid' => $request->district,
            'vdcormunicipalityid' => $request->vdcormunicipality
        ]);
        if(!empty($fileStored) && !empty($info)) {
            return back()->with('success', 'Data Inserted Successfully.');
        } else {
            return back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
