<?php namespace App\Http;

use App;
use GuzzleHttp\Exception\ConnectException;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;


class CrestHelper {

    public static function getFleetData($refreshToken, $fleetUrl){
        $eve = \App::make('Eve');

        try {
            $access_token = $eve->getAccessToken('refresh_token', [
                'refresh_token' => $refreshToken
            ]);

            $fleetRequest = $eve->getAuthenticatedRequest(
                'GET',
                $fleetUrl,
                $access_token->getToken()
            );

            $fleet_data = $eve->getResponse($fleetRequest);

            $membersRequest = $eve->getAuthenticatedRequest(
                'GET',
                $fleet_data['members']['href'],
                $access_token->getToken()
            );

            $members_data = $eve->getResponse($membersRequest);

        } catch (IdentityProviderException $exception) {
            return null;
        } catch (ConnectException $exception) {
            return false;
        }

        $members_data = $eve->getResponse($membersRequest);

        $data = [];
        foreach ($members_data['items'] as $index => $member) {
            $data[$index]['name'] = $member['character']['name'];
            $data[$index]['character_id'] = $member['character']['id'];
            $data[$index]['ship'] = $member['ship']['name'];
            $data[$index]['joined'] = $member['joinTime'];
        }

        return $data;
    }

    public static function getTime() {
        $eve = \App::make('Eve');

        try{
            $timeRequest = $eve->getAuthenticatedRequest(
                'GET',
                'https://crest-tq.eveonline.com/time/',
                ''
            );

            $time = $eve->getResponse($timeRequest);
        } catch (ConnectException $exception) {
            return false;
        } catch (IdentityProviderException $exception) {
            return false;
        }

        return $time;
    }
}