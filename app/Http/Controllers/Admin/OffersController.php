<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offers;

class OffersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offers::paginate(10);
        return view('admin.offers.list',compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.offers.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = request()->validate([
            'offer_title' => 'required|max:255',
            'validity' => 'required',
            'offer_code' => 'required',
        ]);
        $userId = auth()->user()->id;
        $addedby = json_encode(['type' => 'admin', 'id' => $userId]);

        $insert = Offers::Create([
            'title' => $request->offer_title,
            'spec' => $request->description,
            'added_by' => $addedby,
            'till' =>  $request->validity,
            'code' => $request->offer_code,
            'status' => $request->status,

        ]);
        
        if($insert){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Offers details added successfully !');
            return redirect('admin/offer');
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
        $getDetails = Offers::find($id);
        return view('admin.offers.edit', compact('getDetails'));
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
        $input = request()->validate([
            'offer_title' => 'required|max:255',
            'validity' => 'required',
            'offer_code' => 'required',
        ]);
        $userId = auth()->user()->id;
        $addedby = json_encode(['type' => 'admin', 'id' => $userId]);

        $updateArr = [
            'title' => $request->offer_title,
            'spec' => $request->description,
            'added_by' => $addedby,
            'till' =>  $request->validity,
            'code' => $request->offer_code,
            'status' => $request->status,

        ];

        $update = Offers::find($id)->update($updateArr);
        
        if($update){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Offers details updated successfully !');
             return redirect()->route('offer.edit', $id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $offer = Offers::findOrFail($id);
        $brand->delete();
        return redirect()->route('offer.index');
    }
}
