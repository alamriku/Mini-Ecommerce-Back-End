<?php


namespace App\Http\Controllers\Interfaces;


interface Collections
{
    public function products($limit): object;
}
