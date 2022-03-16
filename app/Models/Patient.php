<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Patient extends Model
{
	// protected $guarded = [];
	protected $appends = ['naissance', 'age'];
	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['_token', '_method'];
	protected $fillable = [
		'photo',
		'num_securite_sociale',
		'code_national',
		'owned_by',
		'groupe_sanguin',
		'nom',
		'prenom',
		'date_naissance',
		'num_dossier',
		'taille',
		'adresse',
		'ville',
		'commune',
		'situation_familliale',
		'nbre_enfants',
		'poids',
		'travaille1',
		'travaille',
		'sexe',
		'etat',
		'grossesse_id',
		'tabagiste',
		'tabagiste_depuis',
		'tabagiste_arreter_depuis',
		'cigarettes',
		'alcoolique',
		'alcoolique_depuis',
		'drogue',
		'drogue_depuis',
		'num_tel_1',
		'num_tel_2',
		'created_by',
		'details',
		'p_tierce',
		'cosanguinite',
		'debut_regles',
		'duree_cycle',
	];

	public function automedications()
	{
		return $this->hasMany('App\Models\Automedication');
	}

	/**
	 * return le dernier poids enregistré
	 *
	 * @return void
	 * @author 
	 **/
	public function lastPoids()
	{
		return $this->hasOne('App\Models\Poid')->whereIn('created_at', function ($query) {
			return $query->selectRaw("max(created_at)")->from('poids')->groupBy('patient_id');
		});
	}

	public function poids()
	{
		return $this->hasMany('App\Models\Poid');
	}



	//les interventions ip des prescription du patient
	public function interventions()
	{
		return $this->hasMany('App\Models\Intervention')->where('status', 0);
	}
	//les interventions ip des prescription du patient
	public function interventionsValide()
	{
		return $this->hasMany('App\Models\Intervention')->where('status', '1');
	}
	//associate patient to pathologies
	public function pathologies()
	{
		return $this->BelongsToMany('App\Models\Pathologie', 'pathologie_patient', 'patient_id', 'pathologie_id')
			->withPivot('type')
			->where('type', 'path');
	}
	public function antecedentsFamilliaux()
	{
		return $this->BelongsToMany('App\Models\Pathologie', 'pathologie_patient', 'patient_id', 'pathologie_id')
			->withPivot('type')
			->where('type', 'ant');
	}
	//associate patient to allergies
	public function allergies()
	{
		return $this->BelongsToMany('App\Models\Allergie');
	}

	public function operations()
	{
		return $this->BelongsToMany('App\Models\Operation_chirugicale');
	}

	//define one to one relationships with user
	public function messages()
	{
		return $this->hasMany('App\Models\Message')->orderBy('date_message', 'DESC');
	}

	public function created_by_user()
	{
		return $this->belongsTo('App\User', 'created_by'); // the second argument is used to determine the foreign key of user in patients tables
	}
	public function medecinTraitant()
	{
		return $this->belongsTo('App\User', 'owned_by'); // the second argument is used to determine the foreign key of user in patients tables
	}
	public function hospitalisation()
	{
		return $this->hasMany('App\Models\Hospitalisation'); // the second argument is used to determine the foreign key of user in patients tables
	}
	public function hospiDesc()
	{
		return $this->hasMany('App\Models\Hospitalisation')->orderBy('date_admission', 'desc'); // the second argument is used to determine the foreign key of user in patients tables
	}
	public function act()
	{
		return $this->hasMany('App\Models\act_medicale_patient'); // the second argument is used to determine the foreign key of user in patients tables
	}
	public function actDesc()
	{
		return $this->belongsToMany('App\Models\act_medicale', 'act_medicale_patients', 'patient_id', 'act_medicale_id')->orderBy('date_act', 'desc'); // the second argument is used to determine the foreign key of user in patients tables
	}
	/**
	 * get the last hospitalisation
	 *
	 * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
	 * @return void
	 */
	public function hospi()
	{
		return $this->hasOne('App\Models\Hospitalisation')
			->whereIn('date_admission', function ($query) {
				$query->selectRaw('max(date_admission)')
					->from('hospitalisations')
					->groupBy('patient_id');
			});
	}


	public function pregnant()
	{
		return $this->belongsTo('App\Models\Grossesse', 'grossesse_id', 'cdf_code_pk');
	}
	public function bilans()
	{
		return $this->hasMany('App\Models\Bilan')->orderBy('date_analyse', 'desc');
	}
	public function bilansDesc()
	{
		return $this->hasMany('App\Models\Bilan')
			->orderBy('date_analyse', 'desc');
	}
	public function bilansRadiologique()
	{
		return $this->hasMany('App\Models\Bilan')
			->whereNull('element_id')
			->orderBy('date_analyse', 'desc');
	}
	public function radiosDesc()
	{
		return $this->hasMany('App\Models\Bilan')
			->where('type', 'radio')
			->orderBy('date_analyse', 'desc');
	}
	public function bilansMax()
	{
		return $this->hasMany('App\Models\Bilan')->select(DB::raw('bilans.*,max(date_analyse) '))->groupBy('bilans.element_id');
	}
	public function consultations()
	{
		return $this->hasMany('App\Models\Consultation');
	}
	public function consultationsDesc()
	{
		return $this->hasMany('App\Models\Consultation')->orderBy('date_consultation', 'desc');
	}
	public function traitements()
	{
		return $this->hasMany('App\Models\Traitementchronique', 'patient_id', 'id')
			->join('ligneprescriptions', 'traitementchroniques.id', 'ligneprescriptions.traitementchronique_id')
			->join(DB::raw('(SELECT distinct(max(date_etats)) as topdate
							FROM `ligneprescriptions`  
							group by med_sp_id) as t'), function ($join) {
				$join->on('t.topdate', '=', 'ligneprescriptions.date_etats');
			})
			->whereNull('ligneprescriptions.tmp');
	}
	public function traitementsDesc()
	{
		return $this->hasMany('App\Models\Traitementchronique', 'patient_id', 'id')

			->orderBy('traitementchroniques.created_at', 'desc')
			->join('ligneprescriptions', 'traitementchroniques.id', 'ligneprescriptions.traitementchronique_id')
			->join(DB::raw('(SELECT distinct(max(date_etats)) as topdate
							FROM `ligneprescriptions`  
							group by med_sp_id) as t'), function ($join) {
				$join->on('t.topdate', '=', 'ligneprescriptions.date_etats');
			})
			->whereNull('ligneprescriptions.tmp');
	}
	public function tmp_traitements()
	{
		return $this->hasMany('App\Models\Traitementchronique')
			->join('ligneprescriptions', 'traitementchroniques.id', 'ligneprescriptions.traitementchronique_id')
			->whereNotNull('ligneprescriptions.tmp');
	}
	public function autos()
	{
		return $this->hasMany('App\Models\Automedication')
			->join('ligneprescriptions', 'automedications.id', 'ligneprescriptions.automedication_id')
			->join(DB::raw('(SELECT distinct(max(date_etats)) as topdate
							FROM `ligneprescriptions`  
							group by med_sp_id) as t'), function ($join) {
				$join->on('t.topdate', '=', 'ligneprescriptions.date_etats');
			})
			->whereNull('ligneprescriptions.tmp');
		// ->select(DB::raw(' max(ligneprescriptions.date_etats),ligneprescriptions.*,automedications.*'))
		// ->groupBy('med_sp_id');
	}
	public function autosDesc()
	{
		return $this->hasMany('App\Models\Automedication')
			->join('ligneprescriptions', 'automedications.id', 'ligneprescriptions.automedication_id')
			->join(DB::raw('(SELECT distinct(max(date_etats)) as topdate
							FROM `ligneprescriptions`  
							group by med_sp_id) as t'), function ($join) {
				$join->on('t.topdate', '=', 'ligneprescriptions.date_etats');
			})
			->whereNull('ligneprescriptions.tmp')
			->orderBy('automedications.created_at', 'desc');
		// ->select(DB::raw(' max(ligneprescriptions.date_etats),ligneprescriptions.*,automedications.*'))
		// ->groupBy('med_sp_id');
	}
	public function tmp_autos()
	{
		return $this->hasMany('App\Models\Automedication')
			->join('ligneprescriptions', 'automedications.id', 'ligneprescriptions.automedication_id')
			->whereNotNull('ligneprescriptions.tmp');
	}
	public function villes()
	{
		return $this->belongsTo('App\Models\Wilaya', 'ville')->withDefault();
	}
	public function communes()
	{
		return $this->belongsTo('App\Models\Daira', 'commune');
	}
	public function phytos()
	{
		return $this->hasMany('App\Models\Phytotherapie');
	}
	public function phytosDesc()
	{
		return $this->hasMany('App\Models\Phytotherapie')
			->orderBy('created_at', 'desc');
	}
	public function educations()
	{
		return $this->hasMany('App\Models\Educationtherapeutique');
	}
	public function educationsDesc()
	{
		return $this->hasMany('App\Models\Educationtherapeutique')
			->orderBy('date_et', 'desc');
	}
	public function lastEducations()
	{
		return $this->hasOne('App\Models\Educationtherapeutique')->latest('created_at');
	}
	public function questionnaires()
	{
		return $this->BelongsToMany('App\Models\Questionnaire')->withPivot('reponse', 'date_questionnaire', 'user_id');
	}
	public function questions()
	{
		return $this->hasMany('App\Models\Questionnaire');
	}

	public function prescriptions()
	{
		return $this->hasMany('App\Models\Prescription')->where('etats', 'prescription');
	}
	public function prescriptionsDesc()
	{
		return $this->hasMany('App\Models\Prescription')
			->whereNotIn('etats', ['Exam done', 'Exam in progress'])
			->orderBy('date_prescription', 'desc');
	}
	public function prescriptionsToInject()
	{
		return $this->hasMany('App\Models\Prescription');
	}
	public function prescriptionsRetroInvalide()
	{
		return $this->hasMany('App\Models\Prescription')->where('etats', '!=', 'Exam in progress')->where('etats', '!=', 'Exam done')->orderBy('date_prescription', 'desc');
		// ->where('etats','rétro')->orWhere('etats','invalide')
	}

	public function dedimere()
	{
		return $this->hasOne('App\Models\Bilan')->where('element_id', 60)->latest('updated_at');
	}
	public function fib()
	{
		return $this->hasOne('App\Models\Bilan')->where('element_id', 73)->latest('updated_at');
	}
	public function gb()
	{
		return $this->hasOne('App\Models\Bilan')->where('element_id', 63)->latest('updated_at');
	}
	public function crp()
	{
		return $this->hasOne('App\Models\Bilan')->where('element_id', 66)->latest('updated_at');
	}
	public function pcr()
	{
		return $this->hasOne('App\Models\Bilan')->where('element_id', 61)->latest('updated_at');
	}
	public function tp()
	{
		return $this->hasOne('App\Models\Bilan')->where('element_id', 71)->latest('updated_at');
	}
	public function tdm()
	{
		return $this->hasOne('App\Models\Bilan')->where('type', 'radio')->latest('updated_at');
	}
	public function requestExams()
	{
		return $this->hasMany('App\Models\Prescription')->where('etats', 'Exam in progress')->orderBy('date_prescription', 'desc');
		// ->where('etats','rétro')->orWhere('etats','invalide')
	}
	/**
	 * Les prescriptions à risque Pharmaceutique ou à risque Thérapeutique
	 * des X derniers jours
	 * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
	 * @return Prescription[]
	 */
	public function prescriptionsRisquePharma()
	{
		return $this->hasMany('App\Models\Prescription')
			->where('date_prescription', '>=', Carbon::now()->subDays(30)->toDateString())
			->where('etats', 'risque');
		// ->orWhere('etatAnalyseTherap', 'risqueTherap');
	}
	// public function prescriptionsRisquectt()
	// {
	// 	return $this->hasMany('App\Models\Prescription')->where('etats', 'risque')->Where('etatAnalyseInterne', '');
	// }
	// public function prescriptionsInternectt()
	// {
	// 	return $this->hasMany('App\Models\Prescription')->where('etats', 'rétro')->Where('etatAnalyseInterne', 'risqueInterne');
	// }

	/**
	 * Les prescriptions intervenue par le pharmacien
	 *
	 * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
	 * @return void
	 */
	public function prescriptionsInvalide()
	{
		return $this->hasMany('App\Models\Prescription')->where('etats', 'invalide');
	}

	public function prescriptionsRisqueEducation()
	{
		return $this->hasMany('App\Models\Prescription')->where('etatAnalyseTherap', 'risqueTherap');
	}
	public function prescriptionsEducationFaite()
	{
		return $this->hasMany('App\Models\Prescription')->where('etatAnalyseTherap', 'faite');
	}
	public function ReglesSuiviPatient()
	{
		return $this->hasMany('App\Models\RegleSuivPatient');
	}
	public function ReglesEduPatient()
	{
		return $this->hasMany('App\Models\RegleEduPatient');
	}
	public function prescriptionsRisque()
	{
		return $this->hasMany('App\Models\Prescription')->where('etats', 'risque')->Where('etatAnalyseInterne', 'risqueInterne');
	}

	public function getPaquetsAttribute()
	{
		$pa_jour = ($this->cigarettes / 20) * $this->tabagiste_depuis;

		return $pa_jour;
	}

	public function getVilleAttribute($value)
	{
		return ucfirst($value);
	}

	public function getNomAttribute($value)
	{
		return ucfirst($value);
	}

	public function getPrenomAttribute($value)
	{
		return ucfirst($value);
	}
	public function getNaissanceAttribute()
	{
		return $this->date_naissance;
		return date('d-m-Y', strtotime($this->date_naissance));
	}
	public function getAgeAttribute()
	{
		return intval(date('Y/m/d', strtotime('now'))) - intval(date('Y/m/d', strtotime($this->date_naissance)));
	}
}
// hasone :
// SQL: select * from `users` where `users`.`prescription_id` = 2 and `users`.`prescription_id` is not null limit 1
// has many , the foreign key of the self model is in the parient model , only difference retun many instance than 1 , besides of hasone