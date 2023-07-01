<style>
    .task-table {
        width: 100%;
        border-collapse: collapse;
    }

    .task-table th,
    .task-table td {
        padding: 10px;
        text-align: left;
    }

    .task-table th {
        background-color: #f2f2f2;
        font-weight: bold;
        color: #333;
        text-transform: uppercase;
    }

    .task-table td {
        border-bottom: 1px solid #ddd;
    }

    .task-table td.title {
        font-weight: bold;
        color: #2563eb;
    }

    .task-table td.description {
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .task-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    /* DataTable Styling */
    .dataTables_wrapper {
        position: relative;
        overflow: auto;
    }

    .dataTables_wrapper .dataTables_paginate {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 1rem 0;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.5rem 0.75rem;
        margin: 0 0.25rem;
        border-radius: 0.25rem;
        color: #333;
        background-color: #f2f2f2;
        border: none;
        cursor: pointer;

    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #e0e0e0;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #2563eb;
        color: #fff;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        cursor: default;
        opacity: 0.5;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        background-color: #f2f2f2;
    }

    .dataTables_wrapper .dataTables_paginate .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .dataTables_wrapper .dataTables_paginate .pagination .page-item {
        list-style: none;
        margin: 0 0.25rem;
    }

    .dataTables_wrapper .dataTables_paginate .pagination .page-link {
        padding: 0.5rem 0.75rem;
        color: #333;
        background-color: #f2f2f2;
        border: none;
        cursor: pointer;
    }

    .dataTables_wrapper .dataTables_paginate .pagination .page-link:hover {
        background-color: #e0e0e0;
    }

    .dataTables_wrapper .dataTables_paginate .pagination .page-item.active .page-link {
        background-color: #2563eb;
        color: #fff;
    }

    .dataTables_wrapper .dataTables_paginate .pagination .page-item.disabled .page-link {
        cursor: default;
        opacity: 0.5;
    }

    .dataTables_wrapper .dataTables_paginate .pagination .page-item.disabled .page-link:hover {
        background-color: #f2f2f2;
    }


    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_length {
        display: flex;
        justify-content: space-between;
        align-items: center;

    }

    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 0.25rem;
    }

    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label {
        margin-right: 0.5rem;
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
            <th>Naslov</th>
            <th>Opis</th>
            <th>Rukovodioc</th>
            <th>Rok izvršenja</th>
            <th>Prioritet</th>
            <th>Grupa</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
            <tr>
                <td class="title"><a href="task/{{$task->id}}">{{$task->title}}</a></td>
                <td class="description">{{$task->description}}</td>
                <td>{{$task->manager->name}}</td>
                <td>{{$task->deadline}}</td>
                <td>{{$task->priority}}</td>
                <td>{{$task->taskGroup->name}}</td>
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



