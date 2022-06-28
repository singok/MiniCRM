<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use DB;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;

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
        return view('company.company-list', [ 'dataInfo' => $province]);
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
            return response()->json([
                'status' => 200,
                'success' => 'Data Inserted Successfully'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'error' => 'Something went wrong'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $companyDetails = Company::with('province', 'district', 'vdcormunicipalities')->get();
        $value = "";
        if ($companyDetails) {
            foreach ($companyDetails as $comp) {
                $value .= "<tr>
                <td>".$comp->name."</td>
                <td>".$comp->email."</td>
                <td>".$comp->website."</td>
                <td>".$comp->province->provincename." ".$comp->district->districtname." ".
                    $comp->vdcormunicipalities->municipalityname."</td>

                <td><img src='".asset('storage/companylogo/'.$comp->logo)."' height='25px'
                        width='25px' /></td>
                <td>
                    <a href='#'><i class='fa-solid fa-pen fa-lg mr-1'
                            style='color:blue'></i></a>
                    <a href='#' data-id='".$comp->id."' class='removeCompany'><i
                            class='fa-solid fa-delete-left fa-lg ml-1' style='color:red'></i></a>
                </td>
            </tr>";
            }

            echo $value;
        }
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
    public function destroy(Request $request)
    {
        $company = Company::where('id', $request->id)->first();
        $deleted = Storage::delete('public/companylogo/'.$company->logo);
        $info = Company::where('id', $request->id)->delete();
        if (!empty($deleted) && !empty($info)) {
            return response()->json([
                'status' => 200,
                'success' => 'Company Detail Deleted Successfully.'
            ]);
        }
    }
}
