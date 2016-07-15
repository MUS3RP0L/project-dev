<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Muserpol\Helper\Util;

class Spouse extends Model
{
    protected $table = 'spouses';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        
        'user_id',
        'affiliate_id',
        'identity_card',
        'last_name',
        'mothers_last_name',
        'first_name',
        'second_name',
        'birth_date',
        'date_death',
        'reason_death'      
    ];

    protected $guarded = ['id'];

    public function affiliate()
    {
        return $this->belongsTo('Muserpol\Affiliate');
    }

    public function scopeAffiliateidIs($query, $id)
    {
        return $query->where('affiliate_id', $id);
    }

    public function getShortBirthDate()
    {   
        return Util::getDateShort($this->birth_date);
    }

    public function getShortDateDeath()
    {   
        return Util::getDateShort($this->date_death);
    }

    public function getEditBirthDate()
    {
        return Util::getDateEdit($this->birth_date);
    }
    public function getEditDateDeath()
    {   
        return Util::getDateEdit($this->birth_date);
    }













    

    

  

    public function getFullNametoPrint()
    {
        return $this->nom . ' ' . $this->nom2 . ' ' . $this->pat. ' ' . $this->mat;
    }
    
    public function getFullDateNactoPrint()
    {   
        if ($this->fech_nac) {
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            return date("d", strtotime($this->fech_nac))." de ".$meses[date("m", strtotime($this->fech_nac))-1]. " de ".date("Y", strtotime($this->fech_nac));
        }
    }
    public function getFull_fech_decetoPrint()
    {   
        if ($this->fech_dece) {
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            return date("d", strtotime($this->fech_dece))." ".$meses[date("n", strtotime($this->fech_dece))-1]. " ".date("Y", strtotime($this->fech_dece)); 
        }
    }

    public function getFullName()
    {
        return $this->pat . ' ' . $this->mat. ' ' . $this->nom. ' ' .$this->nom2;
    }
}

Spouse::created(function($spouse)
{
    Activity::createdSpouse($spouse);
});

Spouse::updating(function($spouse)
{
    Activity::updateSpouse($spouse);

});