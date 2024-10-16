document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('alumnoForm');

    // Registrar un nuevo alumno
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const nombre = document.getElementById('nombre').value;
        const apellido = document.getElementById('apellido').value;
        const yearOfBirth = document.getElementById('year_of_birth').value;
        const yearOfEntry = document.getElementById('year_of_entry').value;

        // Validaciones del lado del cliente
        if (nombre === '' || apellido === '' || yearOfBirth === '' || yearOfEntry === '') {
            alert('Todos los campos son obligatorios');
            return;
        }

        // Hacer la solicitud asíncrona
        const data = new FormData(form);
        const response = await fetch('app/controller/alumnosController.php?action=registrar', {
            method: 'POST',
            body: data
        });

        const result = await response.json();
        if (result.success) {
            alert('Alumno registrado con éxito');
            listarAlumnos(); // Actualizar la lista sin recargar
        } else {
            alert('Error al registrar el alumno');
        }
    });

    // Función para listar alumnos
    async function listarAlumnos() {
        const response = await fetch('app/controller/alumnosController.php?action=listar');
        const alumnos = await response.json();
        
        const tbody = document.querySelector('tbody');
        tbody.innerHTML = ''; // Limpiar la tabla

        alumnos.forEach(alumno => {
            tbody.innerHTML += `
                <tr>
                    <td>${alumno.id}</td>
                    <td>${alumno.nombre}</td>
                    <td>${alumno.apellido}</td>
                    <td>${alumno.year_of_birth}</td>
                    <td>${alumno.year_of_entry_into_the_degree}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editarAlumno(${alumno.id})">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarAlumno(${alumno.id})">Eliminar</button>
                    </td>
                </tr>`;
        });
    }

    // Cargar alumnos al iniciar la página
    listarAlumnos();

    // Función para eliminar un alumno
    async function eliminarAlumno(id) {
        if (confirm('¿Estás seguro de eliminar este alumno?')) {
            const response = await fetch(`app/controller/alumnosController.php?action=eliminar&id=${id}`);
            const result = await response.json();

            if (result.success) {
                alert('Alumno eliminado con éxito');
                listarAlumnos();
            } else {
                alert('Error al eliminar el alumno');
            }
        }
    }

    window.eliminarAlumno = eliminarAlumno;
});
