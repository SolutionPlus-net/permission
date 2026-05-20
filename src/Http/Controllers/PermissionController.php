<?php

namespace Otas\Permission\Http\Controllers;

use Otas\Permission\Models\Permission;
use Otas\Permission\Http\Resources\PermissionResource;
use Otas\Permission\Http\Requests\PermissionUpdateRequest;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(\Illuminate\Routing\Middleware\SubstituteBindings::class);
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $paginationLength = pagination_length(Permission::class);
        $permissions = Permission::paginate($paginationLength);
        return PermissionResource::collection($permissions);
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Permission $permission)
    {
        return response([
            'permission' => new PermissionResource($permission),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(PermissionUpdateRequest $request, Permission $permission)
    {
        $permission = $request->updatePermission();
        return response([
            'message' => __('otas/permission/permissions.update'),
            'permission' => new PermissionResource($permission),
        ]);
    }
}
