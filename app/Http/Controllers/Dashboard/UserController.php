<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Models\User;
use App\Repository\Interfaces\UserInterface;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
{
    protected $path; // For Blade pass
    protected $userInterface; // For Interfaces ( Contracts )

    public function __construct(UserInterface $userInterface)
    {
        $this->path = 'dashboard.users.';
        $this->userInterface = $userInterface;
    }

    public function index(Request $request)
    {
        $title = 'All Users';
        return view($this->path . 'index', compact('title'));
    }

    public function ajax(Request $request)
    {
        return $this->userInterface->ajax($request);
    }


    public function create()
    {
        $title = 'Create User';
        return view($this->path . 'create', compact('title'));
    }


    public function store(UserStoreRequest $request)
    {
        $this->userInterface->store($request);
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User Created successfully!'
            ]);
        }

        return redirect()
            ->route('dashboard.users.index')
            ->with('success', 'User Created successfully!');
    }


    public function show(User $user)
    {
        $title = 'Disaply User';
        if ($user == null) {
            return response()->json([
                'error',
                true,
                'messgae' => 'User Not Found!'
            ]);
        } else {
            return view($this->path . 'show', compact('user', 'title'));
        }
    }


    public function edit(User $user)
    {
        $title = 'Edit User';
        return view($this->path . 'edit', compact('title', 'user'));
    }


    public function update(UserUpdateRequest $request, User $user)
    {
        $this->userInterface->update($request, $user);
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User Updated Sucessfully'
            ]);
        }
        return redirect()
            ->route('dashboard.users.index')->with('success', 'User Updated Sucessfully');
    }

    public function destroy(Request $request, User $user)
    {
        $this->userInterface->destroy($user);
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User Deleted Sucessfully'
            ]);
        }

        return redirect()
            ->route('dashboard.users.index')->with('success', 'User Delted Successfully!');
    }

    public function archive()
    {
        $title = 'Archive';
        return view($this->path . 'archive', compact('title'));
    }

    public function archiveAjax(Request $request)
    {
        return $this->userInterface->archiveAjax($request);
    }

    public function restore(Request $request, $user)
    {
        $this->userInterface->restore($user);
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Restored Successfully'
            ]);
        }
        return redirect()->route('dashboard.users.archive')->with('success', 'User Restored Successfully');
    }
    public function delete( Request $request, $user)
    {
        $this->userInterface->delete($user);
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Restored Deleted Successfully'
            ]);
        }
        return redirect()->route('dashboard.users.archive')->with('success', 'User Restored Successfully');
    }
}
