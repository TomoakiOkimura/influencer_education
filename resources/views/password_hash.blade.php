<form action="{{ route('password.hash.update') }}" method="POST">
    @csrf
    user_id
    <select name="user_id" id="">
        @foreach ($users as $user)
            <option name="" id="{{ $user->id }}" value="{{ $user->id }}">{{ $user->id }}</option>
        @endforeach
    </select>
    password
    <input type="text" name="password" placeholder="password">

    <input type="submit" value="登録">
</form>