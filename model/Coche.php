<?php
class Coche
{
    private $marca;
    private $modelo;
    private $color;
    private $propietario;
    private $id;
    public static $coches;

    //mejora la claridad al distinguir explícitamente entre los valores de entrada y las propiedades de la clase.
    public function __construct($miMarca, $miModelo, $miColor, $miPropietario, $miId)
    {
        $this->marca = $miMarca;
        $this->modelo = $miModelo;
        $this->color = $miColor;
        $this->propietario = $miPropietario;
        $this->id = $miId;
    }


    //métodos
    function setMarca($miMarca)
    {
        $this->marca = $miMarca;
    }
    function getMarca()
    {
        return $this->marca;
    }
    function setmodelo($miModelo)
    {
        $this->modelo = $miModelo;
    }
    function getmodelo()
    {
        return $this->modelo;
    }
    function setColor($miColor)
    {
        $this->color = $miColor;
    }
    function getColor()
    {
        return $this->color;
    }
    function setPropietario($miPropietario)
    {
        $this->propietario = $miPropietario;
    }
    function getPropietario()
    {
        return $this->propietario;
    }
    public function getId()
    {
        return $this->id;
    }
    public static function obtenerCoches()
    {
        try {
            //creo la conexion,Este objeto tiene métodos para interactuar con la base de datos.
            $conexion = new PDO("mysql:host=localhost;dbname=coches", "root", "");
            //meto en la variable rows la informacion que consulta de la base de datos
            // query es un método de PDO o MySQLi que ejecuta una consulta SQL directamente en la base de datos
            $rows = $conexion->query('SELECT id, marca, modelo, color, propietario FROM miscoches');
            //Este bucle recorre los resultados de la consulta obtenidos almacenados en rows
            // y crea instancias de la clase coche con los datos obtenidos de cada fila
            //cada fila es asignada con la variable row2 
            //en cada iteracion se crea un nuevo objeto de la clase coche utilizando los datos de las filas(row2)
            foreach ($rows as $row2) {
                $coche = new Coche($row2["marca"], $row2["modelo"], $row2["color"], $row2["propietario"], $row2["id"]);
                //aqui el nuevo objeto coche se agrega a un array 
                //Las propiedades estáticas pertenecen a la clase en sí y 
                //no a una instancia particular, lo que permite que todas las instancias de la clase accedan a ella.
                self::$coches[$row2["id"]] = $coche;
            }
            return self::$coches;
        } catch (PDOException $e) {
            echo "Error en la conexión a la base de datos: " . $e->getMessage();
            return [];
        }

    }
    public static function borrar($id)
    {
        // Conexión a la base de datos
        $conexion = new PDO("mysql:host=localhost;dbname=coches", "root", "");

        // Consulta SQL con parámetros
        $sql = 'DELETE FROM miscoches WHERE id = :id';
        $stmt = $conexion->prepare($sql);

        // Vincula el parámetro
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Ejecuta la consulta
        $stmt->execute();
    }
    //requiere estos parametros que los manda GuardarCoche
    public static function darDeAlta($marca, $modelo, $color, $propietario)
    {
        try {
            //1.Conectamos a la base de datos (ajusta los datos de conexión según sea necesario)
            $conexion = new PDO("mysql:host=localhost;dbname=coches", "root", "");

            //2.Preparamos la consulta SQL para insertar un nuevo coche
            $sql = "INSERT INTO miscoches (marca, modelo, color, propietario) VALUES (:marca, :modelo, :color, :propietario)";
            $stmt = $conexion->prepare($sql);

            // Vinculamos los parámetros con los valores proporcionados
            $stmt->bindParam(':marca', $marca);
            $stmt->bindParam(':modelo', $modelo);
            $stmt->bindParam(':color', $color);
            $stmt->bindParam(':propietario', $propietario);

            // Ejecutamos la consulta
            if ($stmt->execute()) {
                echo "Coche agregado con éxito.";
                return true; // Devolvemos true si la operación fue exitosa
            } else {
                echo "Error al agregar el coche.";
                return false;
            }
        } catch (PDOException $e) {
            echo "Error en la conexión o en la consulta: " . $e->getMessage();
            return false;
        }
    }
    public static function modificar($marca, $modelo, $color, $propietario, $id)
    {
        try {
            // 1. Conectamos a la base de datos (ajusta los datos de conexión según sea necesario)
            $conexion = new PDO("mysql:host=localhost;dbname=coches", "root", "");

            // Habilitamos el manejo de excepciones para PDO
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // 2. Preparamos la consulta SQL para EDITAR un coche
            $sql = "UPDATE miscoches 
                SET marca = :marca, modelo = :modelo, color = :color, propietario = :propietario 
                WHERE id = :id";
            $stmt = $conexion->prepare($sql);

            // Vinculamos los parámetros con los valores proporcionados
            $stmt->bindParam(':marca', $marca);
            $stmt->bindParam(':modelo', $modelo);
            $stmt->bindParam(':color', $color);
            $stmt->bindParam(':propietario', $propietario);
            $stmt->bindParam(':id', $id);

            // Ejecutamos la consulta
            if ($stmt->execute()) {
                echo "Coche editado con éxito.";
                return true; // Devolvemos true si la operación fue exitosa
            } else {
                echo "Error al editar el coche.";
                return false;
            }
        } catch (PDOException $e) {
            // Capturamos cualquier error y lo mostramos
            echo "Error en la conexión o en la consulta: " . $e->getMessage();
            return false;
        } finally {
            // Cerramos la conexión
            $conexion = null;
        }
    }
    public static function sancionarPM($marca)
{//siempre try catch para los mensajes de error
    try {
        // Conexión a la base de datos
        $conexion = new PDO("mysql:host=localhost;dbname=coches", "root", "");
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consulta SQL con parámetros
        $sql = 'DELETE FROM miscoches WHERE marca = :marca';
        $stmt = $conexion->prepare($sql);

        // Vincula el parámetro como una cadena no como int!
        $stmt->bindParam(':marca', $marca, PDO::PARAM_STR);

        // Ejecuta la consulta
        $stmt->execute();

        // Verifica si se afectaron filas
        if ($stmt->rowCount() > 0) {
            return true; // Operación exitosa
        } else {
            return false; // No se encontró la marca
        }
    } catch (PDOException $e) {
        // Manejo de errores
        error_log("Error en sancionarPM: " . $e->getMessage());
        return false;
    }
}

}