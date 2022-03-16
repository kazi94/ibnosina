<?php

namespace App\ModelsChimio;

use Illuminate\Database\Eloquent\Model;

class Cosac_compo_subact extends Model
{
    protected $primaryKey = ['COSAC_SAC_CODE_FK_PK', 'COSAC_SP_CODE_FK_PK', 'COSAC_COMPO_NUM_PK'];
    public $incrementing = false;
    protected $table = 'cosac_compo_subact';
    
    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery(Builder $query)
    {
        $keys = $this->getKeyName();
        if(!is_array($keys)){
            return parent::setKeysForSaveQuery($query);
        }

        foreach($keys as $keyName){
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @param mixed $keyName
     * @return mixed
     */
    protected function getKeyForSaveQuery($keyName = null)
    {
        if(is_null($keyName)){
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }

    public function medic_seq()
    {
        return $this->belongsToMany('App\ModelsChimio\Medicament_sequencetype');
    }
}
