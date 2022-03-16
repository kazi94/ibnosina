<?php $__env->startSection('script_css'); ?>

    <link rel="stylesheet" href="<?php echo e(asset('plugins/iCheck/all.css')); ?>">
     <link rel="stylesheet" href="<?php echo e(asset('plugins/toastr/toastr.css')); ?>">
     <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
      <style>  
        .modal-dialog{
  width:70%;
}
        .form-lol {
  background: #288CF0;
  background: #FFF;
  border: 2px solid #545454;
  padding: 25px;
  margin-bottom: 40px;
  margin: 2rem auto;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);

  position: relative;
}

.form-label {
  position: absolute;
  top: 0;
  left: 3rem;
  background: #FFF;
  padding: 0.5rem 1rem;
  margin: 0;
  transform: translateY(-50%);
  color: #545454;
}
             .isa_info {
    color: #00529B;
    background-color: #BDE5F8;
    padding: 0.9em;
    text-align: center;
}
td {
    
    padding: 2px;
}
input[name=vv] {
    width: 100%;
    height: 50px;
    text-align: right;
    font-family: monospace;
    font-size: 3em;
    font-weight: bold;
    border-color: gray;
    border-width: 1px;
    border-style: solid;
    opacity: 1;
}
input[name=vv]:hover {
    opacity: 0.5;
}
.h{
    background-color: #f5f5f5;
    background-image: linear-gradient(top, #f5f5f5, #f1f1f1);
    border: 1px solid #dedede;
    color: #444;
    height: 45px;
    width: 65px;
    text-align: center;
    font-size: 1.2em;
    font-weight: normal;
}
input[name=v]:hover {
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
    background-image: linear-gradient(top, #f8f8f8, #f1f1f1);
    
    border: 1px solid #c6c6c6;
    color: #222;
    cursor: pointer;
}

input[name=operator] {
    border: 1px solid #c6c6c6;
    background-color: #d6d6d6;
}
    .swal2-popup {
  font-size: 1.6rem !important;
}
    .sectiontitle {
      background-position: center;

      text-align: center;
      min-height: 20px;
    }

    .sectiontitle h2 {
      font-weight: bold;
      font-size: 25px;
      color: #000000;
      margin-bottom: 0px;
      padding-right: 10px;
      padding-left: 10px;
    }
     
    /* Required CSS. That's 7 declarations. */
.tabbed-content {
  overflow: hidden;
}
.tabbed-content .tabs {
  
  transition: transform .2s;
  display: flex;
  position: relative;
}
.tabbed-content .tabs .tab {
  flex: 0 0 auto;
  width: 100%;
}

/* Some example tab styling */
.tab {
  
  box-sizing: border-box;
  padding: 2em;
  
}

/* Styling of controls. This is all optional. */
.tab-control-wrap {
  text-align: center;
}

.tab-control {
  list-style: none;
  display: inline-block;
  margin: 20px auto;
  padding: 0;
  border-bottom: 2px solid #ddd;
}
.tab-control li {
  display: inline-block;
  margin-left: 20px;
  position: relative;
  top: 2px;

}
.tab-control li:first-child {
  margin-left: 0;
}
.tab-control li a {
  display: block;
  padding: 1em;
  text-transform: uppercase;
  font-family: sans-serif;
  text-decoration: none;
  color: #c5c5c5;
  transition: all .1s;
  border-bottom: 2px solid transparent;
}
.tab-control li.active a {
  color: #2A3E42;
  border-color: #333;
}
 

    </style>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
 <div class="row">
                    <div class="col-sm-12 ">

    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="row">
                    <div class="col-sm-12 ">
          <div class="box box-solid">
            <div class="box-header">
                <div class="sectiontitle">
                  <h2>PARAMÉTRER LA CHIMIOTHÉRAPIE</h2>
                  <h4>sous titre</h4>
                  
                </div>
           
            
 
    <div class="tabbed-content">
  <div class="tab-control-wrap">
    <ul class="tab-control">
      <li><a href="#tab-1">Formule SC</a></li>
      <li><a href="#tab-2">unité protocole</a></li>
      <li><a href="#tab-3">ligne DCI</a></li>
      <li><a href="">lister les protocoles</a></li>
      <li><a href="<?php echo e((route('listMaladie.index'))); ?>">lister les maladies</a></li>
    </ul>
  </div>
  <div class="tabs">
    <div class="tab" id="tab-1" style="">
      <div class="col-sm-12">
        
       <form action="<?php echo e(route('activerFormule')); ?>" method="post" id="lk">
                      <?php echo e(csrf_field()); ?>

                      <input type="hidden" name="pp" id="pp" value="rien">
       <div class="form-group" style=" width: 40%;position: relative; left: 30%;">
               <label class=" control-label">Veuillez sélectionner une formule: </label>
               <input type="button" class="  btn-success btn-xs btn" value="Activer la formule" id="activer">
              <input type="button" class="  btn-danger btn-xs btn" value="Supprimer" id="supp">
              <select class="form form-control" name="formule" id="formule" >  
                <?php $__currentLoopData = $formules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($formule_utilise != null && $formule_utilise->id == $f->id): ?>
                    <option selected style="background-color: #c2f8ac" value="<?php echo e($f->id); ?>"><?php echo e($f->formule); ?></option>
                  <?php else: ?>
                    <option value="<?php echo e($f->id); ?>"><?php echo e($f->formule); ?></option>
                  <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select><br>
              
            
            </div>
            

            
          
          </form>
<form action="<?php echo e(route('addFormule')); ?>" method="post" id="kk">
                      <?php echo e(csrf_field()); ?>

            
            <table style="margin: 0 auto;width: 100px;">
            <tr>
                <td colspan="11">
                    <input type="text" name="vv" id="gg" value=""  />
                </td>
            </tr>
            <tr>
                <td>
                    <input id="btnAns" type="button"  class="h" name="operator" value="CE" onclick="ecrire('ce')" />
                </td>
                <td>
                    <input id="btnPi" type="button" class="h"  name="operator" value="(" onclick="ecrire('(')" />
                </td>
                <td>
                    <input id="btnE" type="button" class="h"  name="operator" value=")" onclick="ecrire(')')" />
                </td>
                <td>
                    <input id="btnCE" type="button"  class="h" name="operator" value="." onclick="ecrire('.')" />
                </td>
                <td>
                    <input id="btnOParen" type="button"  class="h" name="operator" value="+" onclick="ecrire('+')" />
                </td>
                <td>
                    <input id="btnCParen" type="button" class="h"  name="operator" value="-" onclick="ecrire('-')" />
                </td>
                <td>
                    <input id="btnPcnt" type="button" class="h"  name="operator" value="x" onclick="ecrire('*')"/>
                </td>
                <td>
                    <input id="btnCE" type="button" class="h"  name="operator" value="/" onclick="ecrire('/')" />
                </td>
                <td>
                    <input id="btnCE" type="button"  class="h" name="operator" value="%" onclick="ecrire('%')" />
                </td>
                <td>
                    <input id="btnCE" type="button"  class="h" name="operator" value="^" onclick="ecrire('^')" />
                </td>
                <td>
                    <input id="btnCE" type="button"  class="h" name="v" value="TAILLE" onclick="ecrire('TAILLE')" />
                </td>
                


            </tr>
            <tr>
               <td>
                    <input id="btn7" type="button" class="h" name="v" value="0" onclick="ecrire('0')" />
                </td><td>
                    <input id="btn7" type="button"  class="h" name="v" value="1" onclick="ecrire('1')" />
                </td><td>
                    <input id="btn7" type="button"  class="h" name="v" value="2" onclick="ecrire('2')" />
                </td><td>
                    <input id="btn7" type="button" class="h"  name="v" value="3" onclick="ecrire('3')" />
                </td><td>
                    <input id="btn7" type="button"  class="h" name="v" value="4" onclick="ecrire('4')" />
                </td><td>
                    <input id="btn7" type="button" class="h"  name="v" value="5" onclick="ecrire('5')" />
                </td><td>
                    <input id="btn7" type="button" class="h"  name="v" value="6" onclick="ecrire('6')" />
                </td>
                <td>
                    <input id="btn7" type="button" class="h"  name="v" value="7" onclick="ecrire('7')" />
                </td>
                <td>
                    <input id="btn8" type="button" class="h"  name="v" value="8" onclick="ecrire('8')" />
                </td>
                <td>
                    <input id="btn9" type="button" class="h"  name="v" value="9" onclick="ecrire('9')" />
                </td>
                 <td>
                    <input id="btnCE" type="button"  class="h" name="v" value="POIDS" onclick="ecrire('POIDS')" />
                </td>
                
            </tr>
           
            
        </table><br> 
        <div class="form-group" style="text-align:center">
      
       <label class="control-label">Activer la formule</label>&nbsp;
        <input type="checkbox" name="confirmed" id=""/>&nbsp;&nbsp;
     <input type="button" class=" btn-primary btn" value="Ajouter la formule" id="addFormule">
     </div>
   </form>
         

  

      </div>
    </div>
    <div class="tab" id="tab-2">
     
     <div class="col-sm-3"></div>
        <div class="col-sm-6">
                    <div class="card" >
                        <div class="header">
                             <form action="<?php echo e(route('addunite')); ?>" method="post" id="unite">
                                        <?php echo e(csrf_field()); ?>

                              <input type="text" class="form-control" name="unite_in" placeholder="Intitule unite" style="width: 40%;float: left">&nbsp;&nbsp;
                             &nbsp; <input type="text"  class="form-control" name="unite" placeholder="Symbole" style="width: 40%;float: left">
                              <input type="button" class=" btn-primary btn" value="Ajouter" id="addUnite">
                                      </form><br>
                            
                        </div>
                        <?php if($unites->isEmpty()): ?>
                        <div class="isa_info" style="width: 80%; text-align: center;position: relative; left: 10%">
                          <h4><i class="fa fa-info-circle"></i> Aucune unité dci chimiothérapie trouvé veuillez ajouter une</h4>                        
                      </div>
                        <?php else: ?>
                        <div class="body table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 10%">Intitule unite</th>
                                        <th style="width: 5%">Symbole</th>
                                        <th style="width: 2%">Supprimer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $unites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <th scope="row"><?php echo e($u->id); ?></th>
                                        <td><?php echo e($u->intitule); ?></td>
                                        <td><?php echo e($u->unite); ?></td>
                                        <td><span class="glyphicon glyphicon-trash" style="color: red; cursor: pointer" onclick="deleteLigne(<?php echo e($u->id); ?>)"></span></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
    </div>
    <div class="tab" id="tab-3">
      <button type="button" class="btn btn btn-primary" data-toggle="modal" data-target="#modal-edit">
                Ajouter une maladie
              </button>
        
      <div class="box-body table-responsive no-padding">
                            <table id="t_protocole" class="table table-responsive text-center dataTable table table-hover" aria-describedby="t_protocole">
                                <thead>
                                    <tr class="alert alert-info">
                                        <th style="width: 5%">#</th>
                                        <th style="width: 20%">NOM DU MÉDICAMENT</th>
                                        <th style="width: 10%">VOLUME MÉDI</th>
                                        <th style="width: 20%">S.RECONSTITUTION</th>
                                        <th style="width: 20%">S.DILUTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $para; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                     <tr>
                                        <th><?php echo e($p->id); ?></th>
                                        <td><?php echo e(DB::table('sp_specialite')->where('SP_CODE_SQ_PK',$p->medicament_id)->pluck('SP_NOM')->first()); ?></td> 
                                        <td><?php echo e($p->volume_medi); ?> ML</td>
                                        <td><?php echo e($p->solvant_recon); ?></td>
                                        <td><?php echo e($p->solvant_dilu); ?>

                                           <a href=""style="color:black;float: right">
                                                <span class="glyphicon glyphicon-eye-open"></span>
                                            </a> 

                                        </td>
                                     </tr>
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                                
                                    
                                 </tbody>
                            </table>
                        </div>



    </div>
  </div>
</div>

   




</div>




</div>
</div>

            


       </div>
          </div>
            </section>
        </div>
      </div>

            <!-- /.box-body -->

            <div class="modal fade" id="modal-edit">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Mode opératoire</h4>
              </div>
             
              <div class="modal-body">   
                <form action="<?php echo e(route('addpara')); ?>" method="post">
                            <?php echo e(csrf_field()); ?>

                <div class="box-body">
                  
                  <div class="col-sm-12">
                  <div class="col-sm-6">
                     <div class="lol">
                    <div class="form-lol front">
                   <h3 class="form-label"><strong> Détail </strong></h3><br>
                    <label class="control-label">Médicament DCI ou médicament commerciale</label>
                    <input type="text" class="form-control"  placeholder="Nom du produit" name="dci_nom" id="dci_nom" required>
                    <br><label class="col-sm-12 control-label">Solvant Reconstitution</label>
                                <textarea id="" name="sol_r" class="col-xs-12 col-md-12" placeholder="Ecrivez quelque chose a propos du Traitement"  ></textarea>

                                <br><label class="col-sm-12 control-label">Solvant Dilution</label> 
                                <textarea id="" name="sol_d" class="col-xs-12 col-md-12" placeholder="Ecrivez quelque chose a propos du Traitement"  ></textarea><br>

                     <label class="control-label">Volume Médicament(ml)</label>
                          <input type="number" step="0.01" class="form-control"  placeholder="Volume Médicament en ml" name="volume_medi" id="volume_medi" required>
                                <br>
                  </div>
                    </div>
           </div>
                  <div class="col-sm-6">
                    <div class="lol">
                    <div class="form-lol front">
                   <h3 class="form-label"><strong> Etapes de préparation </strong></h3><br>
                                <label class="col-sm-12 control-label">Etape 1 :</label> 
                                <textarea id="" name="e1" class="col-xs-12 col-md-12" placeholder="Ecrivez quelque chose a propos du Traitement"  ></textarea>

                                <br> <label class="col-sm-12 control-label">Etape 2 :</label> 
                                <textarea id="" name="e2" class="col-xs-12 col-md-12" placeholder="Ecrivez quelque chose a propos du Traitement"  ></textarea>

                                <br> <label class="col-sm-12 control-label">Etape 3 :</label> 
                                <textarea id="" name="e3" class="col-xs-12 col-md-12" placeholder="Ecrivez quelque chose a propos du Traitement"  ></textarea>

                               <br> <label class="col-sm-12 control-label">Etape 4 :</label> 
                                <textarea id="" name="e4" class="col-xs-12 col-md-12" placeholder="Ecrivez quelque chose a propos du Traitement"  ></textarea><br><br><br><br><br><br>
                                <br><br><br><br><br><br>
                  </div>
                
           
           </div>
         </div></div>

              </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Annuler</button>
                 <input id="b" type="submit" class="btn btn-primary" value="Sauvegarder">
              </div>
              </form>
     </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        

                
               
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script src="<?php echo e(asset('plugins/sweetAlert/sweetalert.js')); ?>"></script>

<?php if(session('tt')): ?>
      <script type="text/javascript">
               
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

      Toast.fire({
        type: 'success',
        title: '<?php echo e(session('tt')); ?>'
      })
      </script>
    <?php endif; ?>
<script type="text/javascript">
  
   $('input[id="dci_nom"]').keydown(function() { 
        $(this).autocomplete({
          appendTo: $(this).parent(), // selectionner l'element pour ajouter la liste des suggestion
          source: function( request, response ) {
              $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                url: "/medicament",
                method : "POST",
                data: {
                  phrase: request.term // value on field input
                },
                success: function( data , status , code ) {
                    response($.map(data.slice(0, 20), function (item) { // slice cut number of element to show
                      dosage = "";
                      if (item.status == "médicament") {//pour afficher le status du medicament sp en couleur
                        style ="style='color:red;'";
                      } else { // status : substance active
                        //dosage = item.dosage+""+item.unite;
                        style = "style='color: green;'";
                      } 
                      status = "<i "+style+">"+item.status+"</i>";

                      return {
                          label : item.medicament+" "+dosage+" "+status, // pour afficher dans la liste des suggestions
                          sac_id: item.sac_code_sq_pk,
                          dosage: item.dosage,
                          unite:  item.unite, 
                          sp_id:  item.sp_code_sq_pk,
                          value:  item.medicament+" "+dosage // value c la valeur à mettre dans l'input this
                      };

                  }));
                }
              });
            },// END SOURCE
            


          }).data("ui-autocomplete")._renderItem = function (ul, item) {//cette method permet de gérer l'affichage de la liste des suggestions
               

                 return $("<li></li>")
                     .data("item.autocomplete", item)//récupérer les donnée de l'autocomplete
                     //.attr( "data-value", item.id )
                     .append( item.label)//ajouter à la liste de suggestions
                     .appendTo(ul); 
                 };

      });
  //data table
      $(function () {
            $('#t_protocole').DataTable();
            if ($("#message").text()) {
                    toastr.options = {
                      "closeButton": false,
                      "debug": false,
                      "newestOnTop": false,
                      "progressBar": false,
                      "positionClass": "toast-bottom-center",
                      "preventDuplicates": false,
                      "onclick": null,
                      "showDuration": "300",
                      "hideDuration": "1000",
                      "timeOut": "3000",
                      "extendedTimeOut": "1000",
                      "showEasing": "swing",
                      "hideEasing": "linear",
                      "showMethod": "fadeIn",
                      "hideMethod": "fadeOut"
                    }
                    toastr.success($("#message").text())    
            }

          })

  $.fn.flexTabs = function() {
  return this.each(function() {
    var current = 0;
    var $controls = $(this).find('.tab-control');
    var $tabs = $(this).find('.tabs');
    function updateState() {
      $controls.children().removeClass('active');
      $controls.children().eq(current).addClass('active');
      var offset = $tabs.children().eq(current).position().left;
      $tabs.css({'transform': 'translateX(-' + offset + 'px)'})
    }
    updateState();
    $(window).resize(updateState);
    $controls.find('a').click(function(e){
      e.preventDefault();
      var href = $(this).attr('href');
      window.history.pushState({}, '', href);
      var $targetTab = $(href);
      if ($targetTab.length)
        current = $targetTab.index();
      else
        current = $(this).parent().index();
      updateState();
    });
  }); 
};

