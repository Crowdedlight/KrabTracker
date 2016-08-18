<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Validator;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Option;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Auth;

class EveSsoController extends Controller
{
    protected $_provider;

    public function __construct()
    {
        $this->_provider = \App::make('Eve');
    }

    public function login(){
        session('sso_state', $this->_provider->getState());
        $args = [
            'scope' => explode("|", config('eve.crest_scopes'))
        ];
        return new RedirectResponse($this->_provider->getAuthorizationUrl($args));
    }

    public function callback(Request $request) {
        $token = $this->_provider->getAccessToken('authorization_code', ['code' => $request->input('code')]);
        session('sso_token', $token);
        $sso_data = $this->_provider->getResourceOwner($token);

        $client = new Client();
        $xml_api_url = 'https://api.eveonline.com/eve/CharacterAffiliation.xml.aspx?ids='.$sso_data->getCharacterID();
        $response = $client->request('GET', $xml_api_url);
        $xml = simplexml_load_string($response->getBody()->getContents());

        if (!isset($xml->result->rowset->row->attributes()["characterID"])) {
            return redirect()->route('home')->withErrors(['login' => 'Character not valid.']);
        }

        $corp_id = (string)$xml->result->rowset->row->attributes()["corporationID"];
        $allianz_id = (string)$xml->result->rowset->row->attributes()["allianceID"];

        $option = Option::where('type', 'allowed_corps')->where('value', $corp_id)->get();

        if($option->isEmpty()){
            return abort(403);
        }

        $user = User::firstOrCreate(['character_id' => $sso_data->getCharacterID()]);
        $user->character_id = $sso_data->getCharacterID();
        $user->name = $sso_data->getCharacterName();
        $user->corp_id = $corp_id;
        $user->alliance_id = $allianz_id;
        $user->character_owner_hash = $sso_data->getCharacterOwnerHash();
        $user->refresh_token = $token->getRefreshToken();
        $user->save();

        Auth::login($user);

        return redirect()->route('home');
    }

    public function logout() {
        Auth::logout();

        return redirect()->route('home');
    }

}
