<?php $__env->startSection('meta_robot'); ?> index,follow <?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?> <?php echo e($result['medicament']); ?> | HIC MEDIC <?php $__env->stopSection(); ?>
<?php $__env->startSection('description'); ?> <?php echo e($result['medicament']); ?> (<?php echo e($result['dci']); ?>) : fiche médicament  précisant la composition, la posologie, les indications <?php $__env->stopSection(); ?>
<?php $__env->startSection('og_title'); ?> <?php echo e($result['medicament']); ?> | HIC MEDIC <?php $__env->stopSection(); ?>
<?php $__env->startSection('og_description'); ?> <?php echo e($result['medicament']); ?> (<?php echo e($result['dci']); ?>) : fiche médicament  précisant la composition, la posologie, les indications <?php $__env->stopSection(); ?>
<?php $__env->startSection('url'); ?> <?php echo e(url()->current()); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('fb_meta'); ?>
      <meta property="fb:app_id" content="100800794638454">
      <meta property="fb:pages" content="100800794638454">  
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <div class="row">
      
    <div class="col-sm-12 col-md-12 mt-1">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background-color: white">
          <li class="breadcrumb-item"><a href="<?php echo e(route('medicaments.noms-commerciale')); ?>"><i class="fas fa-capsules"></i> Médicaments</a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo e($result['medicament']); ?> </li>
        </ol>
      </nav>
        <button   title="Signaler un problème" type="button" class="btn btn-link btn-report" data-toggle="modal" data-target="#bug_report" ><i class="fa fa-bug"></i> Signaler !</button>
        
    </div>

    <div class="col-sm-12 col-md-6">
      <h3><?php echo e($result['medicament']); ?> <span class="badge badge-danger">SP</span></h3>
      <?php echo (isset($result['dci']) && !empty($result['dci']) ) ? '<p class="h6">' . $result['dci'] . ' <span class="badge badge-pill badge-success">DCI</span> </p>' : '';; ?>

      <?php echo (!empty($result['cph']) ) ? '<p class="h6">' . $result['cph'] . ' <span class="badge badge-pill badge-warning">Classe</span> </p>' : '';; ?>

      
    </div>

    <div class="bhoechie-tab-container col-md-11 col-sm-12 ml-md-3">
      
      <div class="a2a_kit a2a_kit_size_32 a2a_default_style" style="line-height: 32px; position: absolute; right: 0; top: -38px; /* float: right; */ z-index: 9999; padding-top: 2px;">
        <!-- AddToAny BEGIN -->
        <a class="a2a_dd a2a_dd1" href="https://www.addtoany.com/share" style="float: right;"></a>
        <a class="a2a_button_facebook"></a>
        <a class="a2a_button_twitter"></a>
        <a class="a2a_button_google_gmail"></a>
        <a class="a2a_button_whatsapp"></a>
        <a class="a2a_button_print"></a>
        <a class="a2a_button_outlook_com"></a>
        <a class="a2a_button_yahoo_mail"></a>
        <script>
        var a2a_config = a2a_config || {};
        a2a_config.onclick = 1;
        a2a_config.locale = "fr";
        </script>
        <script async src="https://static.addtoany.com/menu/page.js"></script>
        <!-- AddToAny END -->    
      </div> 

      <div class="row d-none d-md-flex justify-content-center">
        <div class="bhoechie-tab-menu col-md-3 col-sm-12">
          <div class="list-group">
            <a href="#" class="list-group-item text-center active" >
              <h4 class="fas fa-arrow-alt-circle-right fa-2x "></h4><br/>Indications
            </a>
            <a href="#" class="list-group-item text-center">
              <h4 class="fas fa-clock fa-2x "></h4><br/>Posologie/Administration
            </a>
            <a href="#" class="list-group-item text-center">
              <h4 class="fas fa-thermometer-three-quarters fa-2x  "></h4><br/>Contre Indication
            </a>
            <a href="#" class="list-group-item text-center">
              <h4 class="fas fa-thermometer-quarter fa-2x  "></h4><br/>Effets indésirables
            </a>
                                                           
          </div>
        </div>
        <div class="col-sm-9 bhoechie-tab">
            <!-- flight section -->
            <div class="bhoechie-tab-content active">
                <center>
                  <h1 class=" -plane" style="font-size:14em;color:#EC790C"></h1>
                  <h2 style="margin-top: 0;color:#EC790C">Indications</h2>
                  <br>
                </center>
                <h3 style="color:#EC790C"> Types de maladies</h3>
                <table class="table table-sm table-striped">
                  <?php $__currentLoopData = $result['indications']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                      <td> <?php echo e($indic->cdf_nom); ?> </td>
                    </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>
            </div>
            <!-- train section -->
            <div class="bhoechie-tab-content">
                <center>
                  <h1 class=" -road" style="font-size:12em;color:#EC790C"></h1>
                  <h2 style="margin-top: 0;color:#EC790C">Posologie(s)</h2>
                  <br>
                  
                </center>
                <table class="table table-borderless table-sm table-striped">
                  <?php $__currentLoopData = $result['posologies']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $poso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><b>Protocole posologique N°<?php echo e($key+1); ?></b></td>
                        <td></td>
                    </tr>
                    <tr>
                      <?php if($poso->terrains): ?>
                        <td>Cas Physiopathologique</td>
                        <?php $terrains = explode(',' , $poso->terrains); ?>
                          <td>
                            <?php $__currentLoopData = $terrains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $terrain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <?php echo e($terrain); ?> <br/>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </td>
                      <?php endif; ?>
                    </tr>
                      <tr>
                        <?php if($poso->indications): ?>
                          <td>Indication</td>
                          <?php $indications = explode(',' , $poso->indications); ?>
                            <td>
                              <?php $__currentLoopData = $indications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indication): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo e($indication); ?> <br/>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                        <?php endif; ?>

                      </tr>

                        <?php if($poso->dose): ?>
                      <tr>
                          <td>Dose <?php echo e($poso->type); ?></td>
                          <td><?php echo e($poso->dose); ?></td>
                      </tr>
                        <?php endif; ?>

                        <?php if($poso->frequence || $poso->cdf_comment_freq): ?>
                      <tr>
                          <td>Fréquence <?php echo e($poso->type); ?></td>
                          <td>
                            <?php echo e($poso->frequence); ?>

                            <?php echo html_entity_decode($poso->cdf_comment_freq); ?>

                          </td>
                      </tr>
                        <?php endif; ?>

                        <?php if($poso->duree || $poso->cdf_comment_duree): ?>
                      <tr>
                          <td>Durée du traitement</td>
                          <td>
                            <?php echo e($poso->duree); ?>

                            <br/>
                            <?php echo html_entity_decode($poso->cdf_comment_duree); ?>

                          </td>
                      </tr>
                        <?php endif; ?>                            
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>
                <br>
            </div>

            <!-- hotel search -->
            <div class="bhoechie-tab-content">
                <center>
                  <h1 class=" -home" style="font-size:12em;color:#EC790C"></h1>
                  <h2 style="margin-top: 0;color:#EC790C">Contres Indications</h2>
                  <br>
                  
                </center>
                <table class="table table-sm table-striped">
                  <?php $__currentLoopData = $result['cis']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $ci): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                      <td><?php if($key == '0'): ?> <b>Cas Physiopathologique:</b> <?php endif; ?></td>
                      <td><?php if($key != '0'): ?> <?php echo e($ci->terrain); ?> <?php endif; ?></td>
                    </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>                     
            </div>
            <div class="bhoechie-tab-content">
                <center>
                  <h1 class=" -cutlery" style="font-size:12em;color:#EC790C"></h1>
                  <h2 style="margin-top: 0;color:#EC790C">Effets indésirables</h2>
                  <br>
                  
                </center>

                <table class="table table-sm table-striped">
                  <?php $__currentLoopData = $result['effets']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $effet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                      <td> <?php echo e($effet->effet); ?> </td>
                    </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>
                     
            </div>
        </div>                
      </div>

    </div>