$(function(){
  $('.tabbed-content').flexTabs();
});

//ecrire
function ecrire(nn){
  if (nn =='ce') {
    document.getElementById('gg').value = '';
  }else
  document.getElementById('gg').value =document.getElementById('gg').value +''+nn;

}
//activer formule
$("#activer").click(function () {
  event.preventDefault();
  $this = $("#lk");
    Swal.fire({
  title: 'Confirmation!',
  text: "Voulez vous activer la formule ?",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#008000',
  cancelButtonColor: '#3085d6',
  confirmButtonText: 'Oui, activer!',
  cancelButtonText:'Annuler'

}).then((result) => {
  if (result.value) {
        $.ajax({
                url: $this.attr('action'),
              method: $this.attr('method'),
              data: $this.serialize(),
              datatype :'json' ,              
                success: function(data){ 
                               
                  Swal.fire({
                    title:'Activer!',
                    text:'La formule a été bien activer',
                    type:'success',
                     onClose :function () {
                        location.href = '<?php echo e((route('para'))); ?>';
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
  });

//supp formule
$("#supp").click(function () {
  
  event.preventDefault();
  $this = $("#lk");
    Swal.fire({
  title: 'Êtes-vous sûr?',
  text: "Vous ne pourrez pas revenir en arrière!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#d33',
  cancelButtonColor: '#3085d6',
  confirmButtonText: 'Oui, Ajouter!',
  cancelButtonText:'Annuler'

}).then((result) => {
  if (result.value) {
    document.getElementById('pp').value = '';
        $.ajax({
                url: $this.attr('action'),
              method: $this.attr('method'),
              data: $this.serialize(),
              datatype :'json' ,              
                success: function(data){          
                  Swal.fire({
                    title:'Supprimé!',
                    text:'La formule a été supprimé..',
                    type:'success',
                     onClose :function () {
                        location.href = '<?php echo e((route('para'))); ?>';
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
  });
//add formule
$("#addFormule").click(function () {
  event.preventDefault();
  $this = $("#kk");
    Swal.fire({
  title: 'Confirmation!',
  text: "Voulez vous ajouter la formule ?",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#008000',
  cancelButtonColor: '#3085d6',
  confirmButtonText: 'Oui, ajouter!',
  cancelButtonText:'Annuler'

}).then((result) => {
  if (result.value) {
        $.ajax({
                url: $this.attr('action'),
              method: $this.attr('method'),
              data: $this.serialize(),
              datatype :'json' ,              
                success: function(data){ 
                               
                  Swal.fire({
                    title:'Ajouter!',
                    text:'La formule a été bien ajouter',
                    type:'success',
                     onClose :function () {
                        location.href = '<?php echo e((route('para'))); ?>';
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
  });


//add unite
$("#addUnite").click(function () {
  event.preventDefault();
  $this = $("#unite");
    Swal.fire({
  title: 'Confirmation!',
  text: "Voulez vous ajouter l'unité' ?",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#008000',
  cancelButtonColor: '#3085d6',
  confirmButtonText: 'Oui, ajouter!',
  cancelButtonText:'Annuler'

}).then((result) => {
  if (result.value) {
        $.ajax({
              url: $this.attr('action'),
              method: $this.attr('method'),
              data: $this.serialize(),
              datatype :'json' ,              
              success: function(data){       
                  Swal.fire({
                    title:'Ajouter!',
                    text:'L unité a été bien ajouter',
                    type:'success',
                    onClose :function () {
                        location.href = '<?php echo e((route('para'))); ?>';
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
  });
//delete unite
function deleteLigne(id){
  Swal.fire({
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
                      url: "/chimio/deleteunite/"+id,
                      method : "post",              
                      success: function(data){                  
                        Swal.fire({
                          title:'Supprimé!',
                          text:'L unité a été supprimé..',
                          type:'success',
                          onClose :function (){
                              location.href = '<?php echo e((route('para'))); ?>';
                            }
                        }                   
                        )           
                      },
                      error: function(data){
                          Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Quelque chose a mal tourné!',
                          })
                        }
                    }); 
        }
      })

}
</script>

 




<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\chimio\parametres.blade.php ENDPATH**/ ?>