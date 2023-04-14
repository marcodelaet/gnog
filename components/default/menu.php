<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #2774AB;">
  <a class="navbar-brand" href="#">
    <picture>
      <img src="./assets/img/logo_crm.png" class="img-fluid img-thumbnail" style="margin-top:0.51rem;margin-bottom:0.51rem;margin-left:0.91rem;margin-right:0.91rem;"/>
    </picture>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
<?php
// show icons only when logged
if(array_key_exists('tk',$_COOKIE) && (array_key_exists('uuid',$_COOKIE)))
{
?>
    <ul class="navbar-nav">
      <li class="nav-item" id="nav-item-dashboard">
        <a class="nav-link" title="<?=translateText('dashboard');?>" href="?pr=<?=base64_encode('./pages/dashboard/index.php')?>">
          <div class="menu-option">
            <div class="menu-icon">
              <span class="material-icons-outlined" style="font-size:4rem;">dashboard</span>
            </div>
            <div class="menu-text">
            <?=translateText('dashboard');?>
            </div>
          </div>
        </a>
      </li>
      <li class="nav-item" id="nav-item-proposals">
        <a class="nav-link" title="<?=translateText('proposals');?>" href="?pr=<?=base64_encode('./pages/proposals/index.php')?>">
          <div class="menu-option">
            <div class="menu-icon">
              <span class="material-icons"  style="font-size:4rem;">price_check</span>
            </div>
            <div class="menu-text">
            <?=translateText('proposals');?>
            </div>
          </div>
        </a>
      </li>
      <li class="nav-item" id="nav-item-providers">
        <a class="nav-link" title="<?=translateText('providers');?>" href="?pr=<?=base64_encode('./pages/providers/index.php')?>">
          <div class="menu-option">
            <div class="menu-icon">
              <span class="material-icons"  style="font-size:4rem;">store</span>
            </div>
            <div class="menu-text">
            <?=translateText('providers');?>
            </div>
          </div>
        </a>
      </li>
      <li class="nav-item dropdown" id="nav-item-advertisers">
        <a class="nav-link" title="<?=translateText('advertisers');?>" href="?pr=<?=base64_encode('./pages/advertisers/index.php')?>">
          <div class="menu-option">
            <div class="menu-icon">
              <span class="material-icons"  style="font-size:4rem;">business</span>
            </div>
            <div class="menu-text">
            <?=translateText('advertisers');?>
            </div>
          </div>
        </a>
      </li>
      <li class="nav-item dropdown" id="nav-item-invoices">
        <a class="nav-link" title="<?=translateText('invoices');?>" href="?pr=<?=base64_encode('./pages/financial/invoices/index.php')?>">
          <div class="menu-option">
            <div class="menu-icon">
              <span class="material-icons"  style="font-size:4rem;">request_quote</span>
            </div>
            <div class="menu-text">
            <?=translateText('invoices');?>
            </div>
          </div>
        </a>
      </li>
      <li class="nav-item dropdown" id="nav-item-users">
        <a class="nav-link dropdown-toggle" title="<?=translateText('user_settings');?>" href="?pr=<?=base64_encode('./pages/users/index.php')?>" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <div class="menu-option">
            <div class="menu-icon">
              <span class="material-icons"  style="font-size:4rem;">settings</span>
            </div>
            <div class="menu-text">
            <?=translateText('user_settings');?>
            </div>
          </div>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" >
          <a class="dropdown-item" id="nav-item-billboards-list" title="List of <?=translateText('billboard');?>" href="?pr=<?=base64_encode('./pages/billboards/index.php')?>" >
            <div class="submenu-option">
              <div class="submenu-icon">
                <span class="material-icons"  style="font-size:4rem;">indeterminate_check_box</span>
              </div>
              <div class="submenu-text">
              <?=translateText('billboard');?>
              </div>
            </div> 
          </a>  
         <!-- <a class="dropdown-item" id="nav-item-billboards-list" title="List of <?=translateText('billboard');?>" href="?pr=<?=base64_encode('./pages/maps/index.php')?>&smid=a1ec69ae-cd6c-11ec-a3eb-008cfa5abdac&state=Colima" >
            <div class="submenu-option">
              <div class="submenu-icon">
                <span class="material-icons"  style="font-size:4rem;">map</span>
              </div>
              <div class="submenu-text"> Mapa
              
              </div>
            </div> 
          </a>  -->
          <a class="dropdown-item" id="nav-item-users-list" title="<?=translateText('users');?>" href="?pr=<?=base64_encode('./pages/users/index.php')?>" >
            <div class="submenu-option">
              <div class="submenu-icon">
                <span class="material-icons"  style="font-size:4rem;">people</span>
              </div>
              <div class="submenu-text">
              <?=translateText('users');?>
              </div>
            </div> 
          </a>
          <a class="dropdown-item" title="<?=translateText('logout');?>" href="?pr=<?=base64_encode('./pages/users/logout/index.php')?>">
            <div class="submenu-option">
              <div class="submenu-icon">
                <span class="material-icons"  style="font-size:4rem;">logout</span><br/>
              </div>
              <div class="submenu-text">
              <?=translateText('logout');?>
              </div>
            </div>
          </a>
        </div>
      </li>
    </ul>
<?php } ?>
  </div>

  <a class="navbar-brand" target="_blank" href="https://gnogmedia.com/">
    <picture>
      <img src="./assets/img/logo_gnog_media_y_tecnologia.svg" class="img-fluid img-thumbnail" style="background-color:#FFF; margin-top:0.51rem;margin-bottom:0.51rem;margin-left:0.91rem;margin-right:0.91rem;"/>
    </picture>
  </a>
</nav>
<?php    //echo base64_encode('./pages/financial/invoices/info.php')?>