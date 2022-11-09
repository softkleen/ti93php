<?php 
function geraCoeficienteParcela(float $taxa, int $periodo=1): float
{
    return pow((1+($taxa/100)),$periodo)/ $periodo;
}
function atrasoIntervalo($minutos)
{
   return $minutos>20?'Atrasado!':'Ok'; //if ternário
}
function validaMatricula(DateTime $data)
{
    $diff = $data->diff(new DateTime());
    $anos = $diff->format('%y');

    if ($anos < 6) {
        return 'o garoto(a) não pode ser matric.';
    }else{
        return 'pode matricular o rebento!';
    }
}

//echo validaMatricula(new DateTime('2010-6-23'));




?>