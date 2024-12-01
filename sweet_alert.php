<?php
function sweetAlert($title, $text, $icon, $redirect = null) {
    $redirectScript = $redirect ? ".then((result) => {
        if(result.isConfirmed) {
            window.location.href = '$redirect';
        }
    });" : ";";

    return "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>SweetAlert</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
    <script>
    Swal.fire({
        title: '$title',
        text: '$text',
        icon: '$icon'
    }) $redirectScript
    </script>
    </body>
    </html>
    ";
}
?>