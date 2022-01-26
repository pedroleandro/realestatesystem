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
        return view('web.filter');
    }

    public function sale()
    {
        return view('web.filter');
    }

    public function rentProperty(Request $request)
    {
        $property = Property::where('slug', $request->slug)->first();
    }

    public function saleProperty(Request $request)
    {
        $property = Property::where('slug', $request->slug)->first();
    }

    public function filter()
    {
        return view('web.filter');
    }
}
