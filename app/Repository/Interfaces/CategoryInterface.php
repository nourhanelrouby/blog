<?php

namespace App\Repository\Interfaces;

interface CategoryInterface
{

    public function store($request);

    public function update($request, $category);

    public function destroy($category);

    public function restore($category);

    public function delete($category);

    public function ajax($request);
    public function archiveAjax($request);
    public function archive($request);
}