<div class="col-12 d-md-none bg-light">
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="indications-tab" data-toggle="tab" href="#indications" role="tab" aria-controls="indications" aria-selected="true">Indications</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="posologie-tab" data-toggle="tab" href="#posologie" role="tab" aria-controls="posologie" aria-selected="false">Posologie/Administration</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="ci-tab" data-toggle="tab" href="#ci" role="tab" aria-controls="ci" aria-selected="false">Contre indication</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="effets-tab" data-toggle="tab" href="#effets" role="tab" aria-controls="effets" aria-selected="false">Effets indésirables</a>
    </li>  
  </ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="indications" role="tabpanel" aria-labelledby="indications-tab">
                <center>
                  <h1 class=" -plane" style="font-size:14em;color:#EC790C"></h1>
                  <h2 style="margin-top: 0;color:#EC790C">Indications</h2>
                  <br>
                </center>
                <h3 style="color:#EC790C"> Types de maladies</h3>
                <table class="table table-sm table-striped">
                  <?php $__currentLoopData = $result['indications']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                      <td> <?php echo e($indic->cdf_nom); ?> </td>
                    </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>
  </div>
  <div class="tab-pane fade" id="posologie" role="tabpanel" aria-labelledby="posologie-tab">
    
                    <center>
                  <h1 class=" -road" style="font-size:12em;color:#EC790C"></h1>
                  <h2 style="margin-top: 0;color:#EC790C">Posologie(s)</h2>
                  <br>
                  
                </center>
                <table class="table table-borderless table-sm table-striped">
                  <?php $__currentLoopData = $result['posologies']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $poso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><b>Protocole posologique N°<?php echo e($key+1); ?></b></td>
                        <td></td>
                    </tr>
                    <tr>
                      <?php if($poso->terrains): ?>
                        <td>Cas Physiopathologique</td>
                        <?php $terrains = explode(',' , $poso->terrains); ?>
                          <td>
                            <?php $__currentLoopData = $terrains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $terrain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <?php echo e($terrain); ?> <br/>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </td>
                      <?php endif; ?>
                    </tr>
                      <tr>
                        <?php if($poso->indications): ?>
                          <td>Indication</td>
                          <?php $indications = explode(',' , $poso->indications); ?>
                            <td>
                              <?php $__currentLoopData = $indications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indication): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo e($indication); ?> <br/>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                        <?php endif; ?>

                      </tr>

                        <?php if($poso->dose): ?>
                      <tr>
                          <td>Dose <?php echo e($poso->type); ?></td>
                          <td><?php echo e($poso->dose); ?></td>
                      </tr>
                        <?php endif; ?>

                        <?php if($poso->frequence || $poso->cdf_comment_freq): ?>
                      <tr>
                          <td>Fréquence <?php echo e($poso->type); ?></td>
                          <td>
                            <?php echo e($poso->frequence); ?>

                            <?php echo html_entity_decode($poso->cdf_comment_freq); ?>

                          </td>
                      </tr>
                        <?php endif; ?>

                        <?php if($poso->duree || $poso->cdf_comment_duree): ?>
                      <tr>
                          <td>Durée du traitement</td>
                          <td>
                            <?php echo e($poso->duree); ?>

                            <br/>
                            <?php echo html_entity_decode($poso->cdf_comment_duree); ?>

                          </td>
                      </tr>
                        <?php endif; ?>                            
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>
                <br>
  </div>
  <div class="tab-pane fade" id="ci" role="tabpanel" aria-labelledby="ci-tab">
                    <center>
                  <h1 class=" -home" style="font-size:12em;color:#EC790C"></h1>
                  <h2 style="margin-top: 0;color:#EC790C">Contres Indications</h2>
                  <br>
                  
                </center>
                <table class="table table-sm table-striped">
                  <?php $__currentLoopData = $result['cis']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $ci): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                      <td><?php if($key == '0'): ?> <b>Cas Physiopathologique:</b> <?php endif; ?></td>
                      <td><?php if($key != '0'): ?> <?php echo e($ci->terrain); ?> <?php endif; ?></td>
                    </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>   
  </div>
  <div class="tab-pane fade" id="effets" role="tabpanel" aria-labelledby="effets-tab">
    
                        <center>
                  <h1 class=" -road" style="font-size:12em;color:#EC790C"></h1>
                  <h2 style="margin-top: 0;color:#EC790C">Posologie(s)</h2>
                  <br>
                  
                </center>
                <table class="table table-borderless table-sm table-striped">
                  <?php $__currentLoopData = $result['posologies']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $poso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><b>Protocole posologique N°<?php echo e($key+1); ?></b></td>
                        <td></td>
                    </tr>
                    <tr>
                      <?php if($poso->terrains): ?>
                        <td>Cas Physiopathologique</td>
                        <?php $terrains = explode(',' , $poso->terrains); ?>
                          <td>
                            <?php $__currentLoopData = $terrains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $terrain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <?php echo e($terrain); ?> <br/>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </td>
                      <?php endif; ?>
                    </tr>
                      <tr>
                        <?php if($poso->indications): ?>
                          <td>Indication</td>
                          <?php $indications = explode(',' , $poso->indications); ?>
                            <td>
                              <?php $__currentLoopData = $indications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indication): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo e($indication); ?> <br/>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                        <?php endif; ?>

                      </tr>

                        <?php if($poso->dose): ?>
                      <tr>
                          <td>Dose <?php echo e($poso->type); ?></td>
                          <td><?php echo e($poso->dose); ?></td>
                      </tr>
                        <?php endif; ?>

                        <?php if($poso->frequence || $poso->cdf_comment_freq): ?>
                      <tr>
                          <td>Fréquence <?php echo e($poso->type); ?></td>
                          <td>
                            <?php echo e($poso->frequence); ?>

                            <?php echo html_entity_decode($poso->cdf_comment_freq); ?>

                          </td>
                      </tr>
                        <?php endif; ?>

                        <?php if($poso->duree || $poso->cdf_comment_duree): ?>
                      <tr>
                          <td>Durée du traitement</td>
                          <td>
                            <?php echo e($poso->duree); ?>

                            <br/>
                            <?php echo html_entity_decode($poso->cdf_comment_duree); ?>

                          </td>
                      </tr>
                        <?php endif; ?>                            
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>
  </div>
</div>
</div>

  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js_scripts'); ?>

<script>
$(document).ready(function() {
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
});    
</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('bddm.layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\bddm\monographie.blade.php ENDPATH**/ ?>