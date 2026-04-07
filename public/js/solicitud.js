
$(function () {

    function cargarSolicitudes() {
        $.ajax({
            url: "index.php?option=solicitudes_json",
            method: "GET",
            dataType: "json",
            success: function (data) {
                let html = "";

                if (data.length === 0) {
                    html = '<tr><td colspan="6" class="loader">No hay solicitudes pendientes</td></tr>';
                } else {
                    data.forEach(function (solicitud) {
                        html += `
                            <tr>
                                <td>${solicitud.id}</td>
                                <td>${solicitud.taller}</td>
                                <td>${solicitud.solicitante}</td>
                                <td>${solicitud.usuario}</td>
                                <td>${solicitud.fecha_solicitud}</td>
                                <td>
                                    <button class="btn-aprobar" data-id="${solicitud.id}">Aprobar</button>
                                    <button class="btn-rechazar" data-id="${solicitud.id}">Rechazar</button>
                                </td>
                            </tr>
                        `;
                    });
                }

                $("#solicitudes-body").html(html);
            },
            error: function () {
                $("#solicitudes-body").html('<tr><td colspan="6" class="loader">Error al cargar solicitudes</td></tr>');
            }
        });
    }

    $(document).on("click", ".btn-aprobar", function () {
        const idSolicitud = $(this).data("id");

        $.ajax({
            url: "index.php",
            method: "POST",
            dataType: "json",
            data: {
                option: "aprobar",
                id_solicitud: idSolicitud
            },
            success: function (response) {
                if (response.success) {
                    $("#mensaje").text("Solicitud aprobada correctamente");
                    cargarSolicitudes();
                } else {
                    $("#mensaje").text(response.error);
                }
            },
            error: function () {
                $("#mensaje").text("Error al aprobar solicitud");
            }
        });
    });

    $(document).on("click", ".btn-rechazar", function () {
        const idSolicitud = $(this).data("id");

        $.ajax({
            url: "index.php",
            method: "POST",
            dataType: "json",
            data: {
                option: "rechazar",
                id_solicitud: idSolicitud
            },
            success: function (response) {
                if (response.success) {
                    $("#mensaje").text("Solicitud rechazada correctamente");
                    cargarSolicitudes();
                } else {
                    $("#mensaje").text(response.error);
                }
            },
            error: function () {
                $("#mensaje").text("Error al rechazar solicitud");
            }
        });
    });

    if ($("#solicitudes-body").length) {
        cargarSolicitudes();
    }
});
