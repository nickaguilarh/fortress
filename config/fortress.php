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
    | Fortress role_user Table
    |--------------------------------------------------------------------------
    |
    | This is the role_user table used by Fortress to save assigned roles to the
    | database.
    |
    */
    'role_user_table' => 'role_user',

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

    'permission_user_table' => 'permission_user',

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
    | Fortress Organization Model
    |--------------------------------------------------------------------------
    |
    | This is the Organization model used by Fortress to create correct relations.
    | Update the organization if it is in a different namespace.
    |
    */
    'organization' => 'App\Organization',

    /*
    |--------------------------------------------------------------------------
    | Fortress Organizations Table
    |--------------------------------------------------------------------------
    |
    | This is the organizations table used by Fortress to save organizations to the
    | database.
    |
    */
    'organizations_table' => 'organizations',

    /*
    |--------------------------------------------------------------------------
    | Fortress organization_role Table
    |--------------------------------------------------------------------------
    |
    | This is the organization_role table used by Fortress to save relationship
    | between organizations and roles to the database.
    |
    */
    'organization_user_table' => 'organization_user',

    /*
    |--------------------------------------------------------------------------
    | Fortress organization foreign key
    |--------------------------------------------------------------------------
    |
    | This is the organization foreign key used by Fortress to make a proper
    | relation between organizations and roles
    |
    */
    'organization_foreign_key' => 'organization_id',

    /*
    |--------------------------------------------------------------------------
    | Fortress organization_user_role Table
    |--------------------------------------------------------------------------
    |
    | This is the organization_role table used by Fortress to save relationship
    | between organizations' users and roles to the database.
    |
    */
    'organization_user_role_table' => 'organization_user_role',

    /*
    |--------------------------------------------------------------------------
    | Fortress organization_user_permission Table
    |--------------------------------------------------------------------------
    |
    | This is the organization_permission table used by Fortress to save relationship
    | between organizations' users and permissions to the database.
    |
    */
    'organization_user_permission_table' => 'organization_user_permission',
    //TODO: Add documentation
    'organization_user_foreign_key' => 'organization_user_id',



];
