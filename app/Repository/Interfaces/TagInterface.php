<?php

namespace App\Repository\Interfaces;

interface TagInterface
{
    public function store($request);


    public function update($request, $tag);

    public function destroy($tag);

    public function ajax($request);
}
