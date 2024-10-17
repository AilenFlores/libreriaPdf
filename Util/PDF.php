<?php
 date_default_timezone_set('America/Argentina/Buenos_Aires'); // Establecer la zona horaria predeterminada

class PDF extends FPDF {

    // Crea Formulario de comprobante de autos
    public function generarComprobante($persona, $autos) {
        $this->AddPage();  // Agregar una página al PDF
        $this->agregarEncabezado();
        $this->agregarDatosPersona($persona);
        $this->agregarDatosEmpresa();
        $this->agregarSeccionAutos();
        $this->agregarTablaAutos($autos);
        $this->agregarMensajeFinal();
        return $this->mostrarPDF();
    }

    // Encabezado del PDF
    private function agregarEncabezado() {
        $this->SetTitle('Comprobante Autos Persona'); //  el título del PDF
        $this->SetFont('Arial', 'B', 16); //  la fuente, el estilo y el tamaño de la fuente
        $this->SetTextColor(32, 100, 210); //  el color del texto (RGB) 
        $this->Cell(150, 10, "Certificado Autos Persona", 0, 0, 'L'); // ancho, alta, texto, borde, salto de línea, alineación
        $this->Ln(9); // Salto de línea en milimetros
        $this->Image('../../img/auto.jpg', 120, 12, 70, 70, 'jpg'); //nombre, posicion horizontal, vertical, ancho, altura, tipo.
    }

    // Datos de la persona
    private function agregarDatosPersona($persona) {
        if ($persona) { 
            $this->SetFont('Arial', '', 10);
            $this->SetTextColor(39, 39, 51);
            $this->Cell(150, 9, 'Nombre: ' . $persona["nombre"], 0, 0, 'L');
            $this->Ln(5);
            $this->Cell(150, 9, 'Apellido: ' . $persona["apellido"], 0, 0, 'L');
            $this->Ln(5);
            $this->Cell(150, 9, 'DNI: ' . $persona["nroDni"], 0, 0, 'L');
            $this->Ln(5);
            $this->Cell(150, 9, 'Fecha de nacimiento: ' . $persona["fechaNac"], 0, 0, 'L');
            $this->Ln(5);
            $this->Cell(150, 9, iconv("UTF-8", "ISO-8859-1", 'Teléfono: ' . $persona["telefono"]), 0, 0, 'L');
            $this->Ln(5);
            $this->Cell(150, 9, 'Domicilio: ' . $persona["domicilio"], 0, 0, 'L');
            $this->Ln(10);
        } else {
            // Handle case where persona is null
            $this->Cell(150, 9, 'No se encontraron datos de la persona.', 0, 0, 'L');
        }
    }


