<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Http\Resources\User\UserListResource;
use App\Models\User;
use App\Repository\Interfaces\UserInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    public function index(Request $request)
    {

        $per_page = min($request->per_page, 10);
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('role', $search);
        }

        $users = $query->paginate($per_page);

        if ($users->isEmpty()) {
            return successResponse([], 'No Data Found!');
        }

        $users = UserListResource::collection($users);

        return paginatedResponse($users);
    }


    public function store(UserStoreRequest $request)
    {

        $user = $this->userInterface->store($request);

        $user = new UserListResource($user);

        return successResponse($user, 'User Stored successfully!');
    }


    public function show(User $user)
    {
        $user = new UserListResource($user);

        return successResponse($user, 'User retrived successfully!');
    }


    public function update(UserUpdateRequest $request, User $user)
    {
        $user = $this->userInterface->update($request, $user);
        $user = new UserListResource($user);

        return successResponse($user, 'User Updated Successfully!');
    }


    public function destroy(User $user)
    {
        $this->userInterface->destroy($user);
        return successResponse([], 'User Soft Deleted Successfully!');
    }

    public function delete($user)
    {
        $value = $this->userInterface->delete($user);
        if ($value == false) {
            return errorResponse([], 'User not found!');
        }
        return successResponse([], 'User Forced Deleted Successfully!');
    }
    public function restore($user)
    {
        $value = $this->userInterface->restore($user);
        if ($value == false) {
            return errorResponse([], 'User not found!');
        }
        return successResponse([], 'User Restored Successfully!');
    }

    public function archive(Request $request)
    {
        $value = $this->userInterface->archive($request);
        if ($value == false) {
            return errorResponse([], 'Archive Is Empty!');
        }
        $users = UserListResource::collection($value);
        return paginatedResponse($users);
    }
}
