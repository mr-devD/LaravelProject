<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dodaj grupu zadatka') }}
        </h2>
    </x-slot>

    <form class="task-form" action="add-group" method="post">
        @csrf

        <div class="form-group">
            <label for="group_name">Naziv grupe:</label>
            <input type="text" name="group_name" id="group_name" placeholder="Naziv" required autofocus>
        </div>

        <div class="form-group">
            <label for="group_desc">Opis grupe:</label>
            <input type="text" name="group_desc" id="group_desc" placeholder="Opis" required>
        </div>

        <input type="submit" value="Sacuvaj" class="submit-btn">
    </form>

    <br>
    <hr>
    <br>


    <table class="task-table">
        <thead>
        <tr>
            <th>Ime grupe</th>
            <th>Opis grupe</th>
            <th>Akcije</th>
        </tr>
        </thead>
        <tbody>
        @foreach($groups as $group)
            <tr>
                <td>{{$group->name}}</td>
                <td>{{$group->description}}</td>
                <td>
                    <div class="action-buttons">
                        <div class="edit-btn">
                            <form action="edit-group/{{$group->id}}">
                                @csrf
                                <button type="submit">Izmeni</button>
                            </form>
                        </div>
                        <div class="delete-btn">
                            <form action="delete-group" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$group->id}}">
                                <button type="submit">Obrisi</button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


</x-app-layout>

<style>
    .task-form {
        max-width: 400px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-group input[type="text"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .submit-btn {
        color: #2563eb;
        border: solid 1px;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
    }

    .submit-btn:hover {
        background-color: #204dbf;
    }

    .task-table {
        width: 90%;
        max-width: 1000px;
        margin: 0 auto;
    }

    .task-table th,
    .task-table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        font-size: 16px;
    }

    .task-table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .task-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .edit-btn button {
        background-color: #ffc107;
        color: #fff;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
    }

    .delete-btn button {
        background-color: #dc3545;
        color: #fff;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
    }

    .edit-btn button:hover,
    .delete-btn button:hover {
        opacity: 0.8;
    }

    .action-buttons {
        display: flex;
        align-items: center;
    }

    .action-buttons > div {
        margin-right: 5px;
    }
</style>
