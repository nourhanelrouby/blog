<?php

namespace App\Repository;

use App\Models\User;
use App\Repository\Interfaces\UserInterface;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserRepository implements UserInterface
{

    public function ajax($request)
    {
        $query = User::query();

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $viewText = __('main-words.view');
                $editText   = __('main-words.edit');
                $deleteText = __('main-words.delete');

                $viewBtn = '<a href="' . route('dashboard.users.show', $row->id) . '" class="btn btn-info btn-sm me-1">' . $viewText . '</a>';
                $editBtn = '<a href="' . route('dashboard.users.edit', $row->id) . '" class="btn btn-primary btn-sm me-1">' . $editText . '</a>';
                $deleteBtn = '<button type="button" class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '">' . $deleteText . '</button>';

                return $viewBtn . $editBtn . $deleteBtn;
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->diffForHumans();
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function archiveAjax( $request)
    {
        $query = User::onlyTrashed()->select('*', 'deleted_at as status');
        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $restoreText = __('main-words.restore');
                $deleteText = __('main-words.delete');
                $restoreBtn = '<button type="button" class="btn btn-primary btn-sm restore-btn" data-id="' . $row->id . '">' . $restoreText . '</button>';
                $deleteBtn = '<button type="button" class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '">' . $deleteText . '</button>';

                return $restoreBtn . $deleteBtn;
            })
            ->addColumn('status', function ($row) {
                $archiveText = __('main-words.archive');
                if ($row->status != null)
                    return '<span class="badge bg-danger">' . $archiveText . '</span>';
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function store($request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        return User::create($validated);
    }

    public function update($request, $user)
    {
        $validated = $request->validated();
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        return $user;
    }


    public function destroy($user)
    {
        $user->delete();
        return true;
    }
    public function restore($user)
    {
        User::withTrashed()->find($user)->restore();
        return true;
    }
    public function delete($user)
    {
        $user = User::withTrashed()->find($user);
        $user->forceDelete();
        return true;
    }
}
