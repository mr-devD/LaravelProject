<style>
    .task-table {
        width: 100%;
        border-collapse: collapse;
    }

    .task-table th,
    .task-table td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .task-table td.name {
        text-decoration: underline;
        color: #2563eb;
    }

    .task-table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .task-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
</style>


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Zadaci') }}
        </h2>
    </x-slot>

    <table class="task-table" id="task_list">
        <thead>
        <tr>
            <th>Ime</th>
            <th>Korisnicko ime</th>
            <th>E-mail</th>
            <th>Tip korisnika</th>
            <th>Telefon</th>
            <th>Datum rodjenja</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td class="name"><a href="user/{{$user->id}}">{{$user->name}}</a></td>
                <td>{{$user->username}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->type->name}}</td>
                <td>{{$user->phone}}</td>
                <td>{{$user->birthdate}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</x-app-layout>

<script>
    $(document).ready(function() {
        $('#task_list').DataTable();
    } );
</script>








