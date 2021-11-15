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
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            
                            <th scope="col">nome</th>
                            <th scope="col">CPF</th>

                        </tr>
                    </thead>
                    <tbody>
                    
                         @foreach ($mecanicos as $p)
                           
                            <tr>
                                <td><?= $p->id; ?></td>
                              
                                <td><?= $p->nome; ?></td>
                                <td><?= $p->cpf; ?></td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
               
            </div>
        </div>

    </div>
    </body>
    </html>