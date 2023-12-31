@php
$page ??= "dashboard";
@endphp

{{-- Control Panel --}}
<x-side-bar-element :page="$page" prefix="dashboard" title="Control Panel" icon="dashboard" route="dashboard" />
{{-- Profile --}}
<x-side-bar-element :page="$page" prefix="profile" title="User Profile" icon="person" route="profile.edit" />
@if(Auth::user()->role->name == 'admin')
{{-- Users Management --}}
<x-side-bar-group :page="$page" prefix="users" title="Users Management" icon="group">
    <x-side-bar-element :page="$page" prefix="users.add" title="Add User" icon="add" route="users.create" />
    <x-side-bar-element :page="$page" prefix="users.view" title="View Users" icon="view_list" route="users.index" />
</x-side-bar-group>
{{-- task management --}}
<x-side-bar-group :page="$page" title="Task Managment" prefix="task.create" icon="group">
    <x-side-bar-element :page="$page" prefix="task.create" title="create new task" icon="add" route="task.create" />
    <x-side-bar-element :page="$page" prefix="view" title="view tasks" icon="group" route="task.view" />
    {{-- <x-side-bar-element :page="$page" prefix = "rejected.task" title="rejected task" icon="add" route="task.rejected" /> --}}

</x-side-bar-group>
@endif
@if (auth()->user()->role->name == 'employee' || auth()->user()->role ->name == 'accountant')
<x-side-bar-group :page="$page" title="Tasks" prefix="" icon="group">
    <x-side-bar-element :page="$page" prefix="" title="view tasks" icon="view_list" route="user.tasks" />
</x-side-bar-group>
@endif
@if (auth()->user()->role->name == 'accountant')
<x-side-bar-group :page="$page" prefix="users" title="Employee Salarys" icon="group">
    <x-side-bar-element :page="$page" prefix="" title="View Salary" icon="view_list" route="users.salary" />

</x-side-bar-group>
@endif
{{-- Logout --}}
<x-side-bar-element :page="$page" prefix="logout" title="Logout" icon="logout"
    onclick="event.preventDefault();document.getElementById('logout-form').submit();" />
<form id="logout-form" action="{{ route('logout') }}" method="POST">
    @csrf
</form>