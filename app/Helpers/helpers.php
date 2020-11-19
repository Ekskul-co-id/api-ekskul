<?php

use App\Models\Audit;

function Auditrails($id,$message){
    Audit::create([
        'id_user' => $id,
        'description' => $message,
    ]);
}