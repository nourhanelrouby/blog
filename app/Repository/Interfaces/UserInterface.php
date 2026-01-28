<?php

namespace App\Repository\Interfaces;

interface UserInterface
{

    public function store($request);

    public function update($request, $user);

    public function destroy($user);

    public function restore($user);

    public function delete($user);
    public function ajax( $request);
    public function archiveAjax( $request);
}
