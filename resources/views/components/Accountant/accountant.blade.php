<x-layouts.dashboard>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        .first-row {
            background-color: gold;
        }
    </style>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>username</th>
                <th>role</th>
                <th>salary</th>
                <th>points</th>
                <th>amount</th>
                <th>salary pay</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr @if ($loop->first)
                style="background-color: gold"
                @endif>
                <td>{{ $user->username }}</td>
                <td>{{ $user->role->name }}</td>
                <td>{{ $user->role->salary }}</td>
                <td>{{ $user->points }}</td>
                <td>{{ $user->role->salary + ($user->points * 100) }}</td>
                <td>
                    <form action="{{ route('users.pay', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success">Pay</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-layouts.dashboard>