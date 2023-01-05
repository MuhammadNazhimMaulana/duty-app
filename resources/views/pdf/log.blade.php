<!DOCTYPE html>
<html>
<head>
    <style>
        body{
            font-family: sans-serif
        }

        .text {
            margin-bottom: 20px;
        }

        .table {
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
        }

        th {
            background-color:#89CFF0 ;
        }
        
        .center {
            text-align: center;
        }
    </style>

	<title>Log View</title>
</head>
<body>
	<h1 class="center">{{ $title }}</h1>
	<p class="text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

    <table class="table">
        <tr>
          <th>Action</th>
        </tr>

        @foreach ($logs as $data)
        <tr>
          <td>{{ $data->action }}</td>
        </tr>
        @endforeach
      </table>
</body>
</html>