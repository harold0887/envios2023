<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Mail\EnvioMaterial;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\TryCatch;
use setasign\Fpdi\Fpdi; // Like this

class AddLicense
{
    public  $order, $product, $licencia, $message;


    public function __construct(Product $product, Order $order)
    {

        $this->product = $product;
        $this->order = $order;
        $this->message = "Documento con derechos de autor. © Material didáctico MaCa. Queda prohibida su reventa";
        $this->licencia = $order->folio . "- licencia de uso personal para " . $order->email;
    }

    public function sendDocumento()
    {
        if ($this->product->format == 'pdf' && $this->product->folio == 1) {

            //Agregar folio a PDF solo de los materiales con folio
            $pdf = new Fpdi();


            set_time_limit(0);
            $patch = "./storage/" . substr($this->product->document, 6, 300);
            //$pdf->setSourceFile($patch);
            $pageCount = $pdf->setSourceFile($patch);
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($templateId);
                $pdf->AddPage($size['orientation']);
                $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
                $pdf->SetFont('Arial', 'i', 8);
                $pdf->SetTextColor(181, 178, 178);
                $pdf->SetXY(2, 0);
                $pdf->Write(8, utf8_decode($this->message));
                $pdf->SetXY(2, 4);
                $pdf->Write(8, utf8_decode($this->licencia));
            }

            $pdf->Output('pdf/newpdf.pdf', 'F');

            set_time_limit(0);
            $correo = new EnvioMaterial($this->product);
            Mail::to($this->order->email)->send($correo);

            return true;
        } else {
            set_time_limit(0);
            $correo = new EnvioMaterial($this->product);
            Mail::to($this->order->email)->send($correo);
            return true;
        }
    }


    public function download()
    {


        //Agregar folio a PDF
        $pdf = new Fpdi();
        set_time_limit(0);
        $patch = "./storage/" . substr($this->product->document, 6, 300);
        //$pdf->setSourceFile($patch);
        $pageCount = $pdf->setSourceFile($patch);
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            $pdf->AddPage($size['orientation']);
            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
            $pdf->SetFont('Arial', 'i', 8);
            $pdf->SetTextColor(181, 178, 178);
            $pdf->SetXY(2, 0);
            $pdf->Write(8, utf8_decode($this->message));
            $pdf->SetXY(2, 4);
            $pdf->Write(8, utf8_decode($this->licencia));
        }
        $pdf->Output('pdf/newpdf.pdf', 'F');

        return true;
    }
}
