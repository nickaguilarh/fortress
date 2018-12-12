<?php

/**
 * This file is part of Fortress,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package NickAguilarH\Fortress
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Fortress Role Model
    |--------------------------------------------------------------------------
    |
    | This is the Role model used by Fortress to create correct relations.  Update
    | the role if it is in a different namespace.
    |
    */
    'role' => 'App\Role',

    /*
    |--------------------------------------------------------------------------
    | Fortress Roles Table
    |--------------------------------------------------------------------------
    |
    | This is the roles table used by Fortress to save roles to the database.
    |
    */
    'roles_table' => 'roles',

    /*
    |--------------------------------------------------------------------------
    | Fortress role foreign key
    |--------------------------------------------------------------------------
    |
    | This is the role foreign key used by Fortress to make a proper
    | relation between permissions and roles & roles and users
    |
    */
    'role_foreign_key' => 'role_id',

    /*
    |--------------------------------------------------------------------------
    | Application User Model
    |--------------------------------------------------------------------------
    |
    | This is the User model used by Fortress to create correct relations.
    | Update the User if it is in a different namespace.
    |
    */
    'user' => 'App\User',

    /*
    |--------------------------------------------------------------------------
    | Application Users Table
    |--------------------------------------------------------------------------
    |
    | This is the users table used by the application to save users to the
    | database.
    |
    */
    'users_table' => 'users',

    /*
    |--------------------------------------------------------------------------
    | Fortress user foreign key
    |--------------------------------------------------------------------------
    |
    | This is the user foreign key used by Fortress to make a proper
    | relation between roles and users
    |
    */
    'user_foreign_key' => 'user_id',

    /*
    |--------------------------------------------------------------------------
    | Fortress Permission Model
    |--------------------------------------------------------------------------
    |
    | This is the Permission model used by Fortress to create correct relations.
    | Update the permission if it is in a different namespace.
    |
    */
    'permission' => 'App\Permission',

    /*
    |--------------------------------------------------------------------------
    | Fortress Permissions Table
    |--------------------------------------------------------------------------
    |
    | This is the permissions table used by Fortress to save permissions to the
    | database.
    |
    */
    'permissions_table' => 'permissions',

    /*
    |--------------------------------------------------------------------------
    | Fortress permission_role Table
    |--------------------------------------------------------------------------
    |
    | This is the permission_role table used by Fortress to save relationship
    | between permissions and roles to the database.
    |
    */
    'permission_role_table' => 'permission_role',

    /*
    |--------------------------------------------------------------------------
    | Fortress permission foreign key
    |--------------------------------------------------------------------------
    |
    | This is the permission foreign key used by Fortress to make a proper
    | relation between permissions and roles
    |
    */
    'permission_foreign_key' => 'permission_id',

    /*
    |--------------------------------------------------------------------------
    | Fortress Permissions Table
    |--------------------------------------------------------------------------
    |
    | This is the permissions table used by Fortress to save permissions to the
    | database.
    |
    */
    'persona_table' => 'persona',


    /*
    |--------------------------------------------------------------------------
    | Fortress persona_role Table
    |--------------------------------------------------------------------------
    |
    | This is the organization_role table used by Fortress to save relationship
    | between organizations' users and roles to the database.
    |
    */
    'persona_role_table' => 'persona_role',

    /*
    |--------------------------------------------------------------------------
    | Fortress persona_permission Table
    |--------------------------------------------------------------------------
    |
    | This is the organization_permission table used by Fortress to save relationship
    | between organizations' users and permissions to the database.
    |
    */
    'persona_permission_table' => 'persona_permission',

    /*
    |--------------------------------------------------------------------------
    | Fortress organization user foreign key
    |--------------------------------------------------------------------------
    |
    | This is the organization user foreign key used by Fortress to make a proper
    | relation between organization users and roles
    |
    */
    'persona_foreign_key' => 'persona_id',

];
