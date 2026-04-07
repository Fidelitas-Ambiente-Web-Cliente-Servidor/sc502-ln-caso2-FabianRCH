
$(function () {

    function cargarTalleres() {
        $.ajax({
            url: "index.php?option=talleres_json",
            method: "GET",
            dataType: "json",
            success: function (data) {
                let html = "";

                if (data.length === 0) {
                    html = '<tr><td colspan="6" class="loader">No hay talleres disponibles</td></tr>';
                } else {
                    data.forEach(function (taller) {
                        html += `
                            <tr>
                                <td>${taller.id}</td>
                                <td>${taller.nombre}</td>
                                <td>${taller.descripcion}</td>
                                <td>${taller.cupo_maximo}</td>
                                <td>${taller.cupo_disponible}</td>
                                <td><button class="btn-solicitar" data-id="${taller.id}">Solicitar</button></td>
                            </tr>
                        `;
                    });
                }

                $("#talleres-body").html(html);
            },
            error: function () {
                $("#talleres-body").html('<tr><td colspan="6" class="loader">Error al cargar talleres</td></tr>');
            }
        });
    }

    $(document).on("click", ".btn-solicitar", function () {
        const idTaller = $(this).data("id");

        $.ajax({
            url: "index.php",
            method: "POST",
            dataType: "json",
            data: {
                option: "solicitar",
                taller_id: idTaller
            },
            success: function (response) {
                if (response.success) {
                    $("#mensaje").text("Solicitud enviada correctamente");
                    cargarTalleres();
                } else {
                    $("#mensaje").text(response.error);
                }
            },
            error: function () {
                $("#mensaje").text("Error al enviar solicitud");
            }
        });
    });

    if ($("#talleres-body").length) {
        cargarTalleres();
    }
});