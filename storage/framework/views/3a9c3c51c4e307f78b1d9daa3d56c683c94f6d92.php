<div id="" class="row d-md-flex justify-content-center   <?php if(isset($result['mono'])): ?> d-none <?php endif; ?>"
    style="background: linear-gradient(to right bottom, rgb(3, 76, 147), rgb(236, 117, 0));">
    <div class="bg-white col-sm-7 p-3 shadow m-3">
        <h1 style="text-align: center">Recherche médicament</h1>
        <div class="input-group mb-3 no-gutters">
            <div class="input-group-prepend col-xs-12 col-sm-3 ">
                <select id="type_search" class="custom-select ">
                    <option value="meds" selected>Médicament</option>
                    <option value="sac">Substance Active</option>
                    
                </select>
            </div>
            <input id="med_search" style='min-width:0px' class="form-control"
                placeholder="Entrer le nom commercial d'un médicament">
            
        </div>

        <ul class="nav nav-pills justify-content-center">
            <div class="sport-item">
                <a href="<?php echo e(route('medicaments.noms-commerciale')); ?>" style="text-decoration:none">
                    <div class="img-wrapper">
                        <img class="js-img-lazy js-img-lazy-loaded" src="<?php echo e(asset('bddm/images/icon-3.png')); ?>" alt=""
                            style="width:80px;height:80px" data-lazy-fade="1000">
                    </div>
                    <div class="sports-label">MEDICAMENTS</div>
                </a>
            </div>
            <div class="sport-item">
                <a href="<?php echo e(route('medicaments.substances')); ?>" style="text-decoration:none">
                    <div class="img-wrapper">
                        <img class="js-img-lazy js-img-lazy-loaded" src="<?php echo e(asset('bddm/images/icon-1.png')); ?>" alt=""
                            style="width:80px;height:80px" data-lazy-fade="1000">
                    </div>
                    <div class="sports-label">SUBSTANCES</div>
                </a>
            </div>
            
            <div class="sport-item">
                <a href="<?php echo e(route('medicaments.indications')); ?>" style="text-decoration:none">
                    <div class="img-wrapper">
                        <img class="js-img-lazy js-img-lazy-loaded" src="<?php echo e(asset('bddm/images/icon-4.png')); ?>" alt=""
                            style="width:80px;height:80px" data-lazy-fade="1000">
                    </div>
                    <div class="sports-label">INDICATIONS</div>
                </a>
            </div>
        </ul>
    </div>
</div>
<?php /**PATH C:\laragon\www\anapharm\resources\views\bddm\layouts\searchbar.blade.php ENDPATH**/ ?>