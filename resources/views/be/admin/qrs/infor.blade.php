    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="https://static.thenounproject.com/png/3503944-200.png" type="image/gif" >

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>QR code </title>

    <style>
        html,
        body {
            height: 100%;
            background-color: rgba(213,225,239,255);
        }

        .container {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            padding: 15px;
            border-radius: 15px;
            text-align: center;
        }

        .card-img-top {
            border-radius: 10px;
        }

        .card-title {
            padding: 10px;
            font-size: 16px;
        }

        .card-text {
            font-size: 13px;
            color: grey;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="card" style="width: 18rem;">
        <div class="card-img-top d-flex justify-content-center align-items-center" style="width: 250px;height: 250px;background-color: #3685ff"  >
            {!! QrCode::color(255, 255, 255)->backgroundColor(54, 133, 255)->size(200)->generate(route('qr.infor',['qr_id'=>$qr->id])); !!}

        </div>
        <div class="card-body">
            <h6 class="card-title">Qr Number: {{$qr->id}}</h6>
            @if($qr->own_id != 0)
                <p class="card-text">Guest's name: {{ $qr->name }}</p>
                <p class="card-text">Note: {{$qr->note}}</p>
            @endif
            <p class="card-text">Name's homeowner: {{$user->name}}</p>
            <p class="card-text">Address: {{$user->building->name}}</p>

        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>
