<style>
    .form {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: bold;
    }

    input[type="text"],
    select {
        width: 100%;
        padding: 10px;
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

</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dodaj zadatak') }}
        </h2>
    </x-slot>

    <form action="add-task" method="post" class="form" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">Naslov zadatka:</label>
            <input type="text" id="title" name="title" placeholder="Naslov" required autofocus>
        </div>

        <div class="form-group">
            <label for="description">Opis zadatka:</label>
            <input type="text" id="description" name="description" placeholder="Opis" required>
        </div>

        <div class="form-group">
            <label for="deadline">Rok izvrsenja:</label>
            <input type="datetime-local" id="deadline" name="deadline" required>
        </div>

        <div class="form-group">
            <label for="priority">Prioritet izvrsenja(1-10):</label>
            <select name="priority" id="priority">
                @for($i = 1; $i <= 10; $i++)
                    <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
        </div>

        <div class="form-group">
            <label for="group_id">Grupa kojoj zadatak pripada:</label>
            <select name="group_id" id="group_id">
                @foreach($groups as $group)
                    <option value="{{$group->id}}">{{$group->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="executants">Izaberi izvrsioce zadatka:</label>
            <select name="executants[]" id="executants" multiple>
                @foreach($executants as $executant)
                    <option value="{{$executant->id}}">{{$executant->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="attachments">Dodajte priloge:</label>
            <input type="file" name="attachments[]" id="attachments" multiple>
        </div>



        <div class="form-group">
            <input type="submit" value="Sacuvaj" class="submit-btn">
        </div>
    </form>
</x-app-layout>

<script>
    $(document).ready(function () {
        $('#executants').select2();
    });
</script>
