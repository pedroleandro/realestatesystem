<?php

namespace LaraDev\Http\Controllers\Web;

use Illuminate\Http\Request;
use LaraDev\Http\Controllers\Controller;
use LaraDev\Property;

class WebController extends Controller
{
    public function home()
    {
        $propertiesForSale = Property::sale()->available()->limit(3)->get();
        $propertiesForRent = Property::rent()->available()->limit(3)->get();

        return view('web.home', [
            'propertiesForSale' => $propertiesForSale,
            'propertiesForRent' => $propertiesForRent
        ]);
    }

    public function contact()
    {
        return view('web.contact');
    }

    public function rent()
    {
        $filter = new FilterController();
        $filter->clearAllData();

        $properties = Property::rent()->available()->get();

        return view('web.filter', [
            'properties' => $properties,
            'type' => 'rent'
        ]);
    }

    public function sale()
    {
        $filter = new FilterController();
        $filter->clearAllData();

        $properties = Property::sale()->available()->get();

        return view('web.filter', [
            'properties' => $properties,
            'type' => 'sale'
        ]);
    }

    public function rentProperty(Request $request)
    {
        $property = Property::where('slug', $request->slug)->first();

        return view('web.property', [
            'property' => $property,
            'type' => 'rent'
        ]);
    }

    public function saleProperty(Request $request)
    {
        $property = Property::where('slug', $request->slug)->first();

        return view('web.property', [
            'property' => $property,
            'type' => 'sale'
        ]);
    }

    public function filter()
    {
        $filter = new FilterController();

        $itemProperties = $filter->createQuery('id');

        foreach ($itemProperties as $property) {
            $properties[] = $property->id;
        }

        if (!empty($properties)) {
            $properties = Property::whereIn('id', $properties)->get();
        } else {
            $properties = Property::all();
        }

        return view('web.filter', [
            'properties' => $properties
        ]);
    }

    public function experience()
    {
        $filter = new FilterController();
        $filter->clearAllData();

        $properties = Property::whereNotNull('experience')->get();

        return view('web.filter', [
            'properties' => $properties
        ]);
    }

    public function experienceCategory(Request $request)
    {
        $filter = new FilterController();
        $filter->clearAllData();

        if ($request->slug == 'cobertura') {
            $properties = Property::where('experience', 'Cobertura')->get();
        } elseif ($request->slug == 'alto-padrao') {
            $properties = Property::where('experience', 'Alto Padrão')->get();
        } elseif ($request->slug == 'de-frente-para-o-mar') {
            $properties = Property::where('experience', 'De frente para o Mar')->get();
        } elseif ($request->slug == 'condominio-fechado') {
            $properties = Property::where('experience', 'Condomínio Fechado')->get();
        } elseif ($request->slug == 'compacto') {
            $properties = Property::where('experience', 'Compacto')->get();
        } elseif ($request->slug == 'lojas-e-salas') {
            $properties = Property::where('experience', 'Lojas e Salas')->get();
        } else {
            $properties = Property::whereNotNull()->get('experience');
        }

        return view('web.filter', [
            'properties' => $properties
        ]);
    }
}
