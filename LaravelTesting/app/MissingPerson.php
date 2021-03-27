<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class MissingPerson extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $table='missing_persons';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['uuid','org_id','project_id','case_manager_id','lab_project_manager_id','case_number','conflict','serial_number','incident','case_status','field_grave','temp_field_grave','lab_notes',
        'case_notes','case_manager','case_assign_date','case_complete_date','case_partial_date','case_exhausted_all_resources_date','case_identification_date','case_remains_in_lab_date',
        'first_name','last_name','middle_name','suffix','correct_name','country','frs_xfile','priority_dpaa','priority_pcrb','frs_request_mtdna_1',
        'frs_request_mtdna_2','frs_request_mtdna_3','frs_request_ystr_1','frs_request_ystr_2','frs_request_austr_1','frs_request_austr_2','frs_request_mtdna_1_date','frs_request_mtdna_2_date','frs_request_mtdna_3_date',
        'frs_request_ystr_1_date','frs_request_ystr_2_date','frs_request_austr_1_date','frs_request_austr_2_date','lab_receive_mtdna_1','lab_receive_request_mtdna_2','lab_receive_request_mtdna_3',
        'lab_receive_request_ystr_1','lab_receive_request_ystr_2','lab_receive_request_austr_1','lab_receive_request_austr_2','lab_receive_mtdna_1_date','lab_receive_request_mtdna_2_date',
        'lab_receive_request_mtdna_3_date','lab_receive_request_ystr_1_date','lab_receive_request_ystr_2_date','lab_receive_request_austr_1_date','lab_receive_request_austr_2_date',
        'genealogy_request','genealogy_request_date','genealogy_sent','genealogy_sent_date','genealogy_receive','genealogy_receive_date','genealogy_not_required','genealogy_not_required_date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function org()
    {
        return $this->belongsTo('App\Org', 'org_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }

    /**
     * Get all of the isotopes that are assigned this isotope batch.
     */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function genealogy()
    {
        return $this->belongsTo('App\Geneology', 'mp_id');
    }


}
