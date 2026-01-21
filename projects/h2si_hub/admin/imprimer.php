<?php
require('fpdf/fpdf.php');
include("connexion.php");

class PDF extends FPDF
{
    // En-tête
    function Header()
    {
        // Police Arial gras 15
        $this->SetFont('Arial', 'B', 15);
        // Titre
        $this->Cell(0, 10, utf8_decode('Liste des étudiants'), 0, 1, 'C');
        // Saut de ligne
        $this->Ln(10);

        // En-tête du tableau
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(10, 10, 'N', 1);
        $this->Cell(40, 10, utf8_decode('Nom et Prénom'), 1);
        $this->Cell(62, 10, 'Email', 1);
        $this->Cell(25, 10,utf8_decode('Téléphone') , 1);
        $this->Cell(50, 10, 'Formation', 1);
        $this->Cell(35, 10, 'Statut', 1);
        $this->Ln();
    }

    // Pied de page
    function Footer()
    {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial', 'I', 8);
        // Numéro de page
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Tableau des étudiants
    function LoadData($con)
    {
        $select = $con->prepare("SELECT * FROM t_etudiant");
        $select->execute();
        return $select->fetchAll(PDO::FETCH_ASSOC);
    }

    function StudentTable($data)
    {
        $this->SetFont('Arial', '', 10);
        foreach ($data as $row) {
            $this->Cell(10, 10, utf8_decode($row['id']), 1);
            $this->Cell(40, 10, utf8_decode($row['nom_et'] . ' ' . $row['prenom_et']), 1);
            $this->Cell(62, 10, utf8_decode($row['mail_et']), 1);
            $this->Cell(25, 10, utf8_decode('0' . $row['tel_et']), 1);
            $this->Cell(50, 10, utf8_decode($row['nom_form']), 1);
            $this->Cell(35, 10, utf8_decode($row['statut']), 1);

        
            $this->Ln();
        }
    }
}

$pdf = new PDF();
$pdf->SetLeftMargin(2);
$pdf->AliasNbPages();
$pdf->AddPage();
$data = $pdf->LoadData($con);
$pdf->StudentTable($data);
$pdf->Output();
?>
