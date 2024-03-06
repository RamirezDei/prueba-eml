<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba EML</title>
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="alert alert-danger" id="error-alert" style="display: none;">
            <ul id="error-list">
            </ul>
        </div>
    </div>
    <div class="container mt-5">
        <div class="alert alert-success" id="success-alert" style="display: none;">
            <ul id="success-list">
            </ul>
        </div>
    </div>
    <div class="container mt-5">
        <h2>Usuarios</h2>
        <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addUserModal">Agregar Usuario</button>
        <div class="table-responsive">
            <table class="table" id="users-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th class="d-none d-md-table-cell">Teléfono</th>
                        <th class="d-none d-md-table-cell">Fecha de Registro</th>
                        <th class="d-none d-md-table-cell">Fecha de Última Modificación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="users-table-body">
                    <!-- Contenido de la tabla -->
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Agregar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Agrega esto dentro del modal de agregar usuario -->
                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group">
                            <label for="nombres">Nombres:</label>
                            <input type="text" class="form-control" id="nombres" name="nombres" required>
                        </div>

                        <div class="form-group">
                            <label for="apellidos">Apellidos:</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                        </div>

                        <div class="form-group">
                            <label for="telefono">Teléfono:</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <button onclick="createUser()" class="btn btn-primary">Guardar Usuario</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <div class="form-group">
                            <label for="nombres">Nombres:</label>
                            <input type="text" class="form-control" id="nombres" name="nombres" required>
                        </div>
                        <div class="form-group">
                            <label for="apellidos">Apellidos:</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono:</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <input type="hidden" id="user_id" name="user_id">
                        <button onclick="updateUser()" class="btn btn-primary">Actualizar Usuario</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get_users') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'nombres',
                        name: 'nombres'
                    },
                    {
                        data: 'apellidos',
                        name: 'apellidos'
                    },
                    {
                        data: 'telefono',
                        name: 'telefono'
                    },
                    {
                        data: 'fecha_registro',
                        name: 'fecha_registro'
                    },
                    {
                        data: 'fecha_modificacion',
                        name: 'fecha_modificacion'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return '<button class="btn btn-warning edit-user" data-user-id="' + row
                                .id + '">Editar</button>' +
                                '<button class="btn btn-danger delete-user" data-user-id="' + row
                                .id + '">Eliminar</button>';
                        }
                    }
                ],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "No se encontraron registros",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                },
            });
        });

        function createUser() {
            event.preventDefault();
            var data = {
                nombres: $('#nombres').val(),
                apellidos: $('#apellidos').val(),
                telefono: $('#telefono').val(),
                _token: "{{ csrf_token() }}"
            };
            $.ajax({
                type: 'POST',
                url: '/users',
                data: data,
                success: function(response) {
                    $('#addUserModal').modal('hide');
                    $('#success-list').empty();
                    $('#success-list').append('<li>Usuario agregado correctamente</li>');
                    $('#success-alert').show();
                    setTimeout(function() {
                        $('#success-alert').hide();
                    }, 3000);
                    $('#users-table').DataTable().ajax.reload();
                },
                error: function(error) {
                    $('#error-list').empty();
                    $('#error-alert').show();
                    $.each(error.responseJSON.errors, function(key, value) {
                        $('#error-list').append('<li>' + value + '</li>');
                    });
                }
            });
        }

        $(document).on('click', '.edit-user', function() {
            var user_id = $(this).data('user-id');
            $.ajax({
                type: 'GET',
                url: '/users/' + user_id,
                success: function(response) {
                    $('#editUserModal').modal('show');
                    $('#editUserForm #nombres').val(response.nombres);
                    $('#editUserForm #apellidos').val(response.apellidos);
                    $('#editUserForm #telefono').val(response.telefono);
                    $('#editUserForm #user_id').val(user_id);
                }
            });
        });

        function updateUser() {
            event.preventDefault();
            var data = {
                nombres: $('#editUserForm #nombres').val(),
                apellidos: $('#editUserForm #apellidos').val(),
                telefono: $('#editUserForm #telefono').val(),
                user_id: $('#editUserForm #user_id').val(),
                _token: "{{ csrf_token() }}"
            };
            $.ajax({
                type: 'PUT',
                url: '/users/' + data.user_id,
                data: data,
                success: function(response) {
                    $('#editUserModal').modal('hide');
                    $('#success-list').empty();
                    $('#success-list').append('<li>Usuario actualizado correctamente</li>');
                    $('#success-alert').show();
                    setTimeout(function() {
                        $('#success-alert').hide();
                    }, 3000);
                    $('#users-table').DataTable().ajax.reload();
                },
                error: function(error) {
                    $('#error-list').empty();
                    $('#error-alert').show();
                    $.each(error.responseJSON.errors, function(key, value) {
                        $('#error-list').append('<li>' + value + '</li>');
                    });
                }
            });
        }

        $(document).on('click', '.delete-user', function() {
            var user_id = $(this).data('user-id');
            if (confirm('¿Estás seguro de eliminar este usuario?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/users/' + user_id,
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#success-list').empty();
                        $('#success-list').append('<li>Usuario eliminado correctamente</li>');
                        $('#success-alert').show();
                        setTimeout(function() {
                            $('#success-alert').hide();
                        }, 3000);
                        $('#users-table').DataTable().ajax.reload();
                    }
                });
            }
        });
    </script>

</body>

</html>
