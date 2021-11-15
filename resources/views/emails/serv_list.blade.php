<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name= "viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content='ie=edge'>
         
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
                            <th scope="col">mecanico</th>
                            <th scope="col">horario</th>
                            <th scope="col">placa</th>

                        </tr>
                    </thead>
                    <tbody>
                    
                        <@foreach ($servicos as $p) : ?>
                            
                            <tr>
                                <td><?= $p->id; ?></td>
                               
                                <td><?= $p->loginserviço->name; ?></td>
                                <td><?= $p->mecanicoserviço->nome; ?></td>
                                <td><?= $p->horario; ?></td>
                                <td><?= $p->placa; ?></td>

                              
                            </tr>
                                
                            
                        @endforeach
                    </tbody>
                </table>
               
            </div>
        </div>

    </div>
    </body>
    </html>