<?php

namespace Tests;


/*
 * In order to use Laravel Dusk Dashboard
 * comment out "use Laravel\Dusk\TestCase as BaseTestCase;" which is original line
 * and use "BeyondCode\DuskDashboard\Testing\TestCase as BaseTestCase;"
 */
use Laravel\Dusk\TestCase as BaseTestCase;
//use BeyondCode\DuskDashboard\Testing\TestCase as BaseTestCase;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Log;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $m_headless = true;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        Log::info(__METHOD__.' : '.$this->m_headless ? 'headless=true' : 'headless=false');

        /*
         * By default screenshots are in 800×600 size no matter on your local machine screen resolution.
         * It’s quite possible you would like to get higher resolution screenshots in case of failure.
         * To make it work go again into tests/DuskTestCase.php and add additional option
         * –window-size= with your preferred browser size that will also affect size of
         * screenshots. Example --window-size=1920,1200
         */
        $options = (new ChromeOptions)->addArguments([
            '--disable-gpu',
            '--headless',   // comment this out it you want to see the test in browser
//            '--no-sandbox',
//            '--force-device-scale-factor=1',
//            ($this->m_headless) ? '--headless' : '',
            '--window-size=1024,768'
        ]);

        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()->setCapability(
            ChromeOptions::CAPABILITY, $options
        )
        );
    }
}
