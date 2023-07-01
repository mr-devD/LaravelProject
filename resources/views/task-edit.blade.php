<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Izmena zadatka') }}
        </h2>
    </x-slot>

    <div class="form-container">
        <form action="{{route('task.edit')}}" method="post">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label for="title">Naslov:</label>
                    <input type="text" name="title" id="title" value="{{$task->title}}" required autofocus><br>
                    @error('title')
                    <div class="error">{{$message}}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Opis:</label>
                    <textarea name="description" id="description" cols="25" rows="1" required> {{$task->description}}</textarea>
                    @error('description')
                    <div class="error">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="manager">Rukovodioc:</label>
                    <input type="text" name="manager" id="manager" value="{{$task->manager->name}}" disabled><br>
                </div>
                <div class="form-group">
                    <label for="deadline">Rok izvrsenja:</label>
                    <input type="datetime-local" name="deadline" id="deadline" value="{{$task->deadline}}" required><br>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="priority">Prioritet:</label>
                    <select name="priority" id="priority" required>
                        @for($i = 1; $i <= 10; $i++)
                            <option value="{{$i}}" @if($task->priority == $i) {{'selected'}} @endif>{{$i}}</option>
                        @endfor
                    </select>
                    @error('priority')
                    <div class="error">{{$message}}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="group">Grupa:</label>
                    <select name="group" id="group">
                        @foreach($groups as $group)
                            <option value="{{$group->id}}" @if($task->taskGroup->id === $group->id)
                                {{'selected'}}
                                @endif>{{$group->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <br>
            <input type="hidden" value="{{$task->id}}" name="task_id">
            <input type="submit" value="Izmeni" class="submit-btn">
        </form>
    </div>



</x-app-layout>

<style>
    .form-container {
        max-width: 500px;
        margin: 0 auto;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;

    }

    .form-group {
        width: calc(50% - 10px);
        margin-bottom: 10px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
    }

    .form-group input[type="text"],
    .form-group select,
    .form-group input[type="datetime-local"] {
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

    .error {
        color: red;
        margin-top: 5px;
    }
</style>
