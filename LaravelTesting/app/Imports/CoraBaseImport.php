<?php

/**
 * Cora Base Import
 *
 * @category   CoraBaseImport
 * @package    CoRA-Imports
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2020
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.1
 */

namespace App\Imports;

use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CoraBaseImport implements ToCollection, WithHeadingRow
{
    protected $server = "ContructorNotCalled";
    protected $theUserID = null;
    protected $theUser = null;
    protected $theOrg = null;
    protected $theProject = null;
    protected $dt = null;
    protected $import_count = 0;

    public function __construct(User $user)
    {
        $this->server = config('app.env');
        $this->theUserID = $user->id;
        $this->theUser = $user;
        $this->theOrg = $this->theUser->org;
        $this->theProject = $this->theUser->getCurrentProject();
        $this->dt = date_create();
        $this->import_count = 0;
    }

    public function collection(Collection $collection)
    {
        Log::info(__METHOD__.' Should never get here. child class must override collection() method');
    }
}