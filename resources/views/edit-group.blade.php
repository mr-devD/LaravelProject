<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{'Izmena grupe - ' . $group->name}}
        </h2>
    </x-slot>


    <form action="{{route('group.edit')}}" method="post">
        @csrf

        <label for="name">Ime grupe:</label><br>
        <input type="text" name="name" id="name" value="{{$group->name}}"><br>

        <label for="description">Opis grupe</label><br>
        <input type="text" name="description" id="description" value="{{$group->description}}"><br>

        <input type="hidden" name="id" value="{{$group->id}}">
        <button type="submit">Sacuvaj</button>
    </form>
</x-app-layout>
<style>
    form {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f2f2f2;
        border-radius: 8px;
    }

    form label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
    }

    form input[type="text"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 15px;
    }

    form button[type="submit"] {
        background-color: #2563eb;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
    }

    form button[type="submit"]:hover {
        background-color: #204dbf;
    }

</style>
