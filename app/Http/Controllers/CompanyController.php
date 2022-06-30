<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use DB;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use DataTables;

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

        $isCompany = $request->comid;

        if(empty($isCompany)) {

            // insert fresh company data
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
                    'success' => 'Company details inserted.'
                ]);
            }
        } else {

            // update company details
            $delete = Company::where('id', $isCompany)->get();
            Storage::delete('public/companylogo/'.$delete->logo);

            $filename = time().$request->file('logo')->getClientOriginalName();
            $fileStored = $request->file('logo')->storeAs('public/companylogo', $filename);

            $info = Company::where('id', $isCompany)->update([
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
                    'success' => 'Company details has been updated.'
                ]);
            }
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
        // $companyDetails = Company::with('province', 'district', 'vdcormunicipalities')->get();
        // $value = "";
        // if ($companyDetails) {
        //     foreach ($companyDetails as $comp) {
        //         $value .= "<tr>
        //         <td>".$comp->name."</td>
        //         <td>".$comp->email."</td>
        //         <td>".$comp->website."</td>
        //         <td>".$comp->province->provincename." ".$comp->district->districtname." ".
        //             $comp->vdcormunicipalities->municipalityname."</td>

        //         <td><img src='".asset('storage/companylogo/'.$comp->logo)."' height='25px'
        //                 width='25px' /></td>
        //         <td>
        //             <a href='#' data-id='".$comp->id."' class='editCompany'><i class='fa-solid fa-pen fa-lg mr-1'
        //                     style='color:blue'></i></a>
        //             <a href='#' data-id='".$comp->id."' class='removeCompany'><i
        //                     class='fa-solid fa-delete-left fa-lg ml-1' style='color:red'></i></a>
        //         </td>
        //     </tr>";
        //     }

        //     echo $value;
        // }
        $companyDetails = Company::with('province', 'district', 'vdcormunicipalities')->get();
        $companyArray = array();
        $i = 1;
        foreach ($companyDetails as $comp) {
            $companyArray[$i]['count'] = $i++;
            $companyArray[$i]['name'] = $comp->name;
            $companyArray[$i]['email'] = $comp->email;
            $companyArray[$i]['website'] = $comp->website;
            $companyArray[$i]['address'] = $comp->province->provincename." ".$comp->district->districtname." ".$comp->vdcormunicipalities->municipalityname;
            $companyArray[$i]['logo'] = asset('storage/companylogo/'.$comp->logo);
            $companyArray[$i]['action'] = "<a href='#' data-id='".$comp->id."' class='editCompany'><i class='fa-solid fa-pen fa-lg mr-1' style='color:blue'></i></a><a href='#' data-id='".$comp->id."' class='removeCompany'><i class='fa-solid fa-delete-left fa-lg ml-1' style='color:red'></i></a>";
        }
        return DataTables::of($companyArray)->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $company = Company::with('province', 'district', 'vdcormunicipalities')->where('id', $request->id)->first();
        if ($company) {
            return response()->json([
                'companyid' => $company->id,
                'companyname' => $company->name,
                'companyemail' => $company->email,
                'companyprovince' => $company->provinceid,
                'companydistrict' => $company->districtid,
                'companyvdc' => $company->vdcormunicipalityid,
                'companywebsite' => $company->website,
                'companylogo' => $company->logo
            ]);
        }
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
