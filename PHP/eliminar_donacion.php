<?php
include('conexionn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    if (!empty($id)) {
        $sql = "DELETE FROM solicitardonacion WHERE idReceptor = ?";
        $stmt = $conex->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }

        $stmt->close();
    } else {
        echo "error";
    }
}
$conex->close();
?>
