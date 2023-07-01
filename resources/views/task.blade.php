<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'Zadatak - ' . $task->title }}
        </h2>
    </x-slot>
    <br>
    <br>
    <div class="task-header" @if($task->completed) style="background-color: #51ff31;"
         @elseif($task->canceled) style="background-color: red" @endif>
        <h3 class="task-title">{{ $task->title }}</h3>
        <div class="task-buttons">
            @if(Auth::user()->type->name == 'admin' || Auth::user()->type->name == 'manager')
                @if(!$task->completed && !$task->canceled)
                    <form action="task-completed" method="post">
                        @csrf
                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                        <button
                            class="task-button bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 border border-blue-700 rounded">
                            Zavrsi
                        </button>
                    </form>
                    <form action="task-canceled" method="post">
                        @csrf
                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                        <button
                            class="task-button bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 border border-blue-700 rounded">
                            Otkazi
                        </button>
                    </form>
                @endif
                <form action="edit/{{$task->id}}" method="get">
                    @csrf
                    <button
                        class="task-button bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 border border-blue-700 rounded">
                        Izmeni
                    </button>
                </form>
                <form action="{{ route('task.destroy') }}" method="post">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="task_id" value="{{ $task->id }}">
                    <button type="submit"
                            class="task-button bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 border border-blue-700 rounded">
                        Obrisi
                    </button>
                </form>
            @endif
        </div>
    </div>
    <div class="task-container">
        <div class="task-details">
            <p class="task-description">{{ $task->description }}</p>
            <div class="task-info">
                <div class="task-info-item">
                    <span class="info-label">Rukovodilac:</span>
                    <span class="info-value">{{ $task->manager->name }}</span>
                </div>
                <div class="task-info-item">
                    <span class="info-label">Rok izvršenja:</span>
                    <span class="info-value">{{ $task->deadline }}</span>
                </div>
                <div class="task-info-item">
                    <span class="info-label">Prioritet:</span>
                    <span class="info-value">{{ $task->priority }}</span>
                </div>
                <div class="task-info-item">
                    <span class="info-label">Grupa:</span>
                    <span class="info-value">{{ $task->taskGroup->name }}</span>
                </div>
            </div>
        </div>
        <div class="task-executants">
            <h4 class="executants-heading">Izvršioci zadatka:</h4>
            <ul class="executants-list">
                @foreach ($task->executants as $executant)
                    <li class="executant-item"
                        @if($task->checkIfexecutantComplete($executant->id)->completed === 1) style="background-color: #00cc00" @endif>
                        <span>{{ $executant->name }}</span>
                        @if($executant->id == Auth::user()->id && $taskexecutant->completed == 0 )
                            <form action="{{$task->id}}/complete" method="post">
                                @csrf
                                <input type="hidden" value="{{$task->id}}" name="task_id">
                                <button type="submit" class="complete-button">Uradio sam</button>
                            </form>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="task-attachments">
            <h4 class="attachments-heading">Prilozi:</h4>
            <ul class="attachments-list">
                @foreach($task->attachments as $attachment)
                    <li><a href="{{asset($attachment->path)}}" style="text-decoration: underline; color: #2563eb" download>{{$attachment->name}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>

    <br>
    <hr>
    <div class="comments-header">
        <h3>Komentari</h3>
    </div>
    <div class="comments-container">
        <div class="card shadow">
            <div class="card-header bg-secondary text-white">
                <h4 class="mb-0">Komentari</h4>
            </div>
            <div class="card-body">
                <form action="{{$task->id}}/send-comment" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Naslov komentara:</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                        @error('title')
                        <div style="color: red">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Napisi komentar:</label>
                        <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                        @error('description')
                        <div style="color: red">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Posalji</button>
                </form>
                <br>
                <div class="mb-3">
                    <h5 class="mb-0">Svi komentari:</h5>
                </div>
                @foreach($task->comments->reverse() as $comment)
                    <div class="card-header bg-secondary text-white">
                        <div class="card-header-content">
                            <span>{{$comment->user->name . ': ' . date('d/m/y H:i:s', strtotime($comment->created_at))}}</span>
                            @if(Auth::user()->type->id === 1 || Auth::user()->type->id === 2 || $comment->user_id === Auth::user()->id)
                                <form action="{{$task->id}}/{{$comment->id}}/comment-delete" method="post">
                                    @csrf
                                    <button type="submit" class="btn-sm btn-danger">Obrisi</button>
                                </form>
                            @endif
                        </div>

                    </div>
                    <div class="card-body" style="border: 1px solid #ced4da;">
                        <h6 class="card-title ">{{$comment->title}}</h6>
                        <p class="card-text">{{$comment->description}}</p>
                    </div>
                    <br>
                @endforeach
            </div>
        </div>


    </div>
</x-app-layout>

<style>
    .task-container {
        max-width: 600px;
        margin: 0 auto;
        background-color: #f8f8f8;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .task-header {
        text-align: center;
        max-width: 600px;
        margin: 0 auto;
        background-color: #2563eb;
        border-radius: 8px;
        padding: 2px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .task-title {
        font-size: 24px;
        font-weight: bold;
        color: #ffffff;
        text-align: center;
    }


    .task-button {
        margin-left: 10px; /* Adjust as needed */
        color: #ffffff;
        font-weight: bold;
        padding: 6px 12px;
        border-radius: 4px;
        border: 1px solid #007bff; /* Default border color */
    }

    .task-button:hover {
        cursor: pointer;
    }

    /* Yellow button */
    .task-button.bg-yellow-500 {
        background-color: #ffd700;
    }

    .task-button.bg-yellow-700:hover {
        background-color: #ffcc00;
    }

    /* Green button */
    .task-button.bg-green-500 {
        background-color: #00cc00;
    }

    .task-button.bg-green-700:hover {
        background-color: #00b300;
    }

    /* Red button */
    .task-button.bg-red-500 {
        background-color: #ff0000;
    }

    .task-button.bg-red-700:hover {
        background-color: #cc0000;
    }

    .task-buttons {
        display: flex;
        align-items: center;
    }

    .task-buttons button {
        margin-left: 10px;
    }

    .task-details {
        margin-bottom: 20px;
    }

    .task-description {
        margin-bottom: 20px;
    }

    .task-info {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .task-info-item {
        display: flex;
        align-items: center;
    }

    .info-label {
        font-weight: bold;
        margin-right: 5px;
    }

    .task-executants {
        margin-top: 20px;
    }

    .executants-heading {
        font-weight: bold;
    }

    .executants-list {
        list-style-type: disc;
        margin-left: 20px;
        padding-left: 20px;
    }

    .executants-list li {
        border: 1px solid #ccc;
        padding: 5px;
        margin-bottom: 5px;
    }

    .task-attachments {
        margin-top: 20px;
    }

    .attachments-heading {
        font-weight: bold;
    }

    .attachments-list {
        list-style-type: disc;
        margin-left: 20px;
        padding-left: 20px;
    }

    .attachments-list li {
        border: 1px solid #ccc;
        padding: 5px;
        margin-bottom: 5px;
    }

    .executant-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .complete-button {
        background-color: #00cc00;
        text-align: end;
        margin-left: 10px;
    }

    .comments-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .comments-header h3 {
        font-size: 24px;
        font-weight: bold;
    }

    .comments-container {
        max-width: 600px;
        margin: 0 auto;
    }

    .card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .card-header {
        background-color: #6c757d;
        color: #ffffff;
        padding: 10px;
        border-radius: 8px 8px 0 0;
    }

    .card-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h4 {
        margin-bottom: 0;
        font-size: 18px;
        font-weight: bold;
    }

    .card-body {
        padding: 20px;

    }

    .comment-body {
        border: 1px solid #ced4da;
    }

    .form-label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-control {
        width: 100%;
        padding: 8px;
        border-radius: 4px;
        border: 1px solid #ced4da;
    }

    .btn-primary {
        background-color: #007bff;
        color: #ffffff;
        border: none;
        border-radius: 4px;
        padding: 8px 16px;
        font-weight: bold;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        cursor: pointer;
    }

    .comment-list {
        margin-top: 20px;
    }

    .comment-author {
        font-weight: bold;
    }

    .comment-date {
        font-size: 12px;
        color: #6c757d;
    }

    .card-title {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .card-text {
        margin-bottom: 0;
    }

    .btn-sm {
        font-size: 12px;
        padding: 4px 8px;
    }

    .btn-danger {
        background-color: #dc3545;
        color: #ffffff;
        border: none;
        border-radius: 4px;
    }

    .btn-danger:hover {
        background-color: #9c2e3d;
        cursor: pointer;
    }


</style>
