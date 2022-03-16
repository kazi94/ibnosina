<?php echo $__env->make('user.patient.modals.annotation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('patients.update', Auth::user())): ?>
    <?php echo $__env->make('user.patient.modals.profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hospitalisations.module', Auth::user())): ?>
    <?php echo $__env->make('user.patient.modals.hospitalisation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('consultations.module', Auth::user())): ?>
    <?php echo $__env->make('user.patient.modals.consultation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptions.module', Auth::user())): ?>
    <?php echo $__env->make('user.patient.modals.prescription', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('phytotherapies.module', Auth::user())): ?>
    <?php echo $__env->make('user.patient.modals.phytotherapie', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analyses_biologique.module', Auth::user())): ?>
    <?php echo $__env->make('user.patient.modals.examen', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['automedications.module', 'traitements_chronique.module'])): ?>
<?php echo $__env->make('user.patient.modals.auto-traitement', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('educations_therapeutique.module', Auth::user())): ?>
    <?php echo $__env->make('user.patient.modals.education-therapeutique', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('questionaires.module', Auth::user())): ?>
    <?php echo $__env->make('user.patient.modals.observance', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('peut-analyser', Auth::user())): ?>
    <?php echo $__env->make('user.patient.modals.analyse-pharmaceutique', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('act_medicales.module', Auth::user())): ?>
    <?php echo $__env->make('user.patient.modals.act-medicale', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\anapharm\resources\views/user/patient/modals/modals.blade.php ENDPATH**/ ?>