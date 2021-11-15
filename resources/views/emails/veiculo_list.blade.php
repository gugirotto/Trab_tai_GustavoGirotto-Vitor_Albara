<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name= "viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content='ie=edge'>
        <title>Veiculos</title>
    </head>
    <body>
        <<div class='container'>
    <div class='card'>
        <div class='card-body'>
            <div class='table-responsive'>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">nome</th>
                            <th scope="col">marca</th>
                            <th scope="col">modelo</th>
                            <th scope="col">tipo</th>
                            <th scope="col">placa</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                   
                         @foreach ($veiculo as $p)
                         

                            <tr>
                                <td><?= $p->id; ?></td>

                                <td><?= $p->loginveiculo->name; ?></td>

                                <td><?= $p->marca; ?></td>
                                <td><?= $p->modelo; ?></td>
                                <td><?= $p->tipo; ?></td>
                                <td><?= $p->placa; ?> </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
               
            </div>
        </div>

    </div>
    </body>
    </html>