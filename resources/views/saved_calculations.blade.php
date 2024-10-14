<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Weather Calculations</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container">
    <h1>Saved Weather Calculations</h1>

    <table class="table">
        <thead>
            <tr>
                <th>City Name</th>
                <th>Temperature</th>
                <th>Weather Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($calculations as $calculation)
                <tr>
                    <td>{{ $calculation->city_name }}</td>
                    <td>{{ $calculation->temperature }} °C</td>
                    <td>{{ $calculation->weather_description }}</td>
                    <td>
                        <!-- Add any action buttons here if needed -->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>