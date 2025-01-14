<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
  protected $fillable = ['name', 'display_name', 'group', 'guard_name'];
}
