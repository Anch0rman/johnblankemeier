<?php namespace Anch0rman\FantasyNormalizer\Components;

use Cms\Classes\ComponentBase;

/**
 * PlayerData Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class PlayerData extends ComponentBase
{
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
        $this->page['quote'] = "Is TB12 the GOAT?";
    }

    public function getLeagueSeason():int {
        return $this->property('leagueSeason');
    }

    public function onGetPlayerData() {
        $this->page['quote'] = "Please return when John is motivated to finish this ;)";
    }
}
