<script type="text/javascript">
<?php 
    if(array_key_exists('pr',$_GET)){ 
        if($_GET['pr'] != 'Li9wYWdlcy91c2Vycy9sb2dpbi9pbmRleC5waHA='){?>
            authenticatedToken      = localStorage.getItem('tokenGNOG');
            authenticatedUserID     = localStorage.getItem('uuid');
            if(!authenticatedToken || !authenticatedUserID)
                window.location.href = '?pr=Li9wYWdlcy91c2Vycy9sb2dpbi9pbmRleC5waHA=';
<?php       if(!array_key_exists('uuid',$_COOKIE)){ ?>
                window.location.href = '?pr=Li9wYWdlcy91c2Vycy9sb2dpbi9pbmRleC5waHA=';
<?php       }
        } elseif($_GET['pr'] == 'Li9wYWdlcy91c2Vycy9wcm9maWxlL2Zvcm1lZGl0LnBocA=='){
            if(!array_key_exists('tid',$_GET)){?>
                window.location.href = '?pr=Li9wYWdlcy91c2Vycy9sb2dpbi9pbmRleC5waHA=';
<?php
            }
        }
        ?>

<?php
    }else{?>
        window.location.href = '?pr=Li9wYWdlcy91c2Vycy9sb2dpbi9pbmRleC5waHA=';
<?php 
    }
?>
</script>