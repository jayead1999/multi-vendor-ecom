<?php

namespace App\Services;

class AlertService
{
    public static function success($message)
    {
        session()->flash('success', $message);
    }

    public static function error($message)
    {
        session()->flash('error', $message);
    }

    public function warning($message)
    {
        session()->flash('warning', $message);
    }

    public function info($message)
    {
        session()->flash('info', $message);
    }

    // delete , create , update ,

    public static function delete($message)
    {
        session()->flash('success', $message);
    }

    public static function create($message)
    {
        session()->flash('success', $message);
    }

    public static function update($message)
    {
        session()->flash('success', $message);
    }
}
