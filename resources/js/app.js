import Dropzone from "dropzone";

// Desactivar la detección automática de elementos con la clase "dropzone"
Dropzone.autoDiscover = false;

// Inicializar un nuevo Dropzone en el elemento con id "dropzone"
const dropzone = new Dropzone('#dropzone',{
    dictDefaultMessage: "Sube aquí tu imagen",
    acceptedFiles: ".png,.jpg,.jpeg,.gif",
    addRemoveLinks: true,
    dictRemoveFile: "Borrar Archivo",
    maxFiles: 1,
    uploadMultiple: false,

    /**
     * Función que se ejecuta al inicializar Dropzone
     * Aquí se comprueba si ya existe una imagen cargada previamente
     */
    init: function() {
        if(document.querySelector('[name="imagen"]').value.trim()){
            // Crear un objeto simulado de archivo publicado
            const imagenPublicada = {};
            imagenPublicada.size = 1234;
            imagenPublicada.name = document.querySelector('[name="imagen"]').value;

            // Invocar la creación de la miniatura y el archivo en Dropzone
            this.options.addedfile.call(this, imagenPublicada);

            this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`);

            // Añadir clases de éxito a la previsualización
            imagenPublicada.previewElement.classList.add("dz-success", "dz-complete");
        }
    },
});

/**
 * Evento 'success' que se dispara cuando la imagen se sube correctamente.
 * Se actualiza el campo hidden para almacenar el nombre del archivo.
 */
dropzone.on("success", function(file, response){
    document.querySelector('[name="imagen"]').value =response.imagen
});

/**
 * Evento 'removedfile' que se dispara al eliminar un archivo de Dropzone.
 * Limpia el valor del campo hidden para que no se mantenga ninguna imagen.
 */
dropzone.on("removedfile", function() {
    document.querySelector('[name="imagen"]').value = "";
});