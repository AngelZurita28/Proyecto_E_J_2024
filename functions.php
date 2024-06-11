<?php 

function mostrar_plan_admin(){
  include('conexion.php');

  // Ejecutar la consulta
  $sql = "SELECT Producto.*, Proveedor.nombre AS nombre_proveedor
  FROM Producto
  JOIN Proveedor ON Producto.id_proveedor = Proveedor.id_proveedor;";
  $stmt = sqlsrv_query($conn, $sql);

  // Verificar si la consulta fue exitosa
  if ($stmt === false) {
      die("Error al ejecutar la consulta: " . print_r(sqlsrv_errors(), true));
  }


  // Iterar sobre los resultados e imprimir el nombre de cada producto
  while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo('<div class="container" style="padding-top: 1rem; padding-bottom: 1rem;">
    <div class="container rounded-4 bg-light" style="padding: 2rem;">
    <div class="row ">
      <div class="col d-flex justify-content-center text-end display-5 align-items-center" style="color: rgb(252, 57, 57);">
      '.htmlspecialchars($row['nombre']).'
      </div>
      <div class="col-6 d-flex text-start align-items-center">
        <div class="row" style="padding: 1rem;">
        '.htmlspecialchars($row['descripcion']).'
        </div>
      </div>
      <div class="col d-flex text-start align-items-center"> '.htmlspecialchars($row['nombre_proveedor']).'</div>
      <div class="col d-flex justify-content-center text-end display-6 align-items-center" style="color: rgb(252, 57, 57);">
      $'.htmlspecialchars($row['precio']).'
    </div>
    </div> 
            <form action="eliminar_plan.php" method="get"> 
            <input type="hidden" id="plan_id" name="plan_id" value="'.htmlspecialchars($row['id_producto']).'">
            <input class="btn btn-primary" type="submit" value="ELIMINAR PLAN" action="eliminar_plan.php">
            </form>
      </div>
    </div>');
  }
  // Liberar recursos
sqlsrv_free_stmt($stmt);

// Cerrar la conexión
sqlsrv_close($conn);
}

    
function mostrar_plan(){
  include('conexion.php');

  // Ejecutar la consulta
  $sql = "SELECT Producto.*, Proveedor.nombre AS nombre_proveedor
  FROM Producto
  JOIN Proveedor ON Producto.id_proveedor = Proveedor.id_proveedor;";
  $stmt = sqlsrv_query($conn, $sql);

  // Verificar si la consulta fue exitosa
  if ($stmt === false) {
      die("Error al ejecutar la consulta: " . print_r(sqlsrv_errors(), true));
  }


  // Iterar sobre los resultados e imprimir el nombre de cada producto
  while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo('<div class="container" style="padding-top: 1rem; padding-bottom: 1rem;">
    <div class="container rounded-4 bg-light" style="padding: 2rem;">
    <div class="row ">
      <div class="col d-flex justify-content-center text-end display-5 align-items-center" style="color: rgb(252, 57, 57);">
      '.htmlspecialchars($row['nombre']).'
      </div>
      <div class="col-6 d-flex text-start align-items-center">
        <div class="row" style="padding: 1rem;">
        '.htmlspecialchars($row['descripcion']).'
        </div>
      </div>
      <div class="col d-flex text-start align-items-center"> '.htmlspecialchars($row['nombre_proveedor']).'</div>
      <div class="col d-flex justify-content-center text-end display-6 align-items-center" style="color: rgb(252, 57, 57);">
      $'.htmlspecialchars($row['precio']).'
    </div>
    </div> 
          <form action="plan.php" method="get"> 
            <input type="hidden" id="plan_id" name="plan_id" value="'.htmlspecialchars($row['id_producto']).'">
            <input class="btn btn-primary" type="submit" value="Lo Quiero!" action="plan.php">
            </form>
            </div>
         </div>');
  }
  // Liberar recursos
sqlsrv_free_stmt($stmt);

// Cerrar la conexión
sqlsrv_close($conn);
}

// function mostrar_plan(){
//     include 'conexion.php';
    
//     $sql = "SELECT * FROM Plan WHERE estado_plan = 1";
//     $result = $conn->query($sql);
    
    
//     if ($result->num_rows > 0) {
//         while($row = $result->fetch_assoc()) {
            
//             echo('<div class="container" style="padding-top: 1rem; padding-bottom: 1rem;">
//             <div class="container rounded-4 bg-light" style="padding: 2rem;">
//             <h3 style="color: rgb(252, 57, 57);">'.htmlspecialchars($row['nombre']).'</h3>
//             <div class="row ">
//                <div class="col d-flex justify-content-center text-end display-5 align-items-center" style="color: rgb(252, 57, 57);">
//                '.htmlspecialchars($row['megas']).'
//                </div>
//                <div class="col-6 d-flex text-start align-items-center">
//                  <div class="row" style="padding: 1rem;">
//                  '.htmlspecialchars($row['descripcion']).'
//                  </div>
//                </div>
//                <div class="col d-flex text-start align-items-center">
//                 cantidad de equipos: '.htmlspecialchars($row['equipos']).' y cubre '.htmlspecialchars($row['metros']).' metros cuadrados
//                </div>
//                <div class="col d-flex justify-content-center text-end display-6 align-items-center" style="color: rgb(252, 57, 57);">
//                $'.htmlspecialchars($row['precio']).'
//              </div>
//             </div> 
//                     <form action="plan.php" method="get"> 
//                     <input type="hidden" id="plan_id" name="plan_id" value="'.htmlspecialchars($row['id']).'">
//                     <input class="btn btn-primary" type="submit" value="Lo Quiero!" action="plan.php">
//                      </form>
//               </div>
//             </div>');

//         }
//     } else {
//         echo "<p>No hay productos disponibles.</p>";
//     }
               
// } 



