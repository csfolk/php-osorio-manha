<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Calculadora</title>

    <link rel="stylesheet" href="styles.css">

    <?php

    session_start();

    $nmr1 = 0;
    $nmr2 = 0;
    $resultado = 0;
    $calcular = 0;

    function fatoracao($num)
    {
        $fatores = array();
        for ($i = 2; $i <= $num; $i++) {
            while ($num % $i == 0) {
                $fatores[] = $i;
                $num /= $i;
            }
        }
        return $fatores;
    }

    if (!isset($_SESSION['historico'])) {
        $_SESSION['historico'] = array();
    }

    if (!isset($_SESSION['memoria'])) {
        $_SESSION['memoria'] = array('nmr1' => 0, 'nmr2' => 0, 'calcular' => 'somar');
    }

    if (isset($_GET['nmr1'], $_GET['nmr2'], $_GET['calcular'])) {
        $nmr1 = $_GET['nmr1'];
        $nmr2 = $_GET['nmr2'];
        $calcular = $_GET['calcular'];

        switch ($calcular) {
            case 'somar':
                $resultado = $nmr1 + $nmr2;
                break;
            case 'subtrair':
                $resultado = $nmr1 - $nmr2;
                break;
            case 'multiplicar':
                $resultado = $nmr1 * $nmr2;
                break;
            case 'dividir':
                $resultado = $nmr1 / $nmr2;
                break;
            case 'fatorar':
                $resultado = fatoracao($nmr1);
                break;
            case 'potencia':
                $resultado = pow($nmr1, $nmr2);
                break;
        }

        $_SESSION['historico'][] = array(
            'nmr1' => $nmr1,
            'nmr2' => $nmr2,
            'calcular' => $calcular,
            'resultado' => $resultado
        );
    }

    if (isset($_GET['limpar_historico'])) {
        $_SESSION['historico'] = array();
    }

    if (isset($_GET['memoria'])) {
        $_SESSION['memoria'] = array('nmr1' => $nmr1, 'nmr2' => $nmr2, 'calcular' => $calcular);
    }

    ?>



</head>

<body>
    <form class="">
        <div class="cabecalho">
            <h1>Calculadora</h1>
        </div>
        Primeiro número
        <input type="input" class="form-control" style="width:10%" required name="nmr1" value=<?php echo $nmr1; ?> /> 
        Segundo número
        <input type="input" class="form-control" style="width:10%" required name="nmr2" value=<?php echo $nmr2; ?> /> <br /> <br>

        <select name="calcular" class="form-select form-select-lg mb-3" style="width:10%" >
            <option value="somar" <?php echo ($calcular == 'somar') ? 'selected' : ''; ?>>Somar</option>
            <option value="subtrair" <?php echo ($calcular == 'subtrair') ? 'selected' : ''; ?>>Subtrair</option>
            <option value="multiplicar" <?php echo ($calcular == 'multiplicar') ? 'selected' : ''; ?>>Multiplicar
            </option>
            <option value="dividir" <?php echo ($calcular == 'dividir') ? 'selected' : ''; ?>>Dividir</option>
            <option value="fatorar" <?php echo ($calcular == 'fatorar') ? 'selected' : ''; ?>>Fatorar</option>
            <option value="potencia" <?php echo ($calcular == 'potencia') ? 'selected' : ''; ?>>Potência</option>
        </select>
        <br /><br />
        <input type="submit" class="btn btn-primary" value="calcular" />

        <input type="submit" class="btn btn-danger" name="limpar_historico" value="Limpar Histórico" />

        <input type="submit" class="btn btn-warning" name="memoria" value="M" />



    </form>


    <h2>Histórico</h2>
    <table class="table">
        <tr>
            <th class="table-dark">Número 1</th>
            <th class="table-dark">Número 2</th>
            <th class="table-dark">Operação</th>
            <th class="table-dark">Resultado</th>
        </tr>
        <?php foreach ($_SESSION['historico'] as $operacao) : ?>
        <tr>
            <td class="table-success"><?php echo $operacao['nmr1']; ?></td>
            <td class="table-danger"><?php echo $operacao['nmr2']; ?></td>
            <td class="table-warning"><?php echo $operacao['calcular']; ?></td>
            <td class="table-info"><?php echo is_array($operacao['resultado']) ? implode(', ', $operacao['resultado']) : $operacao['resultado']; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>