<?php
require_once('./conexion.php');

$clave=$_GET["clave"];

$query_sql = "
select array_to_json(array_agg(row.*)) AS subgrupo2 
from (
SELECT *
FROM (	
select id_subgrupo2||'-'||id_subgrupo||'-'||id_grupo as value,descripcion as label
	from delitos.dp_subgrupo2
	where id_subgrupo='$clave'
)t
) row;
";
//equipo_pruebas  'N'
 //echo "$query_sql<br>";

$resultado = pg_query($cx, $query_sql) or die(pg_last_error());
$total_filas = pg_num_rows($resultado);

while ($fila_vertical = pg_fetch_assoc($resultado)) {
	$row_to_json = $fila_vertical['subgrupo2'];							
	echo "".$row_to_json."";
}	
// Liberando el conjunto de resultados
pg_free_result($resultado);

// Cerrando la conexión
pg_close($cx);
?>