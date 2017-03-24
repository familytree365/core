<?php

namespace LaravelEnso\Core\App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\App\DataTable\PermissionsGroupsTableStructure;
use LaravelEnso\Core\App\Http\Requests\ValidatePermissionsGroupRequest;
use LaravelEnso\Core\App\Models\PermissionsGroup;
use LaravelEnso\DataTable\App\Traits\DataTable;

class PermissionsGroupsController extends Controller
{
    use DataTable;
    protected $tableStructureClass = PermissionsGroupsTableStructure::class;

    public static function getTableQuery()
    {
        $query = PermissionsGroup::select(\DB::raw('permissions_groups.id as DT_RowId, permissions_groups.name, permissions_groups.description, permissions_groups.created_at, permissions_groups.updated_at'));

        return $query;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('laravel-enso/core::pages.system.permissionsGroups.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('laravel-enso/core::pages.system.permissionsGroups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ValidatePermissionsGroupRequest $request
     * @param PermissionsGroup                $permissionsGroup
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ValidatePermissionsGroupRequest $request, PermissionsGroup $permissionsGroup)
    {
        $permissionsGroup->fill($request->all());
        $permissionsGroup->save();

        flash()->success(__('Permission created'));

        return redirect('system/permissionsGroups/'.$permissionsGroup->id.'/edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(PermissionsGroup $permissionsGroup)
    {
        return view('laravel-enso/core::pages.system.permissionsGroups.edit', compact('permissionsGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ValidatePermissionsGroupRequest $request, PermissionsGroup $permissionsGroup)
    {
        $permissionsGroup->fill($request->all());
        $permissionsGroup->save();

        flash()->success(__('The Changes have been saved!'));

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(PermissionsGroup $permissionsGroup)
    {
        if ($permissionsGroup->permissions->count()) {
            return [
                'level'   => 'error',
                'message' => __('Group Has Permissions'),
            ];
        }

        return [
            'level'   => 'success',
            'message' => __('Operation was successfull'),
        ];
    }
}
