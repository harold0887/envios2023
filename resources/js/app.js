$(function () {
    showModalLoad();
    confirmDelete();
    $(".b-close").on("click", function () {
        return $("#adCart").modal("hide");
    });
});

function showModalLoad() {
    $(
        "#create-product-admin,#create-membership-admin,#create-package,#edit-package,#edit-product,#edit-membership"
    ).submit(() => {
        $("#modal-spinner").modal("show");
    });
}

Livewire.on("error", function ($message) {
    swal("¡error!", $message["message"], "error");
});

Livewire.on("success", function ($message) {
    if ($message["title"]) {
        title = $message["title"];
    } else {
        title = "¡Buen trabajo!";
    }
    swal(title, $message["message"], "success");
});

Livewire.on("info", function ($message) {
    alertFloat("right", $message["message"], "cancel");
});

Livewire.on("success-auto-close", function ($message) {
    alertFloat("right", $message["message"], "check_circle");
});

Livewire.on("deleteCartAlert", ($message) => {
    alertFloat("right", $message["message"], "check_circle");
});

function alertFloat(align, message, icon) {
    type = ["info", "danger", "success", "warning", "rose", "primary"];

    color = Math.floor(Math.random() * 6 + 1);

    $.notify(
        {
            icon: icon,
            message: message,
        },
        {
            type: type[color],
            timer: 3000,
            placement: {
                from: "top",
                align: align,
            },
        }
    );
}

Livewire.on("confirmResend", function ($message) {
    text = "Realmente desea reenviar: " + $message["name"];

    Swal.fire({
        title: "Confirmar Envio",
        html: text,
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, renviar!",
    }).then((result) => {
        if (result.value) {
            Livewire.emit("resend",$message["id"],$message["condeSend"]);
        }
    });
});

Livewire.on("addCartAlert", function ($product) {
    $("#cartTitle").text($product["title"]);
    $("#cartPrice").text($product["price"]);
    $("#cartImage").attr("src", $product["image"]);
    $("#adCart").modal("show");
    //$(".modal-backdrop").remove();
});

//escuchar evento mostrar correos enviados
Livewire.on("sendSuccessHtml", function (message) {
    text =
        "<span class='font-weight-bold'>" +
        message["enviados"] +
        "</span>" +
        "<span> <br><br> " +
        message["note"] +
        "</span>" +
        "<span class='font-italic font-weight-bold'> " +
        message["email"] +
        "</span>";

    swal({
        title: "Enviado!",
        html: text,
        type: "success",
        buttonsStyling: false,
        confirmButtonClass: "btn btn-info",
    });
});

function confirmDelete() {
    $(
        ".show-alert-delete-membership,.show-alert-delete-product,.show-alert-delete-package"
    ).on("click", function () {
        var form = $(this).closest("form");

        var title = form.find("input:text").val();
        //var name = $(this).data("name");
        event.preventDefault();
        swal({
            title: "¿Realmente quiere eliminar " + title + "  ? ",
            //type: "info",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, eliminar!",
        }).then((result) => {
            if (result.value) {
                $("#modal-spinner").modal("show");
                form.submit();
            } else {
                console.log("no acepto");
            }
        });
    });
}
