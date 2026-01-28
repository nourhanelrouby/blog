<?php

namespace App\Repository\Interfaces;

interface PostInterface
{

    public function ajax($request);

    public function store($request);

     public function update($request, $post);

    public function destroy( $post);
}
