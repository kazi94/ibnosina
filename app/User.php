<?php

namespace App;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PhpParser\Node\Expr\FuncCall;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    //protected $visible = ['first_name', 'last_name'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'prenom', 'grade', 'specialite', 'date_naissance', 'is_admin', 'role_id'
    ];
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    // protected $attributes = [
    //     'delayed' => false,
    // ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //'is_admin' => 'boolean',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['since_date'];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    // protected $appends = ['admin'];
    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    // public function getAdminAttribute()
    // {
    //     return $this->attributes['is_admin'] == 'on'; 
    // }

    /**
     * Prescriptions type of the same service as the authenticated user
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return PrescriptionType
     */
    public function prescriptionsType()
    {
        return $this->hasMany('App\Models\Admin\PrescriptionType', 'service', 'service')
            ->where('type', 'service');
    }
    /**
     * Examens type of the same service as the authenticated user
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return PrescriptionType
     */
    public function examensType()
    {
        return $this->hasMany('App\Models\Admin\PrescriptionType', 'service', 'service')
            ->where('type', 'examen');
    }
    /**
     * associate users to roles
     *
     * @return Role
     */
    public function role()
    {

        return $this->BelongsTo('App\Models\Role');
    }

    /**
     * User Has many interventions
     *
     * @return interventions instance
     */
    public function interventionsUser()
    {
        return $this->hasMany('App\Models\Intervention', 'created_by');
    }
    /**
     * User Has many messages
     *
     * @return interventions instance
     */
    public function messages()
    {
        return $this->hasMany('App\Models\Message', 'user');
    }

    /**
     * Return Last Messages
     *
     * @return void
     * @author 
     **/
    public function messageMax()
    {
        return $this->hasOne('App\Models\Message', 'user')->whereIn('time', function ($query) {
            return $query->selectRaw("Max(time)")->from('messages')->groupBy('to_user_id');
        });
    }
    /**
     * User has done many education thérapteutique to many patients
     *
     * @return Collection Patient Instance
     */
    public function educationUser()
    {
        return $this->hasMany('App\Models\Patient');
    }

    /**
     * les demande d'examens à faire
     *
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function requestsByPatient()
    {
        return $this->hasMany('App\Models\Prescription', 'created_by')
            ->where('etats', 'Exam in progress');
    }

    /**
     * Les administrations faite par l'utilisateur
     */
    public function injections()
    {
        return $this->hasMany('App\Models\Injection', 'injected_by');
    }

    public function getSinceDateAttribute()
    {
        $time = strtotime($this->created_at);

        return $this->humanTiming($time);
    }

    private function humanTiming($time)
    {

        $time = time() - $time; // to get the time since that moment
        $time = ($time < 1) ? 1 : $time;
        $tokens = array(
            31536000 => 'an',
            2592000 => 'moi',
            604800 => 'semaine',
            86400 => 'jour',
            3600 => 'heure',
            60 => 'minute',
            1 => 'seconde'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
        }
    }
}
