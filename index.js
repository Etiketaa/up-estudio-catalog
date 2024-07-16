function validateForm() {
    var articulo = document.forms["productForm"]["articulo"].value;
    var marca = document.forms["productForm"]["marca"].value;
    var categoria = document.forms["productForm"]["categoria"].value;
    var precio = document.forms["productForm"]["precio"].value;
    var imagen = document.forms["productForm"]["imagen"].files[0];
    var imagen2 = document.forms["productForm"]["imagen2"].files[0];

    if (!articulo || !marca || !categoria || !precio || !imagen || !imagen2) {
        alert("Todos los campos son obligatorios.");
        return false;
    }

    var validImageTypes = ["image/jpeg", "image/png", "image/gif"];
    if (!validImageTypes.includes(imagen.type) || !validImageTypes.includes(imagen2.type)) {
        alert("Solo se permiten archivos de imagen (JPEG, PNG, GIF).");
        return false;
    }

    return true;
}