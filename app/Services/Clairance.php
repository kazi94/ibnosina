<?php

namespace App\Services;

class Clairance
{
    /**
     * Undocumented function
     *
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     */
    public function __construct()
    {
    }
    /**
     * Calcule de la clairance
     *
     * @param String $sexe M/F
     * @param Integer $poids 
     * @param Integer $age l'age du patient en années
     * @param Float $creat créatinine du patient en µmol/L
     * @param Integer|NULL $enceinte Si la femme est enceinte
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return void
     */
    public function calcul_clr($taille, $sexe, $poids, $age, $creat, $enceinte)
    {
        if ($age > 65 || $this->masseCorporel($poids, $taille) > 30 || $enceinte)
            return $this->formuleMDRD($sexe, $age, $creat);

        if ($age <= 21)
            return $this->formuleSchwartz($sexe, $taille, $age, $creat);

        return $this->formuleCockcroftAndGault($sexe, $poids, $age, $creat);
    }

    /**
     * Calcule de la clairance Formule MDRD 
     * {\displaystyle Cl\ cr=186.3*{\text{(creat*0.0113)}}^{-1.154}*{\text{age}}^{-0.203}*(*0.742\ {\text{si femme}})\ ml/min/{1.73m^{2}}}
     * @param [type] $sexe 
     * @param [type] $age âge en années.
     * @param [type] $creat créatininémie en µmol/L
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Float clairance estimation de la clairance de la créatinine en mL/min/1.73m2 ;
     */
    public function formuleMDRD($sexe,  $age, $creat)
    {
        if ($sexe == "F")
            return 186 * pow(($creat * 0.0113), -1.154) * pow($age, -0.203) * 0.742;
        else
            return 186 * pow(($creat * 0.0113), -1.154) * pow($age, -0.203);
    }
    /**
     * Calcule de la clairance Formule Shwartz pour enfants
     *
     * @param [type] $sexe
     * @param [type] $taille taille du patient en cm
     * @param [type] $age
     * @param [type] $creat
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Float clairance estimation de la clairance de la créatinine en mL/min/1.73m2 ;
     */
    private function formuleSchwartz($sexe, $taille, $age, $creat)
    {
        if ($age == 0) $k = 29; //* nouveau-né prématuré
        else if ($age <= 1) $k = 40;
        else if ($age >= 2 || $age <= 12) $k = 49; //* enfants de 2 à 12 ans
        else if ($sexe == "F" && ($age >= 13 || $age <= 21)) $k = 49; //* filles de 13 à 21 ans
        else if ($sexe == "M" && ($age >= 13 || $age <= 21)) $k = 62; //* garçons de 13 à 21 ans

        return  $k * $taille / $creat;
    }
    /** 
     * Calcule Clairance formule  Cockcroft And Gault
     *
     * @param [type] $sexe
     * @param [type] $poids
     * @param [type] $age
     * @param [type] $creat
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Float clairance estimation de la clairance de la créatinine
     */
    private function formuleCockcroftAndGault($sexe, $poids, $age, $creat)
    {
        if ($sexe == "M")
            return ((140 - $age) / $creat) * $poids * 1.23;
        else
            return ((140 - $age) / $creat) * $poids * 1.04;
    }
    /**
     * Caclule de la masse Corporel
     *
     * @param [type] $poids
     * @author Kazi Aouel Sid Ahmed <kazi.sidou.94@gmail.com>
     * @return Integer massCorporel
     */
    private function masseCorporel($poids, $taille)
    {
        return $poids / pow($taille * 0.01, 2);
    }

    public function getMethod($age)
    {
        if ($age <= 21)
            return [
                'nom' => "Shwartz",
                'url' => "http://medicalcul.free.fr/schwartz.html#:~:text=La%20formule%20de%20Schwartz%20permet,5%2C8%20mL%2Fmin."
            ];
        else if ($age <= 65)
            return [
                'nom' => "Cockroft & Gault",
                'url' => "https://fr.wikipedia.org/wiki/Formule_de_Cockcroft_%26_Gault#:~:text=La%20formule%20de%20Cockcroft%20%26%20Gault,et%20Henry%20Gault%20en%201976."
            ];
        else
            return [
                'nom' => "MDRD",
                'url' => "https://fr.wikipedia.org/wiki/Formule_MDRD"
            ];
    }

    public function convertToMicroMol($create , $unit){
        if ($unit == "mg/dl") {
            return $create * 88.4;
        } else {
            return $create;
        }
    }
}
