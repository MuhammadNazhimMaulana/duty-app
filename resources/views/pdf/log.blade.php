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

	<title>Index Log</title>
</head>
<body>
	<h1 class="center">{{ $title }}</h1>
	<p class="text">Berikut merupakan tabel daftar log yang telah anda lakukan selama beberapa waktu belakangan</p>

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