<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\SingleLink;
use Auth;

class SingleLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth',['except' => ['singleLinkWhatsApp']]);
    }

    public function index()
    {
        $links = SingleLink::where('user_id','=',\Auth::user()->id)->get();
        return view('singleLink')->with('links',$links);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $singlelink = SingleLink::where('user_id','=',\Auth::user()->id)->get();
        $totalSingleLink = $singlelink->count();

        if($totalSingleLink<5){
            $shortURLValidator = Validator::make(
                $request->all(),
                [
                    'short_url' => 'unique:single_links,short_url',
                ],
            );

            $phoneValidator = Validator::make(
                $request->all(),
                [
                    'phone' => 'required|numeric|regex:/(01)/|digits_between:10,12'
                ],
            );

            if($shortURLValidator->fails()){
                $Response = ['error'=> 'Short URL has been taken.'];
            }
            else if($phoneValidator->fails()){
                $Response = ['error'=> 'Invalid phone number given.'];
            }
            else{
                $encodePretext = rawurlencode($request['pretext']);
                SingleLink::create([
                    'short_url' => $request['short_url'],
                    'phone' => $request['phone'],
                    'pretext' => $encodePretext,
                    'user_id' => \Auth::user()->id
                ]);
                $Response = ['success'=>'Link successfully generated'];
            }
        }else{
            $Response = ['error'=>'Sorry, but you can only have 5 maximum single links.'];
        }


        return response()->json($Response,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $link = SingleLink::findOrFail($id);
        return $link;
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

        $shortURLValidator = Validator::make(
            $request->all(),
            [
                'short_url' => 'unique:single_links,short_url,'.$id.',id'
            ],
        );

        $phoneValidator = Validator::make(
            $request->all(),
            [
                'phone' => 'required|numeric|regex:/(01)/|digits_between:10,12'
            ],
        );

        if($shortURLValidator->fails()){
            $Response = ['error'=> 'Short URL has been taken.'];
        }
        else if($phoneValidator->fails()){
            $Response = ['error'=> 'Invalid phone number given.'];
        }
        else{

            $link = SingleLink::findorFail($id);
            $encodePretext = rawurlencode($request['pretext']);

            $link->short_url = $request['short_url'];
            $link->phone = $request['phone'];
            $link->pretext = $encodePretext;
            $link->save();
        $Response = ['success'=>'Link successfully updated'];
        }

        return response()->json($Response,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $link = SingleLink::findOrFail($id);
        $link->delete();

        return response()->json($link);
    }

    public function singleLinkWhatsApp($shortURL)
    {
        $link = SingleLink::where('short_url',$shortURL)->first();

        if($link){
            if($link->phone != ""){
                $encodePretext = $link->pretext;
                $short_url = $link->short_url;
                $phone = $link->phone;
                $phoneWithout0 = substr($phone,1);

                header('Location: https://wa.me/60'.$phoneWithout0.'?text='.$encodePretext);
                die();
            }else{
                $encodePretext = $link->pretext;
                $short_url = $link->short_url;
                header('Location: https://wa.me/?text='.$encodePretext);
                die();
            }

        }else{
            return view('error');
        }
    }
}
