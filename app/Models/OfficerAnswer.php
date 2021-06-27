<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class OfficerAnswer extends Model
{
    protected $guarded = [];
    

    public function instrument(){
        return $this->hasOneThrough(Instrument::class, Question::class, 'id', 'id','question_id','instrument_id');
    }

    public function offeredAnswer(){
        return $this->belongsTo(OfferedAnswer::class);
    }

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function getScoreAttribute(){
        return $this->offeredAnswer()->exists() ? $this->offeredAnswer->score : 0;
    }

}