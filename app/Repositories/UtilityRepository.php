<?php

namespace App\Repositories;

use App\Models\Operation_chirugicale;
use App\Models\Pathologie;
use App\Models\Grossesse;
use App\Models\Allergie;
use Cache;
use DB;

class UtilityRepository
{
    /**
     * get Pathologies
     *
     * @return Pathologies
     * @author 
     **/

    public function getPathologies()
    {
        $seconds = 604800; // One week
        return Cache::remember('pathologies', $seconds, function () {
            return Pathologie::all();
        });
    }
    /**
     * get Dairas
     *
     * @return Dairas
     * @author 
     **/

    public function getDairas($id)
    {
        $seconds = 604800; // One week
        return Cache::remember('dairas' . $id, $seconds, function () use ($id) {
            return DB::table('dairas')->where('wilaya_id', $id)->select('id', 'name')->get();
        });
    }
    /**
     * get Dairas
     *
     * @return Dairas
     * @author 
     **/

    public function getDairaPatient($daira_id)
    {
        return DB::table('dairas')->where('id', $daira_id)->select('id', 'name')->get();
    }
    /**
     * get Wilayas
     *
     * @return Wilayas
     * @author 
     **/

    public function getWilayas()
    {
        $seconds = 604800; // One week
        return Cache::remember('wilayas', $seconds, function () {
            return DB::table('wilayas')->select('id', 'name')->get();
        });
    }
    /**
     * get Wilayas
     *
     * @return Wilayas
     * @author 
     **/

    public function getDairasTlemcen()
    {
        $seconds = 604800; // One week
        return Cache::remember('dairasTlemcen', $seconds, function () {
            return DB::table('dairas')->where('wilaya_id', '13')->select('id', 'name')->get();
        });
    }
    /**
     * get Allergies
     *
     * @return Allergies
     * @author 
     **/
    public function getAllergies()
    {
        $seconds = 604800; // One week
        return Cache::remember('allergies', $seconds, function () {
            return Allergie::all();
        });
    }

    /**
     * get Operations chirurgicale
     *
     *
     * @return Operation
     **/
    public function getOperations()
    {
        return Operation_chirugicale::all();
    }

    /**
     * get  wekks of Grossesse
     * 
     * @return Grossesse
     **/
    public function getGrossesse()
    {
        //$seconds = 604800; // One week
        //return Cache::remember('grossesses', $seconds, function () {
        return Grossesse::all();
        //});
    }
}
