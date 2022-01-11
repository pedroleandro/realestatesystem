<?php

namespace LaraDev\Http\Controllers\Admin;

use Illuminate\Http\Request;
use LaraDev\Http\Controllers\Controller;
use LaraDev\Http\Requests\Admin\PropertyRequest;
use LaraDev\Property;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.properties.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.properties.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PropertyRequest $request)
    {
        $newProperty = Property::create($request->all());

        return redirect()->route('admin.properties.edit', [
            'property' => $newProperty->id
        ])->with(['color' => 'green', 'message' => 'Imóvel cadastrado com sucesso']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        $property = Property::where('id', $id)->first();

        return view('admin.properties.edit', [
            'property' => $property
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PropertyRequest $request, $id)
    {
        $property = Property::where('id', $id)->first();

        $property->setSaleAttribute($request->sale);
        $property->setRentAttribute($request->rent);
        $property->setAirConditioningAttribute($request->air_conditioning);
        $property->setBarAttribute($request->bar);
        $property->setLibraryAttribute($request->library);
        $property->setBarbecueGrillAttribute($request->barbecue_grill);
        $property->setAmericanKitchenAttribute($request->american_kitchen);
        $property->setFittedKitchenAttribute($request->fitted_kitchen);
        $property->setPantryAttribute($request->pantry);
        $property->setEdiculeAttribute($request->edicule);
        $property->setOfficeAttribute($request->office);
        $property->setBathtubAttribute($request->bathtub);
        $property->setFireplaceAttribute($request->fireplace);
        $property->setLavatoryAttribute($request->lavatory);
        $property->setFurnishedAttribute($request->furnished);
        $property->setPoolAttribute($request->pool);
        $property->setSteamRoomAttribute($request->steam_room);
        $property->setViewOfTheSeaAttribute($request->view_of_the_sea);

        $property->fill($request->all());

        if (!$property->save()) {
            return redirect()->back()->withInput()->withErrors();
        }

        return redirect()->route('admin.properties.edit', [
            'user' => $property->id
        ])->with(['color' => 'green', 'message' => 'Imóvel atualizado com sucesso']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
