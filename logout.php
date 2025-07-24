<?php
session_start();
session_destroy();
echo "<script>
    if (confirm('Vous etes sur de vouloir vous deconnecter?')) {
        window.location.href = 'index.html';
    } else {
        window.location.href = 'acceuil.html';
    }
</script>";
exit();
