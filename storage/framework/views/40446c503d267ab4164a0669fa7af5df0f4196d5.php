<?php $__env->startSection('script_css'); ?>

    <link rel="stylesheet" href="<?php echo e(asset('/plugins/iCheck/all.css')); ?>">
     <link rel="stylesheet" href="<?php echo e(asset('/plugins/toastr/toastr.css')); ?>">
     <meta name="csrf_token" content="<?php echo e(csrf_token()); ?>">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
   <style>  
 .swal2-popup {
  font-size: 1.6rem !important;
}

    table, th, td {
            border: 0.5px solid black;
        }

        
    .sectiontitle {
      background-position: center;
      margin: 30px 0 0px;
      text-align: center;
      min-height: 20px;
    }

    .sectiontitle h2 {
      font-size: 40px;
      color: #545454;
      margin-bottom: 0px;
      padding-right: 10px;
      padding-left: 10px;
    }
    
  .control__indicator {
        position: absolute;
        top: 2px;
        left: 0;
        height: 20px;
        width: 20px;
        background: #e6e6e6;
}


    .headerLine {
      width: 160px;
      height: 2px;
      display: inline-block;
      background: #101F2E;
    }
      .number {
      background-position: center;
      
      text-align: center;
      font-size: 50px;
    }
     .t {
      background-position: center;
      
      text-align: center;
      font-size: 18px;
    }

    


.projectFactsWrap{
    display: flex;
  margin-top: 30px;
  flex-direction: row;
  flex-wrap: wrap;
    color :  #565656;
}




.projectFactsWrap .item{
  width: 20%;
  height: 100%;
  padding: 20px 0px;
  text-align: center;
    color :  #565656;
}

.projectFactsWrap .item:nth-child(1){
  background: #e1e6ef;
  position: relative;
  top: -40px;
  left: 100px;
}

.projectFactsWrap .item:nth-child(2){
  background: #e1e6ef;
 
  position: relative;
  top: -40px;
  left: 200px;
 

}

.projectFactsWrap .item:nth-child(3){
  background: #e1e6ef;
  position: relative;
  top: -40px;
  left: 300px;

}



.projectFactsWrap .item p.number{
  font-size: 40px;
  padding: 0;
  font-weight: bold;
  color: #000000;
}

.projectFactsWrap .item p{
  color: rgba(255, 255, 255, 0.8);
  font-size: 18px;
  margin: 0;
  padding: 5px;
  font-family: 'Open Sans';
  color :  #565656;
}


.projectFactsWrap .item span{
  width: 40px;
  height: 1px;
  display: block;
  margin: 0 auto;
    background :  #565656;

}


.projectFactsWrap .item i{
  vertical-align: middle;
  font-size: 25px;
  
    color :  #565656;
}


.projectFactsWrap .item:hover i, .projectFactsWrap .item:hover p{
  color :  #565656;
}

.projectFactsWrap .item:hover span{
  color :  #565656;
}


table {
  border: 2px solid #ccc;
  border-collapse: collapse;
  margin: 0;
  padding: 0;
  width: 100%;
  table-layout: fixed;
}



table tr {
  background-color: #f8f8f8;
  border: 1px solid #ddd;
  padding: .35em;
}

table th,
table td {
  padding: .625em;
  text-align: center;
}

table th {
  font-size: .85em;
  letter-spacing: .1em;
  text-transform: uppercase;
}

