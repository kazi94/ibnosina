<?php

namespace App\Repositories;

use App\Models\Appointement;
use DB;
use Auth;

class AppointementRepository 
{
    /**
     * Get's a post by it's ID
     *
     * @param int
     * @return collection
     */
    public function get($appointement_id)
    {
        return Appointement::find($appointement_id);
    }

    /**
     * get appointements of today
     *
     * @return collection
     * @author __KaziWhite**__SALAF4_WebDev**
     **/
    public function getDailyAppointements()
    {
        return Appointement::
        with('patient')
        ->whereDate('start_date','=' ,date('y-m-d'))
        ->where('start_date','>=',now())
        ->where('created_by','=' ,Auth::id())
        ->select(DB::raw("  if (
                            sec_to_time(start_date-now()) <3600 and sec_to_time(start_date-now()) >=0,
                            TIME_FORMAT(sec_to_time(start_date-now()),'%imin'),
                            TIME_FORMAT(sec_to_time(start_date-now()),'%Hh %imin')) 
                            AS 'in' , appointements.* ")) // sec to time permet de convertir les seconds en heure minute et second
        ->get();
    }
    /**
     * Get's all posts.
     *
     * @return mixed
     */
    public function all()
    {
        return Appointement::all();
    }

    /**
     * Deletes a post.
     *
     * @param int
     */
    public function delete($appointement_id)
    {
        Appointement::destroy($appointement_id);
    }

    /**
     * Updates a post.
     *
     * @param int
     * @param array
     */
    public function update($appointement_id, array $appointement_data)
    {
        Appointement::find($appointement_id)->update($appointement_data);
    }
}

 ?>