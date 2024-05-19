@component('mail::message')
# Gracias por su compra

## Adjunto encontrará el documento: {{$subject}}.{{$format}} ##

<br>
Queda estrictamente prohibido:
<ul>
    <li>Revender el documento.</li>
    <li>Editar o alterar alguna parte del documento.</li>
    <li>Compartir el archivo en algún sitio web, red social o WhatsApp.</li>
    <li>Reproducir total o parcial este documento, bajo cualquiera de sus formas, electrónica u otras, sin la autorización por escrito de Material Didáctico MaCa. </li>
</ul>

<br>
<small>
    Todos nuestros documentos estan protegidos con derechos de autor y tienen un folio único. Material Didáctico MaCa se reserva la facultad de presentar las acciones civiles o penales que considere necesarias por la utilización indebida de los materiales adquiridos y sus contenidos.
</small>

<br>
<br>


@component('mail::panel')

<small>
    Si tiene alguna pregunta, no dude en contactarme. Solo da click en el logo de WhatsApp
</small>
<br>
<a href="https://wa.me/message/GUNXZZ666PN3I1" target="_blank">
    <img src="{{ asset('img/whatsapp.png') }}" alt="logo WhatsApp" width="60">
</a>

@endcomponent

Te invitamos a visitar nuestra nueva página web donde podrás encontrar material gratuito y nuestras novedades de apoyo para la enseñanza de los peques con actividades divertidas.👇🏼

<br>
<a href="https://materialdidacticomaca.com" target="_blank">Tienda en línea</a>

<br>
@endcomponent
