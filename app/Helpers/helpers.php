<?php

function eventRespons($status,$code,$message,$data = null){
    return response()->json([
        'status' => (bool) $status,
        'message' => $message,
        'data' => $data,
    ],$code);
}