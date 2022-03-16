								<input type="hidden" name="hopital" id="hopital">	
								<input type="hidden" name="service" id="service">	
								<div class="form-group">
	
									<label for="matricule" class="label-control"> Matricule* 

										<input type="text"  class="form-control" name="matricule" id="matricule"  placeholder="matricule" value="<?php echo e($user->matricule); ?>" required />

									</label>

								</div>



								<div class="form-group">
									
									<label for="nom" class="label-control"> Nom* 

										<input type="text"  class="form-control" name="name" id="nom"  placeholder="nom" value="<?php echo e($user->name); ?>" required />

									</label>

								</div>					

								<div class="form-group">
								
									<label for="prénom" class="label-control"> Prénom* 

										<input type="text"  class="form-control" name="prenom" id="prénom"  placeholder="prénom" value="<?php echo e($user->prenom); ?>" required />

									</label>

								</div>						
								<div class="form-group">
								
									<label for="date_naissance" class="label-control"> Date de naissance 

										<input type="date"  class="form-control" name="date_naissance" id="date_naissance"  placeholder="date_naissance" value="<?php echo e($user->date_naissance); ?>">

									</label>

								</div>	
								<div class="form-group">
									
									<label for="email" class="label-control"> Email* 

										<input type="email"  class="form-control" name="email" id="email"  placeholder="email" value="<?php echo e($user->email); ?>" autocomplete="off" required />

									</label>

								</div>						

								<div class="form-group">
									
									<label for="grade" class="label-control"> Grade </label>

										<select name="grade" id="grade" class="form-control">
											<?php
												$string = file_get_contents(public_path()."/js/json/general.json");//recuperer analyse auto
										        $json_a = json_decode($string, true);
										        foreach ($json_a as $value) {
										        	if ($value['grade'])
										        		echo "<option ". (($user->grade == ucfirst($value['grade'])) ? "selected" : "") ." >".$value['grade']."</option>";
										        }									
											?>														
										</select>

								</div>						

								<div class="form-group">
									
									<label for="specialite" class="label-control"> Spécialite </label>

										<select name="specialite" id="specialite" class="form-control">
											<option></option>
											<?php
												$string = file_get_contents(public_path()."/js/json/general.json");//recuperer analyse auto
										        $json_a = json_decode($string, true);
										        foreach ($json_a as $value) {
										        	if ($value['specialite'])
										        		echo "<option ". (($user->specialite == $value['specialite']) ? "selected" : "") ." >".$value['specialite']."</option>";
										        }									
											?>												
										</select>

								</div>	

								<div class="form-group">
									
									<label for="role" class="label-control"> Profil </label>

										<select name="role_id" id="role" class="form-control">
											
											<?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

													<option value="<?php echo e($role->id); ?>" <?php if($role->id == $user->role_id): ?> selected <?php endif; ?>><?php echo e($role->nom_profile); ?> </option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</select>

								</div>					

								<div class="form-group form-inline">
									
									<label for="password" class="label-control form-horizontal"> Mots de passe* 

										<input type="password"  class="form-control" name="password" id="password" value=""  placeholder="Mots de passe" required />
										<span style="cursor: pointer; color :red" onclick="($('#password').is(':text')) ? $('#password').prop('type', 'password') : $('#password').prop('type', 'text')">Montrer/Cacher</span>
									</label>

								</div>

								<div class="form-group">

									<div class="checkbox col-md-6">
										
										<label><input type="checkbox" name="admin" class="flat-red"<?php if($user->is_admin === "on"): ?> checked <?php endif; ?>> Administrateur</label>

									</div>
										
								</div>

<?php /**PATH C:\laragon\www\anapharm\resources\views\admin\user\includes\form.blade.php ENDPATH**/ ?>