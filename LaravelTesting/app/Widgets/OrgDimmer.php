<?php

namespace App\Widgets;

/**
 * OrgDimmer Widget
 *
 * @category   OrgDimmer Widget
 * @package    CoRA-Dimmer Widget
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use TCG\Voyager\Widgets\BaseDimmer;
use Illuminate\Support\Str;
use App\Org;
use Illuminate\Support\Facades\Auth;

class OrgDimmer extends BaseDimmer
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
        $count = Org::count();
        $string = "Orgs";

        if ($user->isAdmin()) {
            return view('voyager::dimmer', array_merge($this->config, [
                'icon'   => 'voyager-company',
                'title'  => "{$count} {$string}",
                'text'   => __('voyager.dimmer.user_text', ['count' => $count, 'string' => Str::lower($string)]),
                'button' => [
                    'text' => 'Orgs',
                    'link' => route('voyager.orgs.index'),
                ],
                'image' => 'storage/images/widget-backgrounds/orgs.jpg',
            ]));
        } else {
            return view('voyager::dimmer', array_merge($this->config, [
                'icon'   => 'voyager-company',
                'title'  => "{$user->org->name}",
                'text' => 'To view your Organization information, click below',
//                'text'   => __('voyager.dimmer.user_text', ['count' => $count, 'string' => Str::lower($string)]),
                'button' => [
                    'text' => 'View Org',
                    'link' => url('/admin/orgs/'.$user->org->id),
                ],
                'image' => 'storage/images/widget-backgrounds/orgs.jpg',
            ]));
        }

        // ToDo: Image Accreditation
//        <a style="background-color:black;color:white;text-decoration:none;padding:4px 6px;font-family:-apple-system, BlinkMacSystemFont, &quot;San Francisco&quot;, &quot;Helvetica Neue&quot;, Helvetica, Ubuntu, Roboto, Noto, &quot;Segoe UI&quot;, Arial, sans-serif;font-size:12px;font-weight:bold;line-height:1.2;display:inline-block;border-radius:3px;" href="https://unsplash.com/@maxwbender?utm_medium=referral&amp;utm_campaign=photographer-credit&amp;utm_content=creditBadge" target="_blank" rel="noopener noreferrer" title="Download free do whatever you want high-resolution photos from Max Bender"><span style="display:inline-block;padding:2px 3px;"><svg xmlns="http://www.w3.org/2000/svg" style="height:12px;width:auto;position:relative;vertical-align:middle;top:-1px;fill:white;" viewBox="0 0 32 32"><title></title><path d="M20.8 18.1c0 2.7-2.2 4.8-4.8 4.8s-4.8-2.1-4.8-4.8c0-2.7 2.2-4.8 4.8-4.8 2.7.1 4.8 2.2 4.8 4.8zm11.2-7.4v14.9c0 2.3-1.9 4.3-4.3 4.3h-23.4c-2.4 0-4.3-1.9-4.3-4.3v-15c0-2.3 1.9-4.3 4.3-4.3h3.7l.8-2.3c.4-1.1 1.7-2 2.9-2h8.6c1.2 0 2.5.9 2.9 2l.8 2.4h3.7c2.4 0 4.3 1.9 4.3 4.3zm-8.6 7.5c0-4.1-3.3-7.5-7.5-7.5-4.1 0-7.5 3.4-7.5 7.5s3.3 7.5 7.5 7.5c4.2-.1 7.5-3.4 7.5-7.5z"></path></svg></span><span style="display:inline-block;padding:2px 3px;">Max Bender</span></a>
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
            return $user->isAdmin() ? true : $user->can('browse', Voyager::model('Org'));
        }
        return false;
    }
}
