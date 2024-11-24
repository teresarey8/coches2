<?php
/* 1. Inicio de la aplicación: El controlador crea una instancia de CocheController, carga los coches en el constructor, y establece la lista en $this->miscoches.
   2.Llamada a index(): Muestra la lista completa de coches en index.php.
   3.Llamada a ver($id): Muestra los detalles de un coche específico en ver.php, si el $id es válido. Si no es válido, vuelve a index().*/
class CocheController
{
    private $miscoches;
    //llamamos a obtenercoches, que esta en el modelo y que contiene todos los coches
    //sacados de la base de datos, lo devuelve en forma de lista
    //y se lo almacena a miscoches
    function __construct()
    {
        $this->miscoches = Coche::obtenerCoches();
    }

    function index()
    {
        echo "<br>Llamando a la función index():<br>"; // Mensaje de depuración
        //Asignamos la lista de coches completa a una rowset que espera la vista
        $rowset = $this->miscoches;
        //Le paso los datos a la vista
        require("view/index.php");
    }
    //funcion publica ver que require un id
    public function ver($id)
    {
        echo "Llamando a la función ver() con id: $id<br>"; // Mensaje de depuración
        //si ese identificador puesto en la barra de direcciones esta en el array
        //lo guarda en la variable rowset y lo muestra
        if (array_key_exists($id, $this->miscoches)) {

            //Si el elemento está en el array, lo busco en rowset a partir de dicho id y lo muestro
            $rowset = $this->miscoches[$id];
            require("view/ver.php");
        } else {
            echo "ID no encontrado, regresando a index<br>";
            $this->index();
        }
    }

    public function borrar($id)
    {
        // Verifica si el coche existe en el arreglo miscoches
        if (isset($this->miscoches[$id])) {
            Coche::borrar($id);  // Llama al método borrar del modelo
            echo "Se ha borrado el coche";
            header("refresh:1; url=/proyectos/coches2/index.php");
        } else {
            // Si no existe, muestra un mensaje o llama al método por defecto
            echo "El coche no existe o ha sido eliminado previamente.";
            $this->index();
        }
    }

    //cuando le das click a insertar coche vuelveal controller y ahora si que va al modelo
    public function guardarCoche()
    {
        // Verificar que los datos han sido enviados
        if (isset($_POST['marca'], $_POST['modelo'], $_POST['color'], $_POST['propietario'])) {
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $color = $_POST['color'];
            $propietario = $_POST['propietario'];
            // Llamar al método para dar de alta el coche
            if (Coche::darDeAlta($marca, $modelo, $color, $propietario)) {
                echo "Coche agregado correctamente.";
                header("Location: /proyectos/coches2/index.php"); // Redirige a la vista principal después de agregar
            } else {
                echo "Error al agregar el coche.";
            }
        } else {
            echo "Datos incompletos.";
        }
    }
    //este no va al modelo por que obtiene los datos de un formulario y luego vuelve a la funcion GuardarCoche al darle al boton
//"insertar coches" en el formulario
    public function mostrarFormularioAlta()
    {
        require("view/alta.php");
    }
    public function editar($id)
    {
        echo "<br>Llamando a la función editar() con id: $id <br>"; // Mensaje de depuración
        //si el id que he recibido como parametro existe en el array
        if (array_key_exists($id, $this->miscoches)) {

            //lo busco en rowset a partir de dicho id y lo muestro
            $rowset = $this->miscoches[$id];
            require("view/editar.php");
        } else {
            echo "ID no encontrado, regresando a index<br>";
            $this->index();
        }
    }

    public function guardarCocheE()
    {
        // Verificar que los datos han sido enviados
        if (isset($_POST['marca'], $_POST['modelo'], $_POST['color'], $_POST['propietario'], $_POST['id'])) {
            // Obtener los datos enviados a traves del id
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $color = $_POST['color'];
            $propietario = $_POST['propietario'];
            $id = $_POST['id'];
            // Llamar al método para que edite el coche
            if (Coche::modificar($marca, $modelo, $color, $propietario, $id)) {
                echo "Coche editado correctamente.";
                header("Location: /proyectos/coches2/index.php"); // Redirige a la vista principal después de modificar
            } else {
                echo "Error al agregar el coche.";
            }
        } else {
            echo "Datos incompletos.";
        }
    }
    public function sancionar($marca)
    {
        // Validar que la marca sea un valor no vacío y válido
        //var_dump($marca);
        //die();
        //echo "<pre>";
        //var_dump($marca, $this->miscoches);
        //die();
        //debugueando 
        /*if (!empty($marca)) {
            if (isset($this->miscoches[$marca])) {
            echo "Marca encontrada: " . $marca;
        } else {
        echo "La marca no está en miscoches.";
        }
        } else {
        echo "La marca está vacía.";
        }
        die();

        */
        // Validar entrada
        echo "Llamando a la función sancionar() con marca: $marca<br>"; // Mensaje de depuración
        $marca = filter_var($marca, FILTER_SANITIZE_STRING);
        if (isset($this->miscoches[$marca])) {
            echo "El coche no existe o ha sido eliminado previamente.";
            $this->index();
            return;
        } else {

            $resultado = Coche::sancionarPM($marca);

            if ($resultado) {
                echo "Se han sancionado los coches.";
            } else {
                echo "El coche no se pudo sancionar. Puede que ya no exista en la base de datos.";
            }

            header("refresh:1; url=/proyectos/coches2/index.php");
            exit;

        }
    }

}