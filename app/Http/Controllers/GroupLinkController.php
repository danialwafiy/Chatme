<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\GroupLink;
use App\GroupLinkPretext;


class GroupLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth',['except' => ['groupLinkWhatsApp','redirectWhatsApp']]);
    }

    public function index()
    {
        $grouplinks = GroupLink::where('user_id','=',\Auth::user()->id)->get();
        return view('groupLink')->with('grouplinks',$grouplinks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $grouplink = GroupLink::where('user_id','=',\Auth::user()->id)->get();
        $totalgroupLink = $grouplink->count();

        if($totalgroupLink<5){
            $shortURLValidator = Validator::make(
                $request->all(),
                [
                    'short_url' => 'unique:group_links,short_url',
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
                $data = $request->all();

                $pretexts = $data['pretext_chat'];

                GroupLink::create([
                    'short_url' => $data['short_url'],
                    'phone' => $data['phone'],
                    'user_id' => \Auth::user()->id
                ]);

                foreach ($pretexts as $pretexts) {

                    if($pretexts != ""){
                        $encodePretext = rawurlencode($pretexts);

                        GroupLinkPretext::create([
                            'short_url' => $data['short_url'],
                            'pretext_chat'=>$encodePretext
                        ]);
                    }
                }
                $Response = ['success'=>'Group link successfully generated'];
            }
        }else{
            $Response = ['error'=>'Sorry, but you can only have 5 maximum group links.'];
        }
        return response()->json($Response,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($shortURL)
    {
        $grouplink = GroupLink::where('short_url','=',$shortURL)->first();
        $grouplinkPretext = GroupLinkPretext::where('short_url','=',$shortURL)->pluck('pretext_chat');


        return ['grouplink'=>$grouplink,'pretext'=>$grouplinkPretext];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $shortURL)
    {
        $shortURLValidator = Validator::make(
            $request->all(),
            [
                'short_url' => 'unique:group_links,short_url,'.$shortURL.',short_url'
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

            $pretexts = $request['pretext_chat'];

            $grouplink = GroupLink::where('short_url','=',$shortURL)->first();
            $grouplink->short_url = $request['short_url'];
            $grouplink->phone = $request['phone'];

            $oldPretext = GroupLinkPretext::where('short_url','=',$shortURL);
            $oldPretext->delete();

            foreach ($pretexts as $pretexts) {
                if($pretexts !=""){
                    $encodePretext = rawurlencode($pretexts);

                    GroupLinkPretext::create([
                        'short_url' => $request['short_url'],
                        'pretext_chat'=>$encodePretext
                    ]);
                }
            }
            
            $grouplink->save();

            $Response = ['success'=>'Group link successfully updated'];
        }

        return response()->json($Response,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($shortURL)
    {
        $groupLinkPretext = GroupLinkPretext::where('short_url','=',$shortURL);
        $groupLinkPretext->delete();

        $grouplink = GroupLink::where('short_url','=',$shortURL)->first();
        $grouplink->delete();

        return response()->json($grouplink);
    }

    public function groupLinkWhatsApp($shortURL)
    {
        $grouplink = GroupLink::where('short_url',$shortURL)->first();
        $pretext = GroupLinkPretext::where('short_url',$shortURL)->pluck('pretext_chat');
        $grouplinkid= GroupLinkPretext::where('short_url',$shortURL)->pluck('id');
        $shortURL = $shortURL;

        if($grouplink){

            foreach($pretext as $pretext){
                $decodePretext[] = rawurldecode($pretext);
            }
            return view('public')->with(compact('grouplink','decodePretext','grouplinkid','shortURL'));
        }
        else{
            return view('error');
        }
    }

    public function redirectWhatsApp($id,$shortURL)
    {
        $link = GroupLink::where('short_url',$shortURL)->first();
        $pretext = GroupLinkPretext::findorFail($id);

        $encodePretext = $pretext->pretext_chat;
        $phone = $link->phone;

        if($link){
            if($phone!=""){
                $phoneWithout0 = substr($phone,1);
                header('Location: https://wa.me/60'.$phoneWithout0.'?text='.$encodePretext);
                die();
            }else{
                header('Location: https://wa.me/?text='.$encodePretext);
                die();
            }
        }else{
            return view('error');
        }
    }
}