@media  screen and (max-width: 600px) {
  table {
    border: 0;
  }

  table caption {
    font-size: 1.3em;
  }
  
  table thead {
    border: none;
    clip: rect(0 0 0 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
  }
  
  table tr {
    border-bottom: 3px solid #ddd;
    display: block;
    margin-bottom: .625em;
  }
  
  table td {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: .8em;
    text-align: right;
  }

  
  
  table td::before {
    /*
    * aria-label has no advantage, it won't be read inside a table
    content: attr(aria-label);
    */
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: uppercase;
  }
  
  table td:last-child {
    border-bottom: 0;
  }


    </style>


    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="row">
                    <div class="col-sm-12 ">

          <!-- jQuery Knob -->
          <button type="button" class="btn  btn-primary">Modifier</button>
          <button type="button" class="btn btn-default" onclick="deleteLigne(<?php echo e($protocole->id); ?>)">Supprimer</button>
          <button type="button" onclick="javascript:history.back();" class="btn  btn-secondary">Retour</button>
          <div class="clearfix" style="float: right; width: 35%">
                <div class="breadcrumb" >
                     <b><img src="<?php echo e(asset('/images/741.png')); ?>" style="width: 3%"> Protocole créer par <?php echo e(DB::table('users')->where('id',$protocole->user_id)->pluck('name')->first()); ?> le <?php echo e($protocole->created_at); ?></b>                   
                 </div>           
              </div>
              
          <div class="box box-solid">
            <div class="box-header">
                <div class="sectiontitle">
                <h2><?php echo e($protocole->nom); ?></h2>
                <span class="headerLine"></span>
            </div> <br>
            
                 
  <div class="col-sm-1"> </div>
<div class="col-sm-11">
    <div class="fullWidth eight columns">
        <div class="projectFactsWrap ">
            <div class="item wow fadeInUpBig animated animated" data-number="12" style="visibility: visible;">
               
                <p id="number1" class="number"><?php echo e($protocole->nbr_sequence); ?></p>
                <span></span>
                <p>Séquences</p>
            </div>
            
            <div class="item wow fadeInUpBig animated "style="visibility: visible;">

                <p id="number3" class="number"><?php echo e($protocole->nbrcure_min); ?>-<?php echo e($protocole->nbrcure_max); ?></p>
                <span></span> 
                <p>Cures</p>
            </div>
            <div class="item wow fadeInUpBig animated animated" data-number="246" style="visibility: visible;">
               
                <p id="number4" class="number"><?php echo e($protocole->intervalle_cure); ?> j</p>
                <span></span>
                <p>Repos</p>
            </div>
        </div>
    </div>
</div>

<div class="panel-body">
                  <?php if($protocole->remarque != null): ?>
                    <p class="text-muted" style="font-weight : bolder; color: green;"><?php echo e($protocole->remarque); ?></p>
                  <?php endif; ?>
                    
                      <table>
                      <thead>
                        <tr>
                        <th style="width: 10%">Etape</th>
                        <th style="width: 30%">Médicaments</th>
                        <th style="width: 20%">Voies</th>
                        <th style="width: 10%">Posologie</th>
                         <?php $__currentLoopData = $sequence; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <th>j <?php echo e($s->jour); ?></th>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tr>
                      </thead>
                      <tbody>
                       <?php if($premedicament->isNotEmpty()): ?>
                     
                        <?php $__currentLoopData = $premedicament; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                         <tr id="prem<?php echo e($key); ?>" onmouseover="colorr(<?php echo e($key); ?>)" onmouseout="noncolorr(<?php echo e($key); ?>)" onclick="affiche('<?php echo e($p->solvant); ?>','<?php echo e($p->commentaire); ?>')" style="cursor: pointer;">
                          <?php if($loop->first): ?>
                            <td id="none" rowspan="<?php echo e($premedicament->count()); ?>">Prémidication</td>
                          <?php endif; ?>
                            <td><?php echo e(DB::table('sp_specialite')->where('SP_CODE_SQ_PK',$p->sp_id)->pluck('SP_NOM')->first()); ?></td>
                            <td><?php echo e($p->voie); ?></td>
                            <td><b><?php echo e($p->posologie); ?> </b><?php echo e($p->u1); ?> / <?php echo e($p->u2); ?></td>
                            <?php $tmp = collect(); ?>
                            <?php $__currentLoopData = $collection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <?php if($p->sp_id == $cc->sp_id): ?>   
                                <?php $__currentLoopData = $sequence; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <?php if($cc->sequencetype_id == $s->id): ?>
                                    <?php
                                     //sauvgarder jour sequence
                                     //break;               
                                      $tmp->put($s->id,$s->jour);
                                      break;
                                    ?>                     
                                  <?php endif; ?> 
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              <?php endif; ?> 
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $sequence; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <?php 
                              //if s->jour == [] cheker 
                              //else non
                                if ($tmp->contains($s->jour)) { ?>
                                  <td>
                                   <img src="<?php echo e(asset('/images/741.png')); ?>" style="width: 10%">                               
                                  </td>
                                <?php } 
                                else{ ?>
                                 <td>
                                  <img src="<?php echo e(asset('/images/85.png')); ?>" style="width: 10%">
                                  </td>
                               <?php } ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                     
                           </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     
                        <?php endif; ?> 
                        
                          <?php if($traitement->isNotEmpty()): ?>
                        <?php $__currentLoopData = $traitement; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <tr id="prem<?php echo e($key); ?>" onmouseover="colortrait(<?php echo e($key); ?>)" onmouseout="noncolortrait(<?php echo e($key); ?>)" style="cursor: pointer;" style="cursor: pointer;" onclick="affiche('<?php echo e($t->solvant); ?>','<?php echo e($t->commentaire); ?>')">
                          <?php if($loop->first): ?>
                            <td id="nonetrait" rowspan="<?php echo e($traitement->count()); ?>">Traitement</td>
                          <?php endif; ?>
                            <td><?php echo e(DB::table('sp_specialite')->where('SP_CODE_SQ_PK',$t->sp_id)->pluck('SP_NOM')->first()); ?></td>
                            <td><?php echo e($t->voie); ?></td>
                            <td><b><?php echo e($t->posologie); ?> </b><?php echo e($t->u1); ?> / <?php echo e($t->u2); ?> / <?php echo e($t->u3); ?></td>
                            <?php $tmp = collect(); ?>
                            <?php $__currentLoopData = $collection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <?php if($t->sp_id == $cc->sp_id): ?>   
                                <?php $__currentLoopData = $sequence; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <?php if($cc->sequencetype_id == $s->id): ?>
                                    <?php
                                     //sauvgarder jour sequence
                                     //break;               
                                      $tmp->put($s->id,$s->jour);
                                      break;
                                    ?>                     
                                  <?php endif; ?> 
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              <?php endif; ?> 
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $sequence; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <?php 
                              //if s->jour == [] cheker 
                              //else non
                                if ($tmp->contains($s->jour)) { ?>
                                  <td>
                                    <img src="<?php echo e(asset('/images/741.png')); ?>" style="width: 10%">                           
                                  </td>
                                <?php } 
                                else{ ?>
                                 <td>
                                  <img src="<?php echo e(asset('/images/85.png')); ?>" style="width: 10%">
                                  </td>
                               <?php } ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                     
                           </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?> 
                      </tbody>
                      </table>
                </div>
              </div></div></div></div>
            </section>
        </div>
            <!-- /.box-body -->
            <!-- modal info-->
<div class="modal fade" id="modal-info">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">DÉTAIL</h4>
              </div>           
              <div class="modal-body">
                <div class="box-body">
                  <div class="col-sm-12">
                          <label class=" control-label" >Solvant</label>
                               <textarea name="" id="solvant" class="col-xs-12 col-md-12" disabled></textarea> <br><br>
                               <br><br><label class=" control-label" >Commentaire</label>
                               <textarea name="" id="commentaire" class="col-xs-12 col-md-12" disabled></textarea>
                          </div>
                  </div>
              </div>
              
              <div class="modal-footer">
                 <input id="b" type="submit" class="btn btn-primary" data-dismiss="modal" value="Quiter">
              </div>      
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>  
           
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script src="<?php echo e(asset('plugins/sweetAlert/sweetalert.js')); ?>"></script>

<script type="text/javascript">
  function colorr(id){

    document.getElementById("prem"+id).style.backgroundColor = "lightblue";
    document.getElementById("none").style.backgroundColor = "lightblue";
  }
  function noncolorr(id){
    document.getElementById("prem"+id).style.backgroundColor = "";
    document.getElementById("none").style.backgroundColor = "";
  }
  function colortrait(id){
     document.getElementById("prem"+id).style.backgroundColor = "lightblue";
    document.getElementById("nonetrait").style.backgroundColor = "lightblue";
  }
  function noncolortrait(id){
    document.getElementById("prem"+id).style.backgroundColor = "";
    document.getElementById("nonetrait").style.backgroundColor = "";
  }
  function affiche(solvant,commentaire){
    //alert(commentaire);
    var myModal = $('#modal-info');
    document.getElementById('solvant').value = solvant; 
    document.getElementById('commentaire').value=commentaire; 
    myModal.modal({ show: true });

  }
  //delete protocole
  function deleteLigne(id){
Swal.fire({
    backdrop: `
    rgba(255,0,0,0.4)
  `,
  title: 'Êtes-vous sûr?',
  text: "Vous ne pourrez pas revenir en arrière!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#d33',
  cancelButtonColor: '#3085d6',
  confirmButtonText: 'Oui, supprimez-le!',
  cancelButtonText:'Annuler'

}).then((result) => {
  if (result.value) {
        $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "/chimio/protocole/"+id,
                method : "POST",              
                success: function(data){                  
                  Swal.fire({
                    title:'Supprimé!',
                    text:'Le protocole a été supprimé..',
                    type:'success',
                     onClose :function () {
                         location.href = '<?php echo e((route('listProtocole'))); ?>';
                      }
                  }                   
                  )           
                },
                error: function(data){
                    Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: 'Quelque chose a mal tourné!'
                    })
                  }
              }); 
  }
})
  }
  
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\chimio\detailProtocole.blade.php ENDPATH**/ ?>