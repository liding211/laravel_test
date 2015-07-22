<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Author;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdController extends Controller
{
    /**
     * Display list of ads
     * 
     * @param Request $request
     * @param string $order
     * @return \Illuminate\View\View
     */
    public function adsList(Request $request, $order = '')
    {
        //set sort type to session
        if(!empty($order) && in_array($order, ['asc', 'desc'])){
            $request->session()->set('ads_sorting_order', $order);
        }
        if(!($request->session()->has('ads_sorting_order'))){
            $request->session()->set('ads_sorting_order', 'asc');
        }
        
        $order = $request->session()->get('ads_sorting_order');
        $ads = \DB::table('ad')->orderBy('id', $order)->simplePaginate(10);
        return view('ads_list', ['ads' => $ads]);
    }
    
    /**
     * Display new ad form page
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function newAd(Request $request)
    {   
        if($request->isMethod(Request::METHOD_POST)){
            $new_ad_id = $this->saveNewAd($request);
            $this->saveNewAdAuthor($request, $new_ad_id);
            return redirect('/');
        }
        return view('new_ad');
    }
    
    public function showAdDetails(Request $request)
    {
        if($request->isXmlHttpRequest()){
            $ad = Ad::find(intval($request->get('id')));
            return response()->json($ad);
        }
    }
    
    /**
     * Validate form data
     * 
     * @param Request $request
     * @return void
     */
    public function validateAdForm(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'text' => 'required',
            //most common types from https://en.wikipedia.org/wiki/Comparison_of_web_browsers#Image_format_support
            'image' => 'mimes:jpeg,bmp,png,gif,jpg'         
        ]);
    }
    
    /**
     * Create new ad and save
     * 
     * @param Request $request 
     * @return integer
     */
    public function saveNewAd(Request $request)
    {
        $ad = new Ad();
        $ad->title = htmlspecialchars($request->get('title'));
        $ad->text = htmlspecialchars($request->get('text'));

        $image = $request->file('image');
        if($image && $image->isValid()){
            $image_name = date('Ymd') . '_' 
                . md5($image->getClientOriginalName()) . '.' 
                . $image->getClientOriginalExtension();
            $image->move(public_path('upload/images'), $image_name);
            $ad->image = $image_name;
        }
        $ad->save();
        
        return $ad->id;
    }
    
    /**
     * Save author of new ad
     * 
     * @param Request $request
     * @param integer $ad_id
     * @return void 
     */
    public function saveNewAdAuthor(Request $request, $ad_id)
    {
        $author = new Author();
        $author->ad_id = $ad_id;
        $author->ip = $request->getClientIp();
        $browser = get_browser(null, true);
        $author->browser = $browser['browser'];
        $location_info = \Torann\GeoIP\GeoIPFacade
            ::getLocation($request->getClientIp());
        $author->country = $location_info['isoCode'];
        $author->save();
    }
}