    // Datos de la empresa
    private function agregarDatosEmpresa() {
        $this->SetFont('Arial', '', 10);
        $this->Cell(30, 7, iconv("UTF-8", "ISO-8859-1", "Fecha de emisión:"), 0, 0);
        $this->SetTextColor(97, 97, 97);
        $this->Cell(116, 7, iconv("UTF-8", "ISO-8859-1", date("d/m/Y H:i A")), 0, 0, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(39, 39, 51);
        $this->Ln(7);
        $this->SetTextColor(39, 39, 51);
        $this->Cell(6, 7, iconv("UTF-8", "ISO-8859-1", "Dirección:"), 0, 0);
        $this->Ln(5);
        $this->SetTextColor(97, 97, 97);
        $this->Cell(109, 7, iconv("UTF-8", "ISO-8859-1", "Neuquén Capital, Neuquén, Argentina"), 0, 0);
        $this->Ln(9);
    }

    // Sección de autos asociados
    private function agregarSeccionAutos() {
        $this->SetFont('Arial', 'B', 15);
        $this->SetTextColor(32, 100, 210);
        $this->Cell(0, 10, "Autos Asociados", 0, 1, 'C'); // Centrado
        $this->Ln(5);
    }

    // Tabla de autos
    private function agregarTablaAutos($autos) {
        $this->SetFont('Arial', '', 12);
        $this->SetFillColor(23, 83, 201); // 
        $this->SetDrawColor(23, 83, 201); //
        $this->SetTextColor(255, 255, 255);

        $this->Cell(80, 10, "Patente", 1, 0, 'C', true);
        $this->Cell(60, 10, "Marca", 1, 0, 'C', true);
        $this->Cell(40, 10, "Modelo", 1, 0, 'C', true);
        $this->Ln(8);

        $this->SetTextColor(39, 39, 51);
        if (!empty($autos)) {
            foreach ($autos as $auto) {
                $this->Cell(80, 10, $auto["patente"], 1, 0, 'C');
                $this->Cell(60, 10, $auto["marca"], 1, 0, 'C');
                $this->Cell(40, 10, $auto["modelo"], 1, 0, 'C');
                $this->Ln(10);
            }
        } else {
            $this->SetFont('Arial', 'I', 12);
            $this->SetTextColor(255, 0, 0);
            $this->Cell(0, 10, 'No hay autos asociados a esta persona.', 0, 1, 'C');
        }
    }

    // Mensaje final
    private function agregarMensajeFinal() {
        $this->Ln(10);
        $this->SetFont('Arial', 'I', 10);
        $this->SetTextColor(97, 97, 97);
        $this->Cell(0, 10, 'Este documento es un comprobante generado automaticamente.', 0, 1, 'C');
        $this->Cell(0, 10, 'pagina '.$this->PageNo(), 0, 0, 'C');
    }


    private function mostrarPDF() {
        // Enviar el archivo PDF al navegador (Inline)
        $this->Output('I', 'doc.pdf'); // 'I' muestra el PDF en el navegador con el nombre correcto
    }
    
    

   /////////////////////////////////////////////////////////////////Crea un registro de todas las personas
    public function generarRegistro($arrayFinal) {
        $this->AddPage('ladscape');  // Agregar una página al PDF
        $this->agregarEncabezadoRegistro();
        $this->agregarDatosPersonas($arrayFinal);
        $this->agregarDatosEmpresaRegistro();
        $this->agregarMensajeFinal();
        return $this->mostrarPDF();
    }
//Crea el encabezado del registro
    private function agregarEncabezadoRegistro() {
        $this->SetTitle('Registro Personas'); // Establecer el título del PDF
        $this->SetFont('Times', 'B', 30); // Establece la fuente, el estilo y el tamaño de la fuente
        $this->SetTextColor(32, 100, 210); // Establecer el color del texto (RGB)
        $this->Cell(150, 10, strtoupper("Registro de Personas"), 0, 0, 'L'); // Agregar un texto a la celda
        $this->Ln(9); // Salto de línea
        $this->Image('../../img/personaLogo.png', 220, 3, 70, 30, 'png'); // Agregar una imagen al PDF
        }

    // Datos de la empresa en el registro
    private function agregarDatosEmpresaRegistro() {
        $this->Ln(15);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(30, 7, iconv("UTF-8", "ISO-8859-1", "Fecha de emisión:"), 0, 0);
        $this->SetTextColor(97, 97, 97);
        $this->Ln(5);
        $this->Cell(116, 7, iconv("UTF-8", "ISO-8859-1", date("d/m/Y H:i A")), 0, 0, 'L');
        $this->SetFont('Times', 'B', 12);
        $this->SetTextColor(39, 39, 51);
        $this->Ln(7);
        $this->SetTextColor(39, 39, 51);
        $this->Cell(6, 7, iconv("UTF-8", "ISO-8859-1", "Dirección:"), 0, 0);
        $this->Ln(5);
        $this->SetTextColor(97, 97, 97);
        $this->Cell(109, 7, iconv("UTF-8", "ISO-8859-1", "Neuquén Capital, Neuquén, Argentina"), 0, 0);
        $this->Ln(9);
    }
//Crea la planilla de todas las personas
    private function agregarDatosPersonas($arrayFinal) {
        $this->Ln(8);
        $this->SetFont('Times', 'B', 12);
        $this->SetFillColor(23, 83, 201);
        $this->SetDrawColor(23, 83, 201);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(30, 10, "DNI", 1, 0, 'C', true);
        $this->Cell(45, 10, "Nombre", 1, 0, 'C', true);
        $this->Cell(40, 10, "Apellido", 1, 0, 'C', true);
        $this->Cell(37, 10, "Fecha Nacimiento", 1, 0, 'C', true);
        $this->Cell(30, 10, "Telefono", 1, 0, 'C', true);
        $this->Cell(65, 10, "Domicilio", 1, 0, 'C', true);
        $this->Cell(30, 10, "Cant.Autos", 1, 0, 'C', true);
        $this->Ln(0.2);
        foreach ($arrayFinal as $persona) {
            // Datos de la persona
            $this->Ln(10);
            $this->SetFont('Times', '', 12);
            $this->SetTextColor(0, 0, 0);
            $this->SetFillColor(172, 216, 230);
            $this->Cell(30, 10, $persona["nroDni"], 1, 0, 'C', true);
            $this->Cell(45, 10, $persona["nombre"], 1, 0, 'C');
            $this->Cell(40, 10, $persona["apellido"], 1, 0, 'C');
            $this->Cell(37, 10, $persona["fechaNac"], 1, 0, 'C');
            $this->Cell(30, 10, $persona["telefono"], 1, 0, 'C');
            $this->Cell(65, 10, $persona["domicilio"], 1, 0, 'C');
            $this->Cell(30, 10, $persona["autos"], 1, 0, 'C');
        }
    }
}
