<?php
session_start();

include '../connectionBD.php';
include '../auxiliary.php';
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $state = $_POST['state'];

        switch ($state) {
            case 'add':
                //Patient
                $name = $_POST['name'];
                $lastname = $_POST['lastname'];
                $date_birth = $_POST['date-birth'];
                $id_gender = $_POST['id-gender'];
                $id_professional =  $_SESSION['id_professional'];
                //representative
                $representative_name = $_POST['representative__name'] ?? '';
                $representative_lastname = $_POST['representative__lastname'] ?? '';
                $representative_email = $_POST['representative__email'] ?? '';
                $representative_phone_number = $_POST['representative-phone-number'] ?? '';
                $representative_secret_code = $_POST['representative__secret-code'] ?? '';

                //User
                $user = $_POST['user'];
                $password = $_POST['password'];

                //Information about dyslalia
                $dyslalia_type = $_POST['dyslalia-type'];
                $dyslalia_classification = $_POST['classification'];
                $dyslalia_observations = $_POST['observations'];
                $dyslalia_phonemes = $_POST['phonemes'];
                $dyslalia_gravity = $_POST['gravity'];

                //Personalization of the therapy session
                $duration_each_exercise = $_POST['duration-each-exercise'] ?? NULL;
                $session_duration = $_POST['duration-each-exercise'] ?? NULL;
                $input_therapys = $_POST['input-therapys'];
                $support_materials = $_POST['support-materials'] ?? [];
                $note = $_POST['note'] ?? null;



                //Search if the user already exists
                $search_user_query = "SELECT usuario FROM usuarios WHERE usuario = :user ";
                $search_user_stmt = $pdo->prepare($search_user_query);
                $search_user_stmt->bindParam('user', $user, PDO::PARAM_STR);
                $search_user_stmt->execute();
                if ($search_user_stmt->rowCount() > 0) {
                    echo "<script> 
                   alert('Lo sentimos, el nombre de usuario \"$user\" ya está en uso.')
                   window.location.href = './../view/createAccount.php';
                </script>";
                    exit();
                }

                $search_email_representative_query = "SELECT correo_electronico FROM representantes WHERE correo_electronico = :email ";
                $search_email_representative_stmt = $pdo->prepare($search_email_representative_query);
                $search_email_representative_stmt->bindParam('email', $representative_email, PDO::PARAM_STR);
                $search_email_representative_stmt->execute();
                if ($search_email_representative_stmt->rowCount() > 0) {
                    echo "<script> 
                        alert('Lo siento, el correo electrónico del representante del paciente \"$representative_email\" ya está en uso.')
                        window.location.href = './../view/createAccount.php';
                    </script>";
                    exit();
                }


                $pdo->beginTransaction();

                $hash = password_hash($password, PASSWORD_DEFAULT);
                $add_user_query = 'INSERT INTO usuarios (id_rol, usuario, clave, fecha_hora_creacion) VALUES (1, :user, :clave, NOW())';
                $add_user_stmt = $pdo->prepare($add_user_query);
                $add_user_stmt->bindParam('user', $user, PDO::PARAM_STR);
                $add_user_stmt->bindParam('clave', $hash, PDO::PARAM_STR);
                $add_user_stmt->execute();

                $id_user = $pdo->lastInsertId();
                $add_patient_query = 'INSERT INTO pacientes (id_genero, id_usuario, id_profesional, nombre, apellido, fecha_nacimiento )
                VALUES (:id_gender, :id_user , :id_professional, :name_patient, :lastname, :date_birth)';
                $add_patient_stmt = $pdo->prepare($add_patient_query);
                $add_patient_stmt->bindParam('id_gender', $id_gender, PDO::PARAM_INT);
                $add_patient_stmt->bindParam('id_user', $id_user, PDO::PARAM_INT);
                $add_patient_stmt->bindParam('id_professional', $id_professional, PDO::PARAM_INT);
                $add_patient_stmt->bindParam('name_patient', $name,  PDO::PARAM_STR);
                $add_patient_stmt->bindParam('lastname', $lastname, PDO::PARAM_STR);
                $add_patient_stmt->bindParam('date_birth', $date_birth, PDO::PARAM_STR);
                $add_patient_stmt->execute();

                $id_patient = $pdo->lastInsertId();

                $add_therapy_query = 'INSERT INTO terapias_lenguaje (id_paciente, ejercicios, duracion_cada_ejercicio, duracion_total, nota)
                VALUES (:id_paciente, :ejercicios, :duracion_cada_ejercicio, :duracion_total, :nota)';
                $add_therapy_stmt = $pdo->prepare($add_therapy_query);
                $add_therapy_stmt->bindParam('id_paciente', $id_patient, PDO::PARAM_INT);
                $add_therapy_stmt->bindParam('ejercicios', $input_therapys, PDO::PARAM_STR);
                $add_therapy_stmt->bindParam('duracion_cada_ejercicio', $duration_each_exercise, PDO::PARAM_STR);
                $add_therapy_stmt->bindParam('duracion_total', $session_duration, PDO::PARAM_STR);
                $add_therapy_stmt->bindParam('nota', $note, PDO::PARAM_STR);
                $add_therapy_stmt->execute();

                if (
                    $representative_name != "" || $representative_lastname != "" || $representative_email != ""
                    && $representative_phone_number != "" || $representative_secret_code != ""
                ) {
                    $add_representative_query = 'INSERT INTO representantes (id_paciente, nombre, apellido, correo_electronico, numero_telefonico, 
                    clave_secreta) VALUES (:id_paciente, :nombre, :apellido, :correo_electronico, :numero_telefonico, :codigo_secreto)';
                    $add_representative_stmt = $pdo->prepare($add_representative_query);
                    $add_representative_stmt->bindParam('id_paciente', $id_patient, PDO::PARAM_INT);
                    $add_representative_stmt->bindParam('nombre', $representative_name, PDO::PARAM_STR);
                    $add_representative_stmt->bindParam('apellido', $representative_lastname, PDO::PARAM_STR);
                    $add_representative_stmt->bindParam('correo_electronico', $representative_email, PDO::PARAM_STR);
                    $add_representative_stmt->bindParam('numero_telefonico', $representative_phone_number, PDO::PARAM_INT);
                    $hash_secrect_code = password_hash($representative_secret_code, PASSWORD_DEFAULT);
                    $add_representative_stmt->bindParam('codigo_secreto', $hash_secrect_code, PDO::PARAM_STR);
                    $add_representative_stmt->execute();
                }

                $add_patient_diagnosis_query = 'INSERT INTO pacientes_diagnostico (id_paciente, id_tipo_dislalia, fonemas, fecha_diagnostico, gravedad, observacion)
                VALUES (:id_paciente, :id_tipo_dislalia, :fonemas, NOW(), :gravedad, :observacion);';
                
                $add_patient_diagnosis_stmt = $pdo->prepare($add_patient_diagnosis_query);
                $add_patient_diagnosis_stmt->bindParam('id_paciente', $id_patient, PDO::PARAM_INT);
                $add_patient_diagnosis_stmt->bindParam('id_tipo_dislalia',  $dyslalia_type, PDO::PARAM_INT);
                $add_patient_diagnosis_stmt->bindParam('fonemas', $dyslalia_phonemes, PDO::PARAM_STR);
                $add_patient_diagnosis_stmt->bindParam('gravedad', $dyslalia_gravity, PDO::PARAM_STR);
                $add_patient_diagnosis_stmt->bindParam('observacion', $dyslalia_observations, PDO::PARAM_STR);
                $add_patient_diagnosis_stmt->execute();

                if (count($support_materials) != 0) {
                    foreach ($support_materials as $value) {
                        $add_support_material_query = 'INSERT INTO pacientes_materiales_apoyo (id_paciente, id_material_apoyo) VALUES (:id_paciente, :id_material_apoyo)';
                        $add_support_material_stmt = $pdo->prepare($add_support_material_query);
                        $add_support_material_stmt->bindParam('id_paciente', $id_patient, PDO::PARAM_INT);
                        $add_support_material_stmt->bindParam('id_material_apoyo', $value, PDO::PARAM_INT);
                        $add_support_material_stmt->execute();
                    }
                }

                $pdo->commit();

                break;
            case 'update';


                break;
            case 'delete';

                break;
            default:
                echo 'Que paso con el valor de state. :/';
                break;
        }
    }
} catch (PDOException $ex) {
    $pdo->rollBack();
    echo error_log($ex->getMessage());
    echo 'Oh no... Hay un error por parte de la base de datos: ' . $ex->getMessage();
}
