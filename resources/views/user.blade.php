<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }}
        </h2>
    </x-slot>

    <div class="form-container">
        <form action="edit-user" method="post">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label for="name">Ime i prezime:</label>
                    <input type="text" name="name" id="name" value="{{$user->name}}">
                    @error('name')
                    <div class="error">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="username">Korisnicko ime:</label>
                    <input type="text" name="username" id="username" value="{{$user->username}}">
                    @error('username')
                    <div class="error">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" value="{{$user->email}}">
                    @error('email')
                    <div class="error">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type">Tip korisnika:</label>
                    <select name="type" id="type">
                        @foreach($types as $type)
                            <option value="{{$type->id}}" @if($type->id === $user->type->id)
                                {{'selected'}}
                                @endif>{{$type->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="phone">Telefon:</label>
                    <input type="tel" name="phone" id="phone" value="{{$user->phone}}">
                    @error('phone')
                    <div class="error">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="birthdate">Datum rodjenja:</label>
                    <input type="date" name="birthdate" id="birthdate" value="{{$user->birthdate}}">
                </div>
            </div>

            <input type="hidden" name="id" value="{{$user->id}}">

            <div class="form-group">
                <input type="submit" value="Izmeni" class="submit-btn">
            </div>
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
        margin-bottom: 20px;
    }

    .form-group {
        width: calc(50% - 10px);
        margin-bottom: 10px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group select,
    .form-group input[type="tel"],
    .form-group input[type="date"] {
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
