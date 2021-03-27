<?php

namespace App\Widgets;

/**
 * UserDimmer Widget
 *
 * @category   UserDimmer Widget
 * @package    CoRA-Dimmer Widget
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use TCG\Voyager\Widgets\BaseDimmer;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\Auth;

class UserDimmer extends BaseDimmer
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $user = Auth::user();
        $count = Voyager::model('User')->count();
        if (!$user->isAdmin()) {
            $count = $user->forOrg($user->org)->count();
        }

        $string = trans_choice('voyager.dimmer.user', $count);

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-group',
            'title'  => "{$count} {$string}",
            'text'   => __('voyager.dimmer.user_text', ['count' => $count, 'string' => Str::lower($string)]),
            'button' => [
                'text' => __('voyager.dimmer.user_link_text'),
                'link' => route('voyager.users.index'),
            ],
            'image' => voyager_asset('images/widget-backgrounds/01.jpg'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        $user = Auth::user();
        if (isset($user)) {
            return $user->isAdmin() ? true : $user->can('browse', Voyager::model('User'));
        }
        return false;
    }
}
