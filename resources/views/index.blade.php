@extends('layouts.app')
@section('content')
    <div id="main">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Usuarios</h3>
                        <p class="text-subtitle text-muted">Administración de usuarios</p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        Usuarios
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addUserModal">Agregar
                            Usuario</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="container">
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
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="users-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th class="d-none d-md-table-cell">Correo</th>
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
                </div>
            </section>
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
                            <label for="correo">Correo:</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>

                        <div class="form-group">
                            <label for="telefono">Teléfono:</label>
                            <input type="number" class="form-control" id="telefono" name="telefono" required>
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
                            <label for="correo">Correo:</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
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
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get_users') }}",
                order: [
                    [1, 'asc']
                ],
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
                        data: 'correo',
                        name: 'correo'
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
                            //render the buttons with icons for edit and delete
                            return '<button class="btn btn-primary edit-user" data-user-id="' + data
                                .id +
                                '"><i class="fa fa-edit"></i></button> <button class="btn btn-danger delete-user" data-user-id="' +
                                data.id + '"><i class="fa fa-trash"></i></button>';
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
                    "processing": "Procesando...",
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
                correo: $('#correo').val(),
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
                    $('#addUserForm').trigger('reset');
                },
                error: function(error) {
                    $('#addUserModal').modal('hide');
                    $('#error-list').empty();
                    $('#error-alert').show();
                    $('#addUserForm').trigger('reset');
                    setTimeout(function() {
                        $('#error-alert').hide();
                    }, 3000);
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
                    $('#editUserForm #correo').val(response.correo);
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
                correo: $('#editUserForm #correo').val(),
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
                    $('#editUserForm').trigger('reset');
                    setTimeout(function() {
                        $('#success-alert').hide();
                    }, 3000);
                    $('#users-table').DataTable().ajax.reload();
                },
                error: function(error) {
                    $('#editUserModal').modal('hide');
                    $('#error-list').empty();
                    $('#error-alert').show();
                    $('#editUserForm').trigger('reset');
                    setTimeout(function() {
                        $('#error-alert').hide();
                    }, 3000);
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
@endsection
