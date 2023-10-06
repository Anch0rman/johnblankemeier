<?php namespace Anch0rman\FantasyNormalizer\Components;

use Cms\Classes\ComponentBase;
use \League\OAuth2\Client\Provider\GenericProvider;
use Hayageek\OAuth2\Client\Provider\Yahoo;
use Session;
use Redirect;
use SimpleXMLElement;
use Exception;

/**
 * LeagueData Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class LeagueData extends ComponentBase
{
    protected $yahooKey;

    private $yahooSecret;

    public function componentDetails()
    {
        return [
            'name' => 'PlayerData Component',
            'description' => 'Get Yahoo player data'
        ];
    }

    /**
     * @link https://docs.octobercms.com/3.x/element/inspector-types.html
     */
    public function defineProperties()
    {
        return [
            'leagueSeason' => [
                'title' => 'League Season',
                'description' => 'The current NFL season',
                'default' => 2023,
                'type' => 'string'
            ]
        ];
    }

    public function onRun() {
        $this->yahooKey = env('YAHOO_KEY', null);
        $this->yahooSecret =  env('YAHOO_SECRET', null);
    }

    public function getLeagueSeason():int {
        return $this->property('leagueSeason');
    }

    public function onGetLeagueData() {
        // will this take params? yes
        // will we store data on our server? no
        // will we cache? maybe

        $consumerKey = env('YAHOO_KEY', null);
        $consumerSecret = env('YAHOO_SECRET', null);
        $redirectUri = env('REDIRECT_URI', null);

        $provider = new Yahoo([
            'clientId'     => $consumerKey,
            'clientSecret' => $consumerSecret,
            'redirectUri'  => $redirectUri,
        ]);

        if(empty(get('code'))) {
            $authUrl = $provider->getAuthorizationUrl();
            Session::put('outh2state', $provider->getState());

            return Redirect::to($authUrl);
        } else {
            $token = Session::get('token', false);
            // trace_log('expires in ' . $token->getExpires() - time() . ' seconds');
            if($token === false || $token->hasExpired()){
                $token = $provider->getAccessToken('authorization_code', [
                    'code' => get('code')
                ]);
                Session::put('token', $token);
            }

            $leagueId = post('league-id');
            $league = "https://fantasysports.yahooapis.com/fantasy/v2/league/nfl.l.{$leagueId}/settings";

            $request = $provider->getAuthenticatedRequest('GET', $league, $token);
            $response = $provider->getParsedResponse($request);

            $xml = new SimpleXMLElement($response);
            if(!empty($xml->description)) $content = (string) $xml->description;
            else $content = "League name: " . (string) $xml->league->name;

            $this->page['league_name'] = $content;
        }
    }
}
