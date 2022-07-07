@extends('vendor.rolevue.layouts.app')
@section('content')
    <section name="header" class="mt-4">
        <h2 class="font-semibold text-xl text-center text-gray-800 leading-tight">
            {{ __('User Roles') }}
        </h2>
    </section>
    <div id="acl_wrapper" data-context="roles" class="table-wrapper">
        <section id="rolevue">
            <user-roles-all></user-roles-all>
        </section>
    </div>
@endsection
