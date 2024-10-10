<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h1>User List</h1>

        <a href="{{ route('users.create') }}" class="button">Create New User</a> <!-- Button to create new user -->

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (!empty($users)) {
                    foreach($users as $user) {
                    ?>
                        <tr>
                            <td><?php echo $user->name ?></td>
                            <td><?php echo $user->email ?></td>
                            <td>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php 
                    }
                } else {
                ?>
                    <tr>
                        <td colspan="3" class="text-center">No users found</td>
                    </tr>
                <?php
                }
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>