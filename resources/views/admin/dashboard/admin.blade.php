<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
</head>
<body>
    <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
    <a href="/admin/users">KELOLA USER</a>
    <a href="/admin/customers">KELOLA CUSTOMER</a>
    <h1>Welcome to the Dashboard Admin</h1>
</body>
</html>