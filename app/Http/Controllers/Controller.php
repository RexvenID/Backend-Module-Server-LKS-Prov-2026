<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

abstract class Controller
{
    public function ok($msg = 'OK', $data = null, $code = 200)
    {
        $res = ['status' => 'success', 'message' => $msg];
        if ($data !== null) $res['data'] = $data;
        return response()->json($res, $code);
    }

    public function fail($msg, $code = 400)
    {
        return response()->json(['status' => 'error', 'message' => $msg], $code);
    }

    public function own(Model $m, $key = 'user_id')
    {
        if ($m->{$key} !== auth()->id()) abort(403);
        return $m;
    }

    public function pick(Model $m, array $fields, array $extra = [])
    {
        return [...$m->only($fields), ...$extra];
    }
}
